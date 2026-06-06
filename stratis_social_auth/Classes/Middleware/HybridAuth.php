<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Middleware;

use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedValueException;
use Hybridauth\Hybridauth as BaseHybridAuth;
use Hybridauth\User\Profile;
use Stratis\StratisSocialAuth\Traits\LoggerTrait;
use Stratis\StratisSocialAuth\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Facade Pattern. Simplifies access to HybridAuth API
 *
 * Class HybridAuth
 * @package Stratis\StratisSocialAuth\Middleware
 */
class HybridAuth
{
    use LoggerTrait;

    /**
     * Page type for ajax calls
     */
    public const PAGE_TYPE = 1530541022;

    protected BaseHybridAuth $hybridAuth;
    protected string $baseUrl;

    /**
     * HybridAuth constructor.
     *
     * @param array $provider
     * @throws InvalidArgumentException
     */
    public function __construct(array $provider)
    {
        // @extensionScannerIgnoreLine
        $this->baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . '?type=' . self::PAGE_TYPE;

        $this->hybridAuth = new BaseHybridAuth([
            // @extensionScannerIgnoreLine
            'callback' => $this->baseUrl,
            'providers' => ConfigurationUtility::getProviderConfiguration($provider),
        ]);
    }

    /**
     * @param array $provider
     *
     * @return bool|Profile
     * @throws PropagateResponseException
     */
    public function authenticate(array $provider): Profile|bool
    {
        try {
            $adapter = $this->hybridAuth->authenticate($provider['type']);

            return $adapter->getUserProfile();
        } catch (\Exception $exception) {
            // @extensionScannerIgnoreLine
            $this->writeErrorToLog($exception->getMessage() . ' : ' . $exception->getCode());

            // @extensionScannerIgnoreLine
            $url = $this->baseUrl . '&tx_stratissocialauth_pi1[error]=' . $exception->getCode();
            $response = new RedirectResponse($url);
            throw new PropagateResponseException($response, 1692862022);
        }
    }

    /**
     * @param array $provider
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function isConnectedWithProvider(array $provider): bool
    {
        return $this->hybridAuth->isConnectedWith($provider['type']);
    }

    /**
     * @param array $provider
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function logout(array $provider): void
    {
        $providerType = strtolower($provider['type']);
        $idToken = $_SESSION['HYBRIDAUTH::STORAGE'][$providerType . '.id_token'];

        $adapter = $this->hybridAuth->getAdapter($provider['type']);
        $_SESSION['HYBRIDAUTH::STORAGE'][$providerType . '.id_token'] = $idToken;

        $adapter->disconnect();
    }

    /**
     * @param array $provider
     * @return Profile
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function getUser(array $provider): Profile
    {
        $adapter = $this->hybridAuth->getAdapter($provider['type']);

        return $adapter->getUserProfile();
    }
}
