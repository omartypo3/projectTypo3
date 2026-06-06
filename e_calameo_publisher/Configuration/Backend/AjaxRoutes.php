<?php



return [
    'calemeopublish' => [
        'path' => '/calemeopublish',
        'target' => \Emagineurs\ECalameoPublisher\Controller\CalameoModuleController::class . '::publishAction'
    ],
    'calemeodelete' => [
        'path' => '/calemeodelete',
        'target' => \Emagineurs\ECalameoPublisher\Controller\CalameoModuleController::class . '::deleteAction'
    ]
];
