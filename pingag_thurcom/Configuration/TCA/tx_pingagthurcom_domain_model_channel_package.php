<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_channel_package',
    [
        'default' => "name, price, channels, section",
    ]
);

$defaultFields = 'name';

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


    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'name' => $helper->getInputColumnsConfig('name'),
            'price' => $helper->getInputColumnsConfig('price'),
			'channels' => $helper->getTableSelectTreeChannelColumnsConfig('channels', 'tx_pingagthurcom_domain_model_channel', 0, 100),
            'section' => [
                'exclude' => false,
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'Bereich',
                'config' => [
                    'type' => 'select',
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                    'items' => array(
                        ['Sparte', 0],
						['Fremdsprachen', 1],
						['Erotik', 1],
                    )
                ]
            ],
		

            // FIELDS END
        )
    ),

);