<?php

use NITSAN\NsRevolutionSlider\Controller\BackendController;

return [
    'ns_revolution_slider' => [
        'parent' => 'web',
        'position' => [],
        'access' => 'user,group',
        'iconIdentifier' => 'ns_revolution_slider',
        'labels' => 'LLL:EXT:ns_revolution_slider/Resources/Private/Language/locallang_ns.xlf:lang_labels_tablabel',
        'path' => '/module/ns_revolution_slider',

        // ✅ Must be UpperCamelCase
        'extensionName' => 'NsRevolutionSlider',

        'controllerActions' => [
            BackendController::class => [
                'index'
            ],
        ],
    ],
];
