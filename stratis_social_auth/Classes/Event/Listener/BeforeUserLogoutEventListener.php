<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Event\Listener;

use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedValueException;
use Stratis\Common\Xclass\Authentication\FrontendUserAuthentication;
use Stratis\StratisServices\DependencyInjection\ContainerAwareTrait;
use Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder\ProviderRepository;
use Stratis\StratisSocialAuth\Middleware\HybridAuth;
use TYPO3\CMS\Core\Authentication\Event\BeforeUserLogoutEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class BeforeUserLogoutEventListener
{
    use ContainerAwareTrait;

    /**
     * @param BeforeUserLogoutEvent $event
     * @return void
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function __invoke(BeforeUserLogoutEvent $event): void
    {
        $userAuthentication = $event->getUser();
        if ($userAuthentication instanceof FrontendUserAuthentication) {
            $providerUid = (int)$userAuthentication->getSessionData('socialProvider');

            if (empty($providerUid)) {
                return;
            }

            $userAuthentication->removeSessionData();

            $provider = $this->getContainer()
                ->get(ProviderRepository::class)
                ->findByUid($providerUid);

            if (empty($provider)) {
                return;
            }

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();

            /** @var HybridAuth $hybridAuth */
            $hybridAuth = GeneralUtility::makeInstance(HybridAuth::class, $provider);
            $hybridAuth->logout($provider);
        }
    }
}
