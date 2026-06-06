<?php

declare(strict_types=1);

use Emagineurs\EGmap\Controller\LocalizeController;
use Emagineurs\EGmap\Controller\MapController;
use Emagineurs\EGmap\Controller\GeolocController;

return [
    'web_EGmapGmap' => [
        'parent' => 'web',
        'position' => ['after' => 'web_list'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'path' => '/module/web/EGmapGmap',
        'labels' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_gmap.xlf',
        'iconIdentifier' => 'egmap-gmap-module-icon',
        'extensionName' => 'EGmap',
        'controllerActions' => [
            LocalizeController::class => [
                'index'
            ],
            MapController::class => [
                'placement'
            ],
        ],
    ],
    'tools_EGmapGeoloc' => [
        'parent' => 'tools',
        'position' => ['after' => 'tools_ExtensionmanagerExtensionmanager'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'path' => '/module/tools/EGmapGeoloc',
        'labels' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_geoloc.xlf',
        'iconIdentifier' => 'egmap-geoloc-module-icon',
        'extensionName' => 'EGmap',
        'controllerActions' => [
            GeolocController::class => [
                'index', 'validate'
            ],
        ],
    ],
];

