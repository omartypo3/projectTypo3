<?php

$helper = new \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper(

    'tx_pingag_jobs_domain_model_property',
    [
        'default' => "--palette--;;header, import_id",
    ]
);

$defaultFields = 'value';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'value',
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
        'type' => 'type',
        'typeicon_column' => 'type',
        'typeicon_classes' => [
            'type' => 'property-type',
            'section' => 'property-section',
            'city' => 'property-city',
        ],
        'sortby' => 'sorting',
        'searchFields' => $defaultFields,
        'iconfile' => $helper->getIconPath(),
    ),
    'interface' => \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'header' => array('showitem' => "value,type"),
    ),

    'columns' => $helper->getDefaultColumnsConfig([
        'value' => $helper->getInputColumnsConfig('value'),
        'type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype_formlabel',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$helper->trans('type.type'), 'type', 'property-type'],
                    [$helper->trans('type.section'), 'section', 'property-section'],
                    [$helper->trans('type.city'), 'city', 'property-city'],
                ],
                'showIconTable' => true,
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'import_id' => [
            'exclude' => false,
            'label' => $helper->trans('import_id'),
            'config' => [
                'type' => 'input',
                'size' => 10,
                'readOnly' => true
            ],
        ],
    ]),

);