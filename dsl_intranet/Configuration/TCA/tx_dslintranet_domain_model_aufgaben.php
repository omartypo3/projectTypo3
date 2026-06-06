<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben',
        'label' => 'notiz',
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
		'searchFields' => 'notiz,begin,end,erledigt,mitarbeiter,auftrag,cruser',
        'iconfile' => 'EXT:dsl_intranet/Resources/Public/Icons/tx_dslintranet_domain_model_aufgaben.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, notiz, begin, end, erledigt, mitarbeiter, auftrag, cruser',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, notiz, begin, end, erledigt, mitarbeiter, auftrag, cruser, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_dslintranet_domain_model_aufgaben',
                'foreign_table_where' => 'AND tx_dslintranet_domain_model_aufgaben.pid=###CURRENT_PID### AND tx_dslintranet_domain_model_aufgaben.sys_language_uid IN (-1,0)',
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
        'notiz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.notiz',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'begin' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.begin',
	        'config' => [
			    'type' => 'input',
			    'size' => 10,
			    'eval' => 'datetime',
			    'default' => time()
			],
	    ],
	    'end' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.end',
	        'config' => [
			    'type' => 'input',
			    'size' => 10,
			    'eval' => 'datetime',
			    'default' => time()
			],
	    ],
	    'erledigt' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.erledigt',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'mitarbeiter' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.mitarbeiter',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'fe_users',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
	    'auftrag' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.auftrag',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'tx_dslintranet_domain_model_auftraege',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
		'cruser' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_aufgaben.cruser',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'fe_users',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
    ],
];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder