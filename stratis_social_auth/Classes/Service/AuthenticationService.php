<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Service;

use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedValueException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\ConfigurationRepository;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\ProviderRepository;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\UserRepository;
use Stratis\StratisSocialAuth\Exception\BadConfigException;
use Stratis\StratisSocialAuth\Middleware\HybridAuth;
use Stratis\StratisSocialAuth\Traits\LoggerTrait;
use Stratis\StratisSocialAuth\Utility\RequestUtility;
use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AuthenticationService
 * @package Stratis\StratisSocialAuth\Service
 */
class AuthenticationService extends AbstractAuthenticationService
{
    use ContainerAwareTrait;
    use LoggerTrait;

    /**
     * Authentication failed in this service. User can be authenticated by another one
     */
    public const AUTH_SERVICE_FAIL = 100;

    /**
     * Authentication success
     */
    public const AUTH_SUCCESS = 200;

    /**
     * For FE authentication only
     */
    public string $loginType = 'FE';
    protected array $request;
    protected HybridAuth $hybridAuth;
    protected array $provider;
    protected array $configuration;

    /**
     *  Whether the service was initialized with correct enabled provider
     */
    protected bool $isAvailable = false;
    protected ?AbstractUserAuthentication $userAuthentication = null;

    /**
     * Required method
     *
     * @see GeneralUtility::makeInstanceService
     * @return bool
     */
    public function init(): bool
    {
        $this->request = RequestUtility::fromRequest('tx_stratissocialauth_pi1') ??
            RequestUtility::fromRequest('tx_stratissocialauth_pi2') ?? [];

        return parent::init();
    }

    /**
     * @param string $subType
     * @param array $loginData
     * @param array $authInfo
     * @param AbstractUserAuthentication $userAuthentication
     */
    public function initAuth($subType, $loginData, $authInfo, $userAuthentication): void
    {
        $this->userAuthentication = $userAuthentication;

        if ($this->canAuth($userAuthentication)) {
            $this->initProviderAndConfiguration();
            $this->isAvailable = true;

            $this->hybridAuth = GeneralUtility::makeInstance(HybridAuth::class, $this->provider);

            // write configuration to user session
            $userAuthentication->setSessionData('socialProvider', (string)$this->request['provider']);
            $userAuthentication->setSessionData('socialConfiguration', (string)$this->request['configuration']);
            $loginPage = RequestUtility::fromRequest('login_page');
            if ($loginPage) {
                $userAuthentication->setSessionData('loginPage', $loginPage);
            }

            // @extensionScannerIgnoreLine
            $userAuthentication->storeSessionData();
        }

        parent::initAuth($subType, $loginData, $authInfo, $userAuthentication);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function initProviderAndConfiguration(): void
    {
        $this->provider = $this->getContainer()
            ->get(ProviderRepository::class)
            ->findByUid((int) $this->request['provider']);

        $this->configuration =  $this->getContainer()
            ->get(ConfigurationRepository::class)
            ->findByUid((int) $this->request['configuration']);

        if (empty($this->provider)) {
            throw new BadConfigException('Wrong social network provider provided!', 1530606639);
        }

        if (empty($this->configuration)) {
            throw new BadConfigException('Wrong social network configuration provided!', 1530631878);
        }
    }

    /**
     * @param AbstractUserAuthentication $userAuthentication
     * @return bool
     */
    protected function canAuth(AbstractUserAuthentication $userAuthentication): bool
    {
        if (in_array(RequestUtility::fromRequest('type'), [1530541022])) {
            return false;
        }

        // fetch data from user session only if state parameter in request
        if (RequestUtility::fromRequest('state')) {
            if (empty($this->request['provider'])) {
                $this->request['provider'] = $userAuthentication->getSessionData('socialProvider');
            }
            if (empty($this->request['configuration'])) {
                $this->request['configuration'] = $userAuthentication->getSessionData('socialConfiguration');
            }
        }

        return isset($this->request['provider']) && isset($this->request['configuration']);
    }

    /**
     * @param array $user
     * @return int
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function authUser(array $user): int
    {
        $feLogin = RequestUtility::fromRequest('tx_felogin_login');

        if ($feLogin) {
            return self::AUTH_SERVICE_FAIL;
        }

        $isConnectedWithProvider = $this->hybridAuth->isConnectedWithProvider($this->provider);

        if ((bool) $user['fromHybrid'] && $isConnectedWithProvider) {
            return self::AUTH_SUCCESS;
        }

        return self::AUTH_SERVICE_FAIL;
    }

    /**
     * @return bool|array
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     * @throws PropagateResponseException
     * @throws UnexpectedValueException
     */
    public function getUser(): bool|array
    {
        if ($this->isAvailable) {
            try {
                if ($this->hybridAuth->isConnectedWithProvider($this->provider)) {
                    $externalUser = $this->hybridAuth->getUser($this->provider);
                } else {
                    $response = $this->userAuthentication->appendCookieToResponse(new Response());

                    foreach ($response->getHeaders() as $key => $values) {
                        header($key . ': ' . implode(';', $values), true);
                    }

                    $externalUser = $this->hybridAuth->authenticate($this->provider);
                }
            } catch (PropagateResponseException $exception) {
                throw $exception;
            } catch (\Throwable $exception) {
                $this->writeErrorToLog($exception->getMessage() . ' : ' . $exception->getCode());
                $this->hybridAuth->logout($this->provider);

                return false;
            }

            if ($externalUser === false) {
                return false;
            }

            return $this->getContainer()
                ->get(UserRepository::class)
                ->getUser($this->configuration, $this->provider, $externalUser);
        }

        return false;
    }
}
