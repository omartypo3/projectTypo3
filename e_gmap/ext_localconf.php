<?php
defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'EGmap',
    'Gmap',
    [
        \Emagineurs\EGmap\Controller\MapController::class => 'map'
    ],
    [
        \Emagineurs\EGmap\Controller\MapController::class => 'map'
    ]
);


$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['eGmapInfoPoi'] = \Emagineurs\EGmap\Ajax\InfoPoiAjax::class . '::main';


$GLOBALS['TYPO3_CONF_VARS']['BE']['AJAX']['EGmapLocalizeUpdate'] = [
    'callbackMethod' => \Emagineurs\EGmap\Controller\LocalizeController::class . '->updateAction',
    'csrfTokenCheck' => false
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:e_gmap/Configuration/TSConfig/pageTSConfig.txt">'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    'e_gmap',
    'setup',
    '@import "EXT:e_gmap/Configuration/TypoScriptForce/TSExtbasePersistent.txt"'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Emagineurs\EGmap\Task\LocalizeTask::class] = [
    'extension' => 'e_gmap',
    'title' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:LocalizeTask.name',
    'description' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:LocalizeTask.description',
    'additionalFields' => \Emagineurs\EGmap\Task\LocalizeAdditionalFieldProvider::class
];
$icons = [
    'ext-map-wizard-icon' => 'ext_icon.svg',
    'egmap-gmap-module-icon' => 'map_icon.gif',
    'egmap-geoloc-module-icon' => 'ux_geoloc.jpg',
];
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
foreach ($icons as $identifier => $path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $iconProvider = $extension === 'svg' 
        ? \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class 
        : \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class;
    
    $iconRegistry->registerIcon(
        $identifier,
        $iconProvider,
        ['source' => 'EXT:e_gmap/Resources/Public/Icons/' . $path]
    );
}

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['egmap'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['egmap'] = [
        'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
        'backend' => \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class,
        'options' => [
            'defaultLifetime' => 604800, // 7 days
        ],
    ];
}
