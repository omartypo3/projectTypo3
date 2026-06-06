<?php

namespace NITSAN\NsRevolutionSlider\Slots;

use NITSAN\NsRevolutionSlider\Setup;
use TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Setup
 */
class InstallUtilityInvoke
{
    /**
     * @param AfterPackageActivationEvent $event
     */
    public function __invoke(AfterPackageActivationEvent $event): void
    {
        $extname = $event->getPackageKey();
        $setup = GeneralUtility::makeInstance(Setup::class)->executeOnSignal($extname);
        $installUtility = GeneralUtility::makeInstance(InstallUtility::class);
        $installUtility->executeOnSignal($extname);
    }
}
