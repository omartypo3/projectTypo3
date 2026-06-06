<?php

namespace Nitsan\NsRevolutionSlider;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Setup
{
    public static function executeOnSignal(): void
    {
        $extname = 'ns_revolution_slider';
        $flag = true;

        \TYPO3\CMS\Core\Utility\DebugUtility::debug("test*");
        die();

        $packageManager = GeneralUtility::makeInstance(PackageManager::class);
        $isNsLicenseActive = $packageManager->isPackageActive('ns_license');

        if ($isNsLicenseActive) {
            $nsLicenseModule = GeneralUtility::makeInstance(\Nitsan\NsLicense\Controller\NsLicenseModuleController::class);
            $installed = $nsLicenseModule->connectToServer($extname, 1);
            if ($installed) {
                $flag = false;
            }
        } else {
            $licenseData = self::fetchLicense('domain=' . GeneralUtility::getIndpEnv('HTTP_HOST') . '&ns_key=' . $extname);
            if (!$licenseData?->status) {
                $flag = false;
            }
        }

        if ($flag) {
            $siteRoot = Environment::getPublicPath() . '/';
            $extFolder = $siteRoot . 'typo3conf/ext/' . $extname . '/';
            self::updateFiles($extFolder, $extname);
        }
    }

    public static function fetchLicense(string $license): ?object
    {
        $url = 'https://composer.t3terminal.com/API/GetComposerDetails.php?' . $license;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        $response = curl_exec($curl);
        if (!$response) {
            error_log('License fetch error: ' . curl_error($curl));
        }

        curl_close($curl);

        return json_decode($response);
    }

    public static function updateFiles(string $extFolder, string $extension): void
    {
        if (file_exists($extFolder . 'ext_tables.php')) {
            rename($extFolder . 'ext_tables.php', $extFolder . 'ext_tables..php');
        }

        if (file_exists($extFolder . 'Configuration/TCA/Overrides/sys_template.php')) {
            rename($extFolder . 'Configuration/TCA/Overrides/sys_template.php', $extFolder . 'Configuration/TCA/Overrides/sys_template..php');
        }

        if (file_exists($extFolder . 'Configuration')) {
            rename($extFolder . 'Configuration', $extFolder . 'Configuration.');
        }

        if (file_exists($extFolder . 'Resources')) {
            rename($extFolder . 'Resources', $extFolder . 'Resources.');
        }

        try {
            self::unloadExtension($extension);
        } catch (\Throwable $e) {
            // Log the error instead of using FlashMessage (which isn't available in this context)
            error_log('Extension unload error for ' . $extension . ': ' . $e->getMessage());
        }
    }

    protected static function unloadExtension(string $extensionKey): void
    {
        $packageManager = GeneralUtility::makeInstance(PackageManager::class);
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        $packageManager->deactivatePackage($extensionKey);
        $cacheManager->flushCachesInGroup('system');
    }
}
