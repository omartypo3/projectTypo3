<?php

$helper = new \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper(

    'tx_pingag_jobs_domain_model_vacancy',
    [
        'default' => "--palette--;;title;,intro,tasks,profile,offer,contact",
        'tabs.properties' => 'type,section,city,import_id,apply_form_url,valid_from',
    ]
);

$defaultFields = 'title,intro';

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
    'interface' => \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagJobs\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'title' => array('showitem' => "title,location"),
    ),

    'columns' => $helper->getDefaultColumnsConfig([

        'title' => $helper->getInputColumnsConfig('title'),
        'intro' => $helper->getRTETextColumnsConfig('intro'),
        'tasks' => $helper->getRTETextColumnsConfig('tasks'),
        'profile' => $helper->getRTETextColumnsConfig('profile'),
        'offer' => $helper->getRTETextColumnsConfig('offer'),
        'location' => $helper->getInputColumnsConfig('location'),
        'contact' => $helper->getRTETextColumnsConfig('contact'),

        'type' => $helper->getTableSelectColumnsConfig('type', 'tx_pingag_jobs_domain_model_property', 0, 1, "AND type='type'"),
        'section' => $helper->getTableSelectColumnsConfig('section', 'tx_pingag_jobs_domain_model_property', 0, 1, 'AND type="section"'),
        'city' => $helper->getTableSelectColumnsConfig('city', 'tx_pingag_jobs_domain_model_property', 0, 1, 'AND type="city"'),

        //'type' => $helper->getInputColumnsConfig('type'),
        //'section' => $helper->getInputColumnsConfig('section'),
        //'city' => $helper->getInputColumnsConfig('city'),

        'import_id' => [
            'exclude' => false,
            'label' => $helper->trans('import_id'),
            'config' => [
                'type' => 'input',
                'size' => 10,
                'readOnly' => true
            ],
        ],
        'apply_form_url' => [
            'exclude' => false,
            'label' => $helper->trans('apply_form_url'),
            'config' => [
                'type' => 'input',
                'size' => 255,
                'readOnly' => true,
            ],
        ],
        'valid_from' => [
            'exclude' => false,
            'label' => $helper->trans('valid_from'),
            'config' => [
                'type' => 'input',
                'size' => 10,
                'readOnly' => true
            ],
        ],
    ]),

);