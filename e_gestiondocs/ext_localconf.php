<?php
defined('TYPO3') || die('Access denied.');

$boot = function ($packageKey) {
    
    // Plugin: List Documents
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'List',
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'list,search,listNew,browse,listSelected',
        ],
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'list,search,listNew,browse,listSelected',
        ]
    );

    // Plugin: Search Documents
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'Search',
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'search,list,listNew,browse,listSelected',
        ],
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'search,list,listNew,browse,listSelected',
        ]
    );

    // Plugin: List New Documents
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'ListNew',
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'listNew,list,search,browse,listSelected',
        ],
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'listNew,list,search,browse,listSelected',
        ]
    );

    // Plugin: Browse Directories
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'Browse',
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'browse,list,search,listNew,listSelected',
        ],
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'browse,list,search,listNew,listSelected',
        ]
    );

    // Plugin: List Selected Documents
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $packageKey,
        'ListSelected',
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'listSelected,list,search,listNew,browse',
        ],
        [
            \Emagineurs\EGestiondocs\Controller\DocumentController::class => 'listSelected,list,search,listNew,browse',
        ]
    );

    //Cache management - TYPO3 11+ compatible
    if(!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['e_gestiondocs'] ?? null)) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['e_gestiondocs'] = [
            'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
            'options' => [],
        ];
    }
};

$boot('EGestiondocs');
unset($boot);