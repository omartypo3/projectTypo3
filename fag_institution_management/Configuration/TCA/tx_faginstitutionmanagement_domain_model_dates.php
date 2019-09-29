<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_aaaaa_domain_model_dates',
        'label' => 'startdate',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        // hide table in list view
        'hideTable' => 1,
        'searchFields' => 'startdate,enddate',
        'iconfile' => 'EXT:fag_institution_management/Resources/Public/Icons/tx_aaaaa_domain_model_dates.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, startdate, enddate',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, --palette--;;startfields,--palette--;;endfields, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'palettes' => [
        'startfields' => ['showitem' => 'startdate'],
        'endfields' => ['showitem' => 'enddate'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_dates',
                'foreign_table_where' => 'AND tx_faginstitutionmanagement_domain_model_dates.pid=###CURRENT_PID### AND tx_faginstitutionmanagement_domain_model_dates.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],

        'startdate' => [
            'exclude' => true,
            'label' => 'startdate',
            'config' => [
                'type' => 'input',
                'size' => 7,
            ],
        ],
        'enddate' => [
            'exclude' => true,
            'label' => 'enddate',
            'config' => [
                'type' => 'input',
                'size' => 7,
            ],
        ],
        'start' => [
            'exclude' => true,
            'label' => 'Datum von',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'date,required',
                'checkbox' => 1,
                'default' => time()
            ],
        ],
        'end' => [
            'exclude' => true,
            'label' => 'Datum bis (leer wenn identisch)',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'date,required',
                'checkbox' => 1,
                'default' => time(),
                'value' => 'FIELD:startdate'

            ],
        ],
        'start_time' => [
            'exclude' => true,
            'label' => 'Beginnt um',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'end_time' => [
            'exclude' => true,
            'label' => 'Endet um',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
    
    ],
];
