<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');

$locallang_path = 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:';

$tx_eannuaires_domain_model_groupepolitique = [
	'ctrl' => [
		'title'	=> 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_groupepolitique',
		'label' => 'intitule',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		// 'sortby' => 'sorting',
        'default_sortby' => 'ORDER BY intitule',
		'versioningWS' => true,
		'origUid' => 't3_origuid',
        'type' => 'typemandat',	
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'intitule,',
		'iconfile' => 'EXT:e_annuaires/Resources/Public/Icons/tx_eannuaires_domain_model_fiche.gif'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, intitule, typemandat, site'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_eannuaires_domain_model_groupepolitique',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_groupepolitique.pid=###CURRENT_PID### AND tx_eannuaires_domain_model_groupepolitique.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			]
		],
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'default' => 0
			]
		],
		'crdate' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => $locallang_path.'tx_eannuaires_domain_model_groupepolitique.crdate',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
			],
		],
		'tstamp' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => $locallang_path.'tx_eannuaires_domain_model_groupepolitique.tstamp',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
			],
		],
		'starttime' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y'))
				],
			],
		],
		'endtime' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y'))
				],
			],
		],
		'intitule' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_groupepolitique.intitule',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'typemandat' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_groupepolitique.typeMandat',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
                'items' => [
                    ['', 0],
                ],
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemTypeMandat'
			],
		],
		'site' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_groupepolitique.site',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
			'fieldControl' => [
				'linkPopup' => [
					'options' => [
						'title' => 'Link',
						'allowedTypes' => ['page', 'url', 'mail', 'tel', 'file']
					]
				]
			]
		],
    ],
];

return $tx_eannuaires_domain_model_groupepolitique;
?>
