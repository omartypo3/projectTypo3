<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_simple_service_location',
    [
        'default' => "title, changemodem, --palette--;Adresse;addressBlock, description",
    ]
);

$defaultFields = 'name, lang';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'title',
		'label_alt' => 'zip, city',
		'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ),
        'sortby' => 'sorting',
        'searchFields' => $defaultFields,
        'iconfile' => $helper->getIconPath(),
    ),
    'interface' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'addressBlock' => array('showitem' => "zip, city"),
        'coordinates' => array('showitem' => "lat, lng"),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
            'description' => $helper->getRTETextColumnsConfig('description'),
            //'logo' => $helper->getFalMediaColumnConfig('logo', 'logo', 'png, jpg, jpeg'),

            'zip' => $helper->getInputColumnsConfig('zip', true, 'int'),
            'city' => $helper->getInputColumnsConfig('city'),
			'changemodem' => $helper->getCheckboxColumnConfig('changemodem'),

            'lat' => $helper->getInputColumnsConfig('lat', true, 'double2, trim'),
            'lng' => $helper->getInputColumnsConfig('lng', true, 'double2, trim'),
            // FIELDS END
        )
    ),

);