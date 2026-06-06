<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Controller;

use Psr\Http\Message\ResponseInterface;
use Stratis\StratisSocialAuth\Utility\LocalizationUtility;
use Stratis\StratisSocialAuth\Utility\RequestUtility;
use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AuthController
 * @package Stratis\StratisSocialAuth\Controller
 */
class AuthController extends AbstractController
{
    public const AUTH_PAGE = 92;

    /**
     * @param string|null $provider
     * @param string $redirect
     * @return ResponseInterface
     * @throws AspectNotFoundException
     */
    public function authAction(?string $provider = null, string $redirect = ''): ResponseInterface
    {
        $redirect = urldecode($redirect);
        $context = GeneralUtility::makeInstance(Context::class);

        if ($context->getPropertyFromAspect('frontend.user', 'isLoggedIn') && is_array($GLOBALS['TSFE']->fe_user->user)) {
            //sanitize url with logintype=logout
            $redirect = preg_replace('/(&?logintype=logout)/i', '', $redirect);
        }

        if ($redirect === null) {
            $pageArguments = $this->request->getAttribute('routing');
            $pageId = $pageArguments?->getPageId() ?? 0;
            $this->uriBuilder->setTargetPageUid((int)$pageId);
            $redirect = $this->uriBuilder->build();
        }

        return $this->redirectToUri($redirect);
    }

    /**
     * @param int $error
     * @return ResponseInterface
     */
    public function endpointAction(int $error = 0): ResponseInterface
    {
        $redirectUri = $this->resolveRedirectUri();

        // redirect if error
        if ($error > 0 || !empty(RequestUtility::fromRequest('error'))) {
            $error = in_array($error, range(0, 7)) ? '.' . $error : '';
            $this->addFlashMessage(
                LocalizationUtility::translateMessage('hybridauth.error' . $error),
                '',
                ContextualFeedbackSeverity::ERROR
            );

            return $this->redirectToUri($redirectUri);
        }

        // redirect if logout
        if (RequestUtility::fromRequest('logintype') == 'logout') {
            $redirectUri = $this->resolveRedirectUri('logout');

            return $this->redirectToUri($redirectUri);
        }

        // redirect if bind
        $uri = $this->getRedirectUriFromSession();
        if ($uri) {
            return $this->redirectToUri($uri);
        }

        // redirect if login
        $state = RequestUtility::fromRequest('state');
        $code = RequestUtility::fromRequest('code');

        if ($state && $code) {
            $arguments = [
                'logintype' => 'login',
                'state' => $state,
                'code' => $code,
            ];

            $redirectUri .= '?' . http_build_query($arguments);
        }

        return $this->redirectToUri($redirectUri);
    }

    /**
     * @return string
     */
    private function resolveRedirectUri(string $type = ''): string
    {
        $site = $this->request->getAttribute('site');
        $configuration = $site->getConfiguration();

        if ($configuration['franceConnect']) {
            $page = (int) $configuration['franceConnect']['success_redirect_page_uid'];

            if ($type && $type === 'logout') {
                $page = (int) $configuration['franceConnect']['logout_redirect_page_uid'];
            }
        }

        return $this->uriBuilder
            ->reset()
            ->setTargetPageUid($page ?? self::AUTH_PAGE)
            ->setLinkAccessRestrictedPages(true)
            ->build();
    }

    /**
     * @return string
     */
    private function getRedirectUriFromSession(): string
    {
        /** @var AbstractUserAuthentication $userAuthentication */
        $userAuthentication = $GLOBALS['TSFE']->fe_user;
        $uri = $userAuthentication->getSessionData('redirectUri');

        if ($uri) {
            $userAuthentication->setAndSaveSessionData('redirectUri', '');

            return $uri;
        }

        return '';
    }
}
