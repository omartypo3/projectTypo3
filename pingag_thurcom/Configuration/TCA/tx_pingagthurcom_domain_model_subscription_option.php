<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_subscription_option',
    [
        'default' => "--palette--;;header, detail_text, icon, cornericon, radiobutton, single",
    ]
);

$defaultFields = 'title, detailText';

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
        'header' => array('showitem' => 'title, price'),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
            'detail_text' => $helper->getRTETextColumnsConfig('detailText'),
            'price' => $helper->getInputColumnsConfig('price'),
            'icon' => $helper->getFalMediaColumnConfig('icon', 'icon', 'png, jpg, jpeg, svg'),
			'cornericon' => $helper->getFalMediaColumnConfig('cornericon', 'cornericon', 'png, jpg, jpeg, svg'),
			'radiobutton' => $helper->getCheckboxColumnConfig('radiobutton'),
			'single' => $helper->getCheckboxColumnConfig('single'),
            // FIELDS END
        )
    ),

);