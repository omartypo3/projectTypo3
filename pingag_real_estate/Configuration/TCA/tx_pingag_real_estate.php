<?php

defined('TYPO3_MODE') or die();

$table = 'tx_pingag_real_estate';
$extKey = 'pingag_real_estate';
$helper = new \Pingag\PingagRealEstate\Util\TCAHelper(
    $table,
    $extKey,
    [
        'default' => "object_title,object_description,--palette--;Preise;price,--palette--;Adresse;addressPalette",
        'tabs.files' => 'pictures,documents',
        'tabs.properties' => '--palette--;Kategorien;category,--palette--;Allgemein;propsGeneral, --palette--;Eigenschaften;propsExtra, --palette--;Distanzen;propsNearBy',
        'tabs.contact' => '--palette--;Anbieter;agency,--palette--;Besichtigungsperson;visit',
        'tabs.import' => 'version,sender_id',
    ]
);

return [
    'ctrl' => [
        'title' => $helper->trans('entity_title'),
        //'descriptionColumn' => 'notes',
        'label' => 'object_title',
        'prependAtCopy' => '',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'default_sortby' => 'ORDER BY uid DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => $helper->getIconPath(),
        'searchFields' => 'uid,object_title,object_street,ref_object',
        //'thumbnail' => $configuration->isMediaPreview() ? 'fal_media' : '',
    ],
    'interface' => $helper->getInterfaceConfig(),
    'types' => $helper->getTypesConfig(),
    'columns' => $helper->getBaseColumns() + [
        'version' => $helper->getInputColumnsConfig('version'),
        'sender_id' => $helper->getInputColumnsConfig('sender_id'),
        'last_modified' => $helper->getInputColumnsConfig('last_modified'),
        'url' => $helper->getInputColumnsConfig('url', false, 'url'),
		'sparefield_2' => $helper->getInputColumnsConfig('sparefield_2', false, 'sparefield_2'),
        'object_category' => $helper->getInputColumnsConfig('object_category'),
        'object_type' => $helper->getInputColumnsConfig('object_type'),
        'offer_type' => $helper->getInputColumnsConfig('offer_type'),
        'ref_property' => $helper->getInputColumnsConfig('ref_property'),
        'ref_house' => $helper->getInputColumnsConfig('ref_house'),
        'ref_object' => $helper->getInputColumnsConfig('ref_object'),
        'object_street' => $helper->getInputColumnsConfig('object_street'),
        'object_zip' => $helper->getInputColumnsConfig('object_zip'),
        'object_city' => $helper->getInputColumnsConfig('object_city'),
        'object_state' => $helper->getInputColumnsConfig('object_state'),
        'object_country' => $helper->getInputColumnsConfig('object_country'),
        'region' => $helper->getInputColumnsConfig('region'),
        'object_situation' => $helper->getInputColumnsConfig('object_situation'),
        'available_from' => $helper->getInputColumnsConfig('available_from'),
        'object_title' => $helper->getInputColumnsConfig('object_title'),
        'object_description' => $helper->getRTETextColumnsConfig('object_description'),
        'selling_price' => $helper->getInputColumnsConfig('selling_price'),
        'rent_net' => $helper->getInputColumnsConfig('rent_net'),
        'rent_extra' => $helper->getInputColumnsConfig('rent_extra'),
        'price_unit' => $helper->getInputColumnsConfig('price_unit'),
        'price' => $helper->getInputColumnsConfig('price'),
        'currency' => $helper->getInputColumnsConfig('currency'),
        'gross_premium' => $helper->getInputColumnsConfig('gross_premium'),
        'floor' => $helper->getInputColumnsConfig('floor'),
        'number_of_rooms' => $helper->getInputColumnsConfig('number_of_rooms'),
        'number_of_floors' => $helper->getInputColumnsConfig('number_of_floors'),
        'number_of_apartments' => $helper->getInputColumnsConfig('number_of_apartments'),
        'surface_living' => $helper->getInputColumnsConfig('surface_living'),
        'surface_usable' => $helper->getInputColumnsConfig('surface_usable'),
        'surface_property' => $helper->getInputColumnsConfig('surface_property'),
        'year_built' => $helper->getInputColumnsConfig('year_built'),
        'year_renovated' => $helper->getInputColumnsConfig('year_renovated'),

        'prop_elevator' => $helper->getCheckboxColumnConfig('prop_elevator'),
        'prop_balcony' => $helper->getCheckboxColumnConfig('prop_balcony'),
        'prop_parking' => $helper->getCheckboxColumnConfig('prop_parking'),
        'prop_garage' => $helper->getCheckboxColumnConfig('prop_garage'),
        'prop_child_friendly' => $helper->getCheckboxColumnConfig('prop_child_friendly'),
        'prop_view' => $helper->getCheckboxColumnConfig('prop_view'),
        'prop_fireplace' => $helper->getCheckboxColumnConfig('prop_fireplace'),
        'prop_cabletv' => $helper->getCheckboxColumnConfig('prop_cabletv'),
        'swimmingpool' => $helper->getCheckboxColumnConfig('swimmingpool'),
        'isdn' => $helper->getCheckboxColumnConfig('isdn'),
        'new_building' => $helper->getCheckboxColumnConfig('new_building'),
        'minergie_general' => $helper->getCheckboxColumnConfig('minergie_general'),
        'wheelchair_accessible' => $helper->getCheckboxColumnConfig('wheelchair_accessible'),
        'animal_allowed' => $helper->getCheckboxColumnConfig('animal_allowed'),
        'ramp' => $helper->getInputColumnsConfig('ramp'),
        'railway_terminal' => $helper->getInputColumnsConfig('railway_terminal'),
            
        'distance_shop' => $helper->getInputColumnsConfig('distance_shop'),
        'distance_kindergarten' => $helper->getInputColumnsConfig('distance_kindergarten'),
        'distance_school1' => $helper->getInputColumnsConfig('distance_school1'),
        'distance_school2' => $helper->getInputColumnsConfig('distance_school2'),
        'distance_motorway' => $helper->getInputColumnsConfig('distance_motorway'),
            
        'agency_id' => $helper->getInputColumnsConfig('agency_id'),
        'agency_name' => $helper->getInputColumnsConfig('agency_name'),
        'agency_name_2' => $helper->getInputColumnsConfig('agency_name_2'),
        'agency_reference' => $helper->getInputColumnsConfig('agency_reference'),
        'agency_phone' => $helper->getInputColumnsConfig('agency_phone'),
        'agency_fax' => $helper->getInputColumnsConfig('agency_fax'),
        'agency_email' => $helper->getInputColumnsConfig('agency_email'),
        'agency_street' => $helper->getInputColumnsConfig('agency_street'),
        'agency_zip' => $helper->getInputColumnsConfig('agency_zip'),
        'agency_city' => $helper->getInputColumnsConfig('agency_city'),

        'object_x' => $helper->getInputColumnsConfig('object_x'),
        'object_y' => $helper->getInputColumnsConfig('object_y'),
            
        'visit_name' => $helper->getInputColumnsConfig('visit_name'),
        'visit_phone' => $helper->getInputColumnsConfig('visit_phone'),
        'visit_email' => $helper->getInputColumnsConfig('visit_email'),
            
        'pictures' => $helper->getFalFilesColumnConfig('pictures', 'tx_pingag_real_estate', 'pictures'),
        'documents' => $helper->getFalFilesColumnConfig('documents', 'tx_pingag_real_estate', 'documents'),
    ],
    'palettes' => [
        'addressPalette' => [
            'showitem' => 'object_street,--div--,object_zip,object_city,object_state,object_country,region,object_x,object_y,url,sparefield_2',
        ],
        'price' => [
            'showitem' => 'selling_price,rent_net,rent_extra,price_unit,currency',
        ],
        'category' => [
            'showitem' => 'object_category,object_type,offer_type',
        ],
        'propsGeneral' => [
            'showitem' => 'floor,number_of_rooms,surface_living,surface_usable,year_built',
        ],
        'propsExtra' => [
            'showitem' => 'prop_balcony,prop_garage,prop_parking,wheelchair_accessible,animal_allowed,prop_elevator,new_building,minergie_general,prop_child_friendly',
        ],
        'propsNearBy' => [
            'showitem' => 'distance_public_transport,distance_shop,distance_kindergarten,distance_school1,distance_school2',
        ],
        'agency' => [
            'showitem' => 'agency_id,--linebreak--,agency_name,agency_reference,--linebreak--,agency_phone,agency_email',
        ],
        'visit' => [
            'showitem' => 'visit_name,visit_phone',
        ],
    ],

];