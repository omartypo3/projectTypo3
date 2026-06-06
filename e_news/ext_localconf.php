<?php

use TYPO3\CMS\Extbase\Service\ExtensionService;

defined('TYPO3') or die();

// On ajoute les nouvelles vues dans le flexform de news via la userfunc mise à disposition
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['--div--'] = 'Vue avancées';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->filterToday'] = 'Liste aujourd\'hui';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->filterWeekend'] = 'Liste le week end prochain';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->filterWeek'] = 'Liste cette semaine';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->filterMonth'] = 'Liste ce mois-ci';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->create;News->add;News->validate'] = 'Créer une news';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->delete'] = 'Supprimer une news';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->validate'] = 'Valider une news';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][ExtensionService::class] = [
    'className' => \Emagineurs\ENews\Xclass\ExtensionServiceXclassed::class,
];

// Note: For static method calls, we need to use class_alias after the class is loaded
if (class_exists('GeorgRinger\News\Utility\Page')) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\\News\\Utility\\Page'] = [
        'className' => \Emagineurs\ENews\Xclass\PageUtility::class,
    ];
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['txEnewsPluginUpdater'] = \Emagineurs\ENews\Updates\EnewsPluginUpdater::class;

// Plugin: Filter Today
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'FilterToday',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'filterToday',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => '',
    ]
);

// Plugin: Filter Weekend
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'FilterWeekend',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'filterWeekend',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => '',
    ]
);

// Plugin: Filter Week
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'FilterWeek',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'filterWeek',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => '',
    ]
);

// Plugin: Filter Month
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'FilterMonth',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'filterMonth',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => '',
    ]
);

// Plugin: Create News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'CreateNews',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'create,add,validate',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'create,add,validate',
    ]
);

// Plugin: Delete News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'DeleteNews',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'delete',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'delete',
    ]
);

// Plugin: Validate News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ENews',
    'ValidateNews',
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'validate',
    ],
    [
        \Emagineurs\ENews\Controller\EnewsController::class => 'validate',
    ]
);

// XClass configuration moved to Services.yaml for TYPO3 v13 compatibility
// $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\News\Controller\NewsController'] = array(
//    'className' => 'Emagineurs\ENews\Controller\EnewsController'
// );
// XClass configurations moved to Services.yaml for TYPO3 v13 compatibility
// $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\News\Domain\Model\Dto\NewsDemand'] = array(
//    'className' => 'Emagineurs\ENews\Domain\Model\Dto\NewsDemandEnews'
// );
// $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\News\Domain\Model\Dto\Search'] = array(
//    'className' => 'Emagineurs\ENews\Domain\Model\Dto\SearchEnews'
// );