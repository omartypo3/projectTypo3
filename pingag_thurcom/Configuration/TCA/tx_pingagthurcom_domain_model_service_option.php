<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_service_option',
    [
        'default' => "--palette--;;options",
    ]
);

$defaultFields = '';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'service',
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
        'hideTable' => 1
    ),
    'interface' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'options' => array('showitem' => "service, state"),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'service' => [
                'exclude' => true,
                'label' => $helper->trans('service'),
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => array(
                        ['Angebot auswählen', 0]
                    ),
                    'foreign_table' => 'tx_pingagthurcom_domain_model_service',
                    'default' => 0,
                ]
            ],
            'state' => [
                'exclude' => false,
                'l10n_mode' => 'prefixLangTitle',
                'label' => $helper->trans('state'),
                'config' => [
                    'type' => 'select',
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                    'items' => array(
                        [$helper->trans('state.options.0'), 0, $helper->getIconPath('state-0.png')],
                        [$helper->trans('state.options.1'), 1, $helper->getIconPath('state-1.png')],
                        [$helper->trans('state.options.2'), 2, $helper->getIconPath('state-2.png')],
                    )
                ]
            ],
            // FIELDS END
        )
    ),

);