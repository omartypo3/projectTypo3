<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_channel',
    [
        'default' => "name, lang, icon, frequency, description, url, hbb, hd, dolby, categories",
    ]
);

$defaultFields = 'name, lang';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'name',
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
    'palettes' => array(),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'name' => $helper->getInputColumnsConfig('name'),
            'lang' => $helper->getInputColumnsConfig('lang'),
			'frequency' => $helper->getInputColumnsConfig('frequency', false),
			'description' => $helper->getTextColumnsConfig('description', false),
			'url' => $helper->getInputColumnsConfig('url', false),
			'hbb' => $helper->getCheckboxColumnConfig('hbb'),
			'hd' => $helper->getCheckboxColumnConfig('hd'),
			'dolby' => $helper->getCheckboxColumnConfig('dolby'),
            'icon' => $helper->getInputColumnsConfig('icon'),
			//'packages' => $helper->getTableSelectTreeChannelColumnsConfig('packages', 'tx_pingagthurcom_domain_model_channel_package', 0, 20),
			//'packages' => $helper->getMultiSelectColumnsConfig('packages', 'tx_pingagthurcom_domain_model_channel_package', 'tx_pingagthurcom_domain_model_channel_package_mm', 20, 0, 'pid = 46', 'tx_pingagthurcom_domain_model_channel_package.name'),
            'categories' => $helper->getCategoriesColumnConfig('categories'),
            // FIELDS END
        )
    ),

);