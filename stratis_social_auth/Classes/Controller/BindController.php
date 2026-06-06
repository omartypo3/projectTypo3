<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Controller;

use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Stratis\StratisSocialAuth\Domain\Model\Configuration;
use Stratis\StratisSocialAuth\Domain\Repository\ConfigurationRepository;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\ProviderRepository;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\SocialAccountRepository;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\UserRepository;
use Stratis\StratisSocialAuth\Middleware\HybridAuth;
use Stratis\StratisSocialAuth\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class BindController
 * @package Stratis\StratisSocialAuth\Controller
 */
class BindController extends AbstractController
{
    /**
     * BindController constructor.
     * @param ProviderRepository $providerRepository
     * @param SocialAccountRepository $socialAccountRepository
     * @param UserRepository $userRepository
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct(
        protected ProviderRepository $providerRepository,
        protected SocialAccountRepository $socialAccountRepository,
        protected UserRepository $userRepository,
        ConfigurationRepository $configurationRepository
    ) {
        parent::__construct($configurationRepository);
    }

    /**
     * @param Configuration $configuration
     * @param int $provider
     * @return ResponseInterface
     * @throws PropagateResponseException
     * @throws AspectNotFoundException|Exception
     */
    public function bindAction(Configuration $configuration, int $provider): ResponseInterface
    {
        $context = GeneralUtility::makeInstance(Context::class);

        // only authenticated users are allowed to bind accounts
        if (isset($GLOBALS['TSFE']) === false || $context->getPropertyFromAspect('frontend.user', 'isLoggedIn') === false) {
            return $this->redirectToList('bind.noLocalAuth');
        }

        $provider = $this->providerRepository->findByUid($provider);
        $uri = $this->uriBuilder
            ->setCreateAbsoluteUri(true)
            ->buildFrontendUri();

        /** @var AbstractUserAuthentication $userAuthentication */
        $userAuthentication = $GLOBALS['TSFE']->fe_user;
        $userAuthentication->setSessionData('socialProvider', (string)$provider['uid']);
        $userAuthentication->setSessionData('socialConfiguration', (string)$configuration->getUid());
        $userAuthentication->setSessionData('redirectUri', $uri);

        // @extensionScannerIgnoreLine
        $userAuthentication->storeSessionData();

        $hybridAuth = GeneralUtility::makeInstance(HybridAuth::class, $provider);
        $externalUser = $hybridAuth->authenticate($provider);

        if (empty($externalUser)) {
            return $this->redirectToList('bind.noExternalAuth');
        }

        return $this->redirectToList('bind.success');
    }

    /**
     * @param string $message
     * @return ResponseInterface
     */
    protected function redirectToList(string $message = ''): ResponseInterface
    {
        $this->addFlashMessage(LocalizationUtility::translateMessage($message));

        return $this->redirect('list');
    }
}
