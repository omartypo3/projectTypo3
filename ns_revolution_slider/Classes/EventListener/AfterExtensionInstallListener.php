<?php

declare(strict_types=1);

namespace Nitsan\NsRevolutionSlider\EventListener;

use Nitsan\NsRevolutionSlider\Setup;

final class AfterExtensionInstallListener
{
    public function __invoke(AfterExtensionInstallEvent $event): void
    {
        \TYPO3\CMS\Core\Utility\DebugUtility::debug("test*");
        die();
        if ($event->getExtensionKey() === 'ns_revolution_slider') {
            Setup::executeOnSignal();
        }
    }
}
