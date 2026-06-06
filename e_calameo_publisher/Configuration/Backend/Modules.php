<?php

declare(strict_types=1);

use Emagineurs\ECalameoPublisher\Controller\CalameoModuleController;

return [

  'file_EcalameoPublisher' => [
    'parent' => 'file',
    'position' => ['after' => 'file_list'],
    'access' => 'user',
    'workspaces' => 'live',
    'path' => '/module/file/EcalameoPublisher',
    'labels' => 'LLL:EXT:e_calameo_publisher/Resources/Private/Language/locallang_mod.xlf:mlang_tabs_tab',
    'iconIdentifier' => 'ecalameo-module-icon',
    'extensionName' => 'e_calameo_publisher',

    'controllerActions' => [
      CalameoModuleController::class => [
        'index',
        'list',
        'publish',
        'reponse',
        'deleteReponse'
      ],
    ],
  ],
];
