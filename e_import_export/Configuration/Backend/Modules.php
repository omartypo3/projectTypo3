<?php

declare(strict_types=1);

use Emagineurs\EImportExport\Controller\ModuleController;

return [
    'tools_EImportExportModule' => [
        'parent' => 'tools',
        'position' => ['after' => 'tools_ExtensionmanagerExtensionmanager'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'path' => '/module/tools/EImportExportModule',
        'labels' => 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_modexport.xlf',
        'iconIdentifier' => 'eimportexport-module-icon',
        'extensionName' => 'EImportExport',
        'controllerActions' => [
            ModuleController::class => [
                'index'
            ],
        ],
    ],
];

