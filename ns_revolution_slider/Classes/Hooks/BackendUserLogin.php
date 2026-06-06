<?php

namespace NITSAN\NsRevolutionSlider\Hooks;

use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 */
class BackendUserLogin
{
    public function dispatch(array $backendUser)
    {
        $flag = true;
        $activePackages = GeneralUtility::makeInstance(PackageManager::class)->isPackageActive('ns_license');
        $this->setup = GeneralUtility::makeInstance(\NITSAN\NsRevolutionSlider\Setup::class);
        if ($activePackages) {
            $this->nsLicenseModule = GeneralUtility::makeInstance(\NITSAN\NsLicense\Controller\NsLicenseModuleController::class);
            $installed = $this->nsLicenseModule->connectToServer('ns_revolution_slider');
            if ($installed) {
                $flag = false;
            }
        } else {
            $licenseData = $this->setup->fetchLicense('domain=' . GeneralUtility::getIndpEnv('HTTP_HOST') . '&ns_key=ns_revolution_slider');
            if (!$licenseData->status) {
                $flag = false;
            }
        }
        if ($flag) {
            if (version_compare(TYPO3_branch, '9.0', '>')) {
                $this->siteRoot = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/';
            } else {
                $this->siteRoot = PATH_site;
            }
            $this->setup->updateFiles($this->siteRoot . '/typo3conf/ext/ns_revolution_slider/', 'ns_revolution_slider');
        }
    }
}
