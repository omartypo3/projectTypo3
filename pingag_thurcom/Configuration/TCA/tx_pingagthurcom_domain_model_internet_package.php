<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_internet_package',
    [
        'default' => "--palette--;;header, --palette--;Geschwindigkeit;speed, speedtext, detail_text, shortcut, image, default",
    ]
);

$defaultFields = 'title, detailText';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'title',
        'thumbnail' => 'image',
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
        'header' => array('showitem' => 'title, price'),
        'speed' => array('showitem' => 'download_speed, upload_speed, speedvalue')
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
            'download_speed' => $helper->getInputColumnsConfig('downloadSpeed'),
            'upload_speed' => $helper->getInputColumnsConfig('uploadSpeed'),
			'speedvalue' => $helper->getInputColumnsConfig('speedvalue'),
			'speedtext' => $helper->getTextColumnsConfig('speedtext'),
            'detail_text' => $helper->getRTETextColumnsConfig('detailText'),
            'shortcut' => $helper->getInputColumnsConfig('shortcut'),
            'price' => $helper->getInputColumnsConfig('price'),
            'image' => $helper->getFalMediaColumnConfig('image', 'image', 'png, jpg, jpeg'),
            'default' => $helper->getCheckboxColumnConfig('default'),
            // FIELDS END
        )
    ),

);