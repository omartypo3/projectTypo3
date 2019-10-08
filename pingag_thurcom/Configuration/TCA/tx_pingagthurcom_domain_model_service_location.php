<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_service_location',
    [
        'default' => "title, --palette--;Adresse;addressBlock, extra_city, --palette--;Kontaktdaten;contactBlock, --palette--;;infoBlock, --palette--;, logo, contact_person",
        'tabs.options' => "service_options, extra_text, extra_url",
    ]
);

$defaultFields = 'title, zip, lang';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'title',
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
        'addressBlock' => array('showitem' => "address, zip, city"),
        'contactBlock' => array('showitem' => "telephone, email"),
        'infoBlock' => array('showitem' => "website, description"),
        'coordinates' => array('showitem' => "lat, lng"),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
            'address' => $helper->getInputColumnsConfig('address'),
            'zip' => $helper->getInputColumnsConfig('zip', true, 'int'),
            'city' => $helper->getInputColumnsConfig('city'),
            'extra_city' => $helper->getInputColumnsConfig('extra_city', false),

            'telephone' => $helper->getInputColumnsConfig('telephone'),
            'email' => $helper->getInputColumnsConfig('email', false),
            'website' => $helper->getInputColumnsConfig('website', false, 'domainname'),
            'description' => $helper->getRTETextColumnsConfig('description'),

            'logo' => $helper->getFalMediaColumnConfig('logo', 'logo', 'png, jpg, jpeg'),

            'lat' => $helper->getInputColumnsConfig('lat', false, 'double2, trim'),
            'lng' => $helper->getInputColumnsConfig('lng', false, 'double2, trim'),

            'contact_person' => $helper->getInlineColumnConfig('contact_person', 'tx_pingagthurcom_domain_model_contact_person', 1, 0),
            'service_options' => $helper->getInlineColumnConfig('service_options', 'tx_pingagthurcom_domain_model_service_option', 10, 0),

            'extra_text' => $helper->getRTETextColumnsConfig('extra_text'),
            'extra_url' => $helper->getInputColumnsConfig('extra_url', false, 'url'),
            // FIELDS END
        )
    ),

);