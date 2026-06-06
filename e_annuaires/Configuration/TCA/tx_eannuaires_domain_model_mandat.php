<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');

//type,commune,groupe_politique_cr,circonscription,groupe_politique_depute,siteinternet,groupe_politique_senateur,siteinternet,nomepci,groupe_politique_epci,siteinternet,canton,fonctions,delegation,fonctionautre,groupe_politique_cg,commissions,representations

$locallang_path = 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:';

$tx_eannuaires_domain_model_mandat = [
	'ctrl' =>  [
		'title'	=> 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_mandat',
		'label' => 'typemandat', 
		'label_userFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_labelMandats',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
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
		'searchFields' => 'site_depute,site_senateur,site_epci,delegation,fonction_autre,commissions,representations,',
		'iconfile' => 'EXT:e_annuaires/Resources/Public/Icons/tx_eannuaires_domain_model_fiche.gif'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, canton, fonctions, delegation, fonctionautre, groupepolitique, commissions, representations'],
		'2' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, groupepolitique'],
		'3' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, circonscription, groupepolitique, siteinternet'],
		'4' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, communemandat'],
		'5' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, nomepci, groupepolitique, siteinternet'],
		'6' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, typemandat, groupepolitique, siteinternet'],
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
				'foreign_table' => 'tx_eannuaires_domain_model_mandat',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_mandat.pid=###CURRENT_PID### AND tx_eannuaires_domain_model_mandat.sys_language_uid IN (-1,0)',
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
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.crdate',
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
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.tstamp',
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
		'typemandat' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.typeMandat',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'minitems' => 0,
				'maxitems' => 1,
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemTypeMandat',
			],
		],
		'communemandat' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.communeMandat',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'foreign_table' => 'tx_eannuaires_domain_model_fiche', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.deleted=0 AND tx_eannuaires_domain_model_fiche.typeelement = ###PAGE_TSCONFIG_ID### ORDER BY tx_eannuaires_domain_model_fiche.title',
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false
                    ],
                    'editPopup' => [
                        'disabled' => false
                    ]
                ],
			],
		],
		'groupepolitique' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.groupepolitique',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'foreign_table' => 'tx_eannuaires_domain_model_groupepolitique', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_groupepolitique.hidden=0 AND tx_eannuaires_domain_model_groupepolitique.deleted=0 AND typemandat = ###REC_FIELD_typemandat### ORDER BY tx_eannuaires_domain_model_groupepolitique.intitule ',//AND tx_eannuaires_domain_model_groupepolitique.typemandat = ###PAGE_TSCONFIG_ID###',
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false
                    ],
                    'editPopup' => [
                        'disabled' => false
                    ]
                ],
			],
		],
		'circonscription' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.circonscription',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemCircLegislative',
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false
                    ],
                    'editPopup' => [
                        'disabled' => false
                    ]
                ],
			],
		],
		'siteinternet' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.siteInternet',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'nomepci' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.nomEpci',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'foreign_table' => 'tx_eannuaires_domain_model_fiche', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.hidden=0 AND tx_eannuaires_domain_model_fiche.deleted=0 AND tx_eannuaires_domain_model_fiche.pid = ###PAGE_TSCONFIG_ID### ORDER BY tx_eannuaires_domain_model_fiche.title',
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false
                    ],
                    'editPopup' => [
                        'disabled' => false
                    ]
                ],
			]
		],
		'canton' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.canton',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemCanton',
				'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                    '_VERTICAL' => 1,
                    '_PADDING' => 4,
                ],
			]
		],
		'fonctions' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.fonctions',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemFonctions',
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false
                    ],
                    'editPopup' => [
                        'disabled' => false
                    ]
                ],
			]
		],
		'delegation' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.delegation',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'fonctionautre' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.fonctionAutre',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'commissions' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.commissions',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'fieldControl' => [
					'fullScreenRichtext' => [
						'disabled' => false
					]
				],
				'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
				'enableRichtext' => true
			],
		],
		'representations' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_mandat.representations',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'fieldControl' => [
					'fullScreenRichtext' => [
						'disabled' => false
					]
				],
				'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
				'enableRichtext' => true
			],
		],
    ],
];

return $tx_eannuaires_domain_model_mandat;
?>
