<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung',
        'label' => 'amount',
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
        'searchFields' => 'amount,brand,card_number,customer_name,currency,expiry_date,error_code,order_id,pay_id,shasign,status,transaction_date,anfrageid',
        'iconfile' => 'EXT:fag_besichtigung/Resources/Public/Icons/tx_fagbesichtigung_domain_model_zahlung.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, amount, brand, card_number, customer_name, currency, expiry_date, error_code, order_id, pay_id, shasign, status, transaction_date, anfrageid',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, amount, brand, card_number, customer_name, currency, expiry_date, error_code, order_id, pay_id, shasign, status, transaction_date, anfrageid, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_fagbesichtigung_domain_model_zahlung',
                'foreign_table_where' => 'AND tx_fagbesichtigung_domain_model_zahlung.pid=###CURRENT_PID### AND tx_fagbesichtigung_domain_model_zahlung.sys_language_uid IN (-1,0)',
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

        'amount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.amount',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'brand' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.brand',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'card_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.card_number',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'customer_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.customer_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'currency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.currency',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'expiry_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.expiry_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'error_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.error_code',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'order_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.order_id',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'pay_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.pay_id',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'shasign' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.shasign',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.status',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'transaction_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.transaction_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'anfrageid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_zahlung.anfrageid',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fagbesichtigung_domain_model_anfrage',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
    
    ],
];
