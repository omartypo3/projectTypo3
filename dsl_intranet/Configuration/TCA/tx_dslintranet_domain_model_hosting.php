<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting',
        'label' => 'benutzername',
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
		'searchFields' => 'benutzername,kennwort,statistik,oldid,notiz,kunde,haupt_tarif,zusatz_leistungen,zusatz_tarif',
        'iconfile' => 'EXT:dsl_intranet/Resources/Public/Icons/tx_dslintranet_domain_model_hosting.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, benutzername, kennwort, statistik, oldid, notiz, kunde, haupt_tarif, zusatz_leistungen, zusatz_tarif',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, benutzername, kennwort, statistik, oldid, notiz, kunde, haupt_tarif, zusatz_leistungen, zusatz_tarif, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_dslintranet_domain_model_hosting',
                'foreign_table_where' => 'AND tx_dslintranet_domain_model_hosting.pid=###CURRENT_PID### AND tx_dslintranet_domain_model_hosting.sys_language_uid IN (-1,0)',
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
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'benutzername' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.benutzername',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'kennwort' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.kennwort',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'statistik' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.statistik',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'oldid' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.oldid',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'notiz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.notiz',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'kunde' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.kunde',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'fe_users',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
	    'haupt_tarif' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.haupt_tarif',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslintranet_domain_model_hostingdomains',
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
	    'zusatz_leistungen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.zusatz_leistungen',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslintranet_domain_model_hostingzusatzleistungen',
			    'foreign_field' => 'hosting',
			    'maxitems' => 9999,
			    'appearance' => [
			        'collapseAll' => 0,
			        'levelLinksPosition' => 'top',
			        'showSynchronizationLink' => 1,
			        'showPossibleLocalizationRecords' => 1,
			        'showAllLocalizationLink' => 1
			    ],
			],
	    ],
	    'zusatz_tarif' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hosting.zusatz_tarif',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslintranet_domain_model_hostingdomains',
			    'foreign_field' => 'hosting2',
			    'maxitems' => 9999,
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
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder