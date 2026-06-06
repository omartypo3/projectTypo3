<?php
defined('TYPO3') || die;

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'StratisMobileapp',
        'Pi1',
        [
            Stratis\StratisMobileapp\Controller\SettingsController::class => 'index',
        ],
        [
            Stratis\StratisMobileapp\Controller\SettingsController::class => 'index',
        ]
    );

});

