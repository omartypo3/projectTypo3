<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_city',
    [
        'default' => "title, --palette--;Adresse;addressBlock",
        'tabs.options' => "netzbetreiber, servicestellen, service_options, extra_text, extra_url",
    ]
);

$defaultFields = 'title, zip';

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
        'addressBlock' => array('showitem' => "zip, additional_zips"),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
            'zip' => $helper->getInputColumnsConfig('zip', true, 'int'),
            'additional_zips' => $helper->getInputColumnsConfig('additional_zips', false),

            'netzbetreiber' => $helper->getTableSelectColumnsConfig('netzbetreiber', 'tx_pingagthurcom_domain_model_service_location', 0, 1),
			'servicestellen' => $helper->getTableSelectTreeColumnsConfig('servicestellen', 'tx_pingagthurcom_domain_model_simple_service_location', 0, 20),
            'service_options' => $helper->getInlineColumnConfig('service_options', 'tx_pingagthurcom_domain_model_service_option', 10, 0),

            'extra_text' => $helper->getRTETextColumnsConfig('extra_text'),
            'extra_url' => $helper->getInputColumnsConfig('extra_url', false, 'url'),
            // FIELDS END
        )
    ),

);