<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage',
        'label' => 'anrede',
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
        'searchFields' => 'anrede,vorname,name,funktion,strasse,ort_p_l_z,email,telefon,bemerkung,gruppenname,durchschnittsalter,teilnehmeraktuell',
        'iconfile' => 'EXT:fag_besichtigung/Resources/Public/Icons/tx_fagbesichtigung_domain_model_anfrage.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, anrede, vorname, name, funktion, strasse, ort_p_l_z, email, telefon, bemerkung, gruppenname, durchschnittsalter, teilnehmeraktuell',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, anrede, vorname, name, funktion, strasse, ort_p_l_z, email, telefon, bemerkung, gruppenname, durchschnittsalter, teilnehmeraktuell, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_fagbesichtigung_domain_model_anfrage',
                'foreign_table_where' => 'AND tx_fagbesichtigung_domain_model_anfrage.pid=###CURRENT_PID### AND tx_fagbesichtigung_domain_model_anfrage.sys_language_uid IN (-1,0)',
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

        'anrede' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.anrede',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'vorname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.vorname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'funktion' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.funktion',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'strasse' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.strasse',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'ort_p_l_z' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.ort_p_l_z',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'nospace,email'
            ]
        ],
        'telefon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.telefon',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'bemerkung' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.bemerkung',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            
        ],
        'gruppenname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.gruppenname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'durchschnittsalter' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.durchschnittsalter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'teilnehmeraktuell' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_anfrage.teilnehmeraktuell',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
    
        'datum' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
