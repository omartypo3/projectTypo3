<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen',
        'label' => 'von',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
        ],
		'searchFields' => 'von,bis,preis,tarif,notiz,domainname,cruser',
        'iconfile' => 'EXT:dsl_intranet/Resources/Public/Icons/tx_dslintranet_domain_model_hostingtarifrechnungen.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, von, bis, preis, tarif, notiz, domainname',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, von, bis, preis, tarif, notiz, domainname'],
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
                'foreign_table' => 'tx_dslintranet_domain_model_hostingtarifrechnungen',
                'foreign_table_where' => 'AND tx_dslintranet_domain_model_hostingtarifrechnungen.pid=###CURRENT_PID### AND tx_dslintranet_domain_model_hostingtarifrechnungen.sys_language_uid IN (-1,0)',
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
        'von' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.von',
	        'config' => [
			    'dbType' => 'date',
			    'type' => 'input',
			    'size' => 7,
			    'eval' => 'date',
			    'default' => '0000-00-00'
			],
	    ],
	    'bis' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.bis',
	        'config' => [
			    'dbType' => 'date',
			    'type' => 'input',
			    'size' => 7,
			    'eval' => 'date',
			    'default' => '0000-00-00'
			],
	    ],
	    'preis' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.preis',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'tarif' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.tarif',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'notiz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.notiz',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'domainname' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_hostingtarifrechnungen.domainname',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'hostingdomains' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hostingzusatzleistungen' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder