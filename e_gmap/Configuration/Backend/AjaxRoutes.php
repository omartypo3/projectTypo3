<?php
/**
 * Definitions for routes provided by EXT:e_gmap
 * Contains all AJAX-based routes for entry points
 *
 * Currently the "access" property is only used so no token creation + validation is made
 * but will be extended further.
 */
return [
    // Load conf for new poi registration in backend_module
    'new_poi' => [
        'path' => '/new_poi',
        'target' => \Emagineurs\EGmap\Controller\MapController::class . '::newPoiAction'
    ],

    // Redirect to edit record for backend module
    'edit_poi' => [
        'path' => '/edit_poi',
        'target' => \Emagineurs\EGmap\Controller\MapController::class . '::editPoiAction'
    ],

    // Update the poi for backend module
    'update_poi' => [
        'path' => '/update_poi',
        'target' => \Emagineurs\EGmap\Ajax\BackendModuleAjax::class . '::updatePoi'
    ],

    // Update the list of pois for backend module
    'poi_pagination' => [
        'path' => '/poi_pagination',
        'target' => \Emagineurs\EGmap\Controller\MapController::class . '::paginatePoiAction'
    ],

    // Get the backend nformation for poi
    'info_poi_backend' => [
        'path' => '/info_poi_backend',
        'target' => \Emagineurs\EGmap\Ajax\BackendModuleAjax::class . '::getInfoPoi'
    ],
];
