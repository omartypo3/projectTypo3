<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

call_user_func(function () {

    // Plugin for auth
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'StratisSocialAuth',
        'Pi1',
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'list, auth, endpoint'],
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'auth, endpoint'],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

    // Plugin for bind
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'StratisSocialAuth',
        'Pi2',
        [\Stratis\StratisSocialAuth\Controller\BindController::class => 'list, bind'],
        [\Stratis\StratisSocialAuth\Controller\BindController::class => 'list, bind'],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

    // Plugin for ajax auth calls handling
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'StratisSocialAuth',
        'Pi3',
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'auth'],
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'auth'],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

    // Ajax endpoint calls handling for stratis_social_auth
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'StratisSocialAuth',
        'Pi4',
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'endpoint',],
        [\Stratis\StratisSocialAuth\Controller\AuthController::class => 'endpoint',],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        'StratisSocialAuth',
        'auth',
        \Stratis\StratisSocialAuth\Service\AuthenticationService::class,
        [
            'title' => 'Stratis Social Auth',
            'description' => 'Authentication in TYPO3 systems using social networks API',
            'subtype' => 'authUserFE,getUserFE',
            'available' => true,
            'priority' => 95,
            'quality' => 95,
            'os' => '',
            'exec' => '',
            'className' => \Stratis\StratisSocialAuth\Service\AuthenticationService::class,
        ]
    );

    // Exclude plugin actions arguments to avoid caching
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_stratissocialauth_pi1[provider]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_stratissocialauth_pi1[redirect]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_stratissocialauth_pi1[error]';

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;
});
