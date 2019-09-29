<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum',
        'label' => 'date',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'hideTable' => 1,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'date,start_time,end_time,status,teilnehmer_max,anfrage,gruppen_fuhrer,gruppentyp',
        'iconfile' => 'EXT:fag_besichtigung/Resources/Public/Icons/tx_fagbesichtigung_domain_model_datum.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, date, start_time, end_time, status, teilnehmer_max, anfrage, gruppen_fuhrer, gruppentyp',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, date, start_time, end_time, status, teilnehmer_max, anfrage, gruppen_fuhrer, gruppentyp, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_fagbesichtigung_domain_model_datum',
                'foreign_table_where' => 'AND tx_fagbesichtigung_domain_model_datum.pid=###CURRENT_PID### AND tx_fagbesichtigung_domain_model_datum.sys_language_uid IN (-1,0)',
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
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date,required',
                'default' => null,
            ],
        ],
        'start_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.start_time',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ),
        ],
        'end_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.end_time',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ),
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.status',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => 'Verfügbar'
            ],
        ],
        'teilnehmer_max' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.teilnehmer_max',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 20
            ]
        ],
        'anfrage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.anfrage',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fagbesichtigung_domain_model_anfrage',
                'foreign_field' => 'datum',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'gruppen_fuhrer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.gruppen_fuhrer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_fagbesichtigung_domain_model_gruppenfuhrer',
                'MM' => 'tx_fagbesichtigung_datum_gruppenfuhrer_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 1,
                'minitems' => 1,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],

        ],
        'gruppentyp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_datum.gruppentyp',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Öffentlich ', 1],
                    ['Privat', 2],
                ],
            ],
        ],

        'event' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
