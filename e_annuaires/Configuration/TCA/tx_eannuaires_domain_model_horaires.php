<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');

$tx_eannuaires_domain_model_horaires = [
	'ctrl' => [
		'title'	=> 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires',
		'label' => 'title',
		'label_alt_force' => 'starttime',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',		
		// 'default_sortby' => 'starttime',		
		'hideTable' => true,
		'versioningWS' => true,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		// 'searchFields' => 'title,',
		'iconfile' => 'EXT:e_annuaires/Resources/Public/Icons/tx_eannuaires_domain_model_actions.gif'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, starttime, endtime, description, liens,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.monday;monday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.tuesday;tuesday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.wednesday;wednesday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.thursday;thursday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.friday;friday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.saturday;saturday,
			--palette--;LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.palette.sunday;sunday
		'],
	],
	'palettes' => [
		'monday' => ['showitem' => 'openingmonday, closuremonday'],
		'tuesday' => ['showitem' => 'openingtuesday, closuretuesday'],
		'wednesday' => ['showitem' => 'openingwednesday, closurewednesday'],
		'thursday' => ['showitem' => 'openingthursday,	closurethursday'],
		'friday' => ['showitem' => 'openingfriday, closurefriday'],
		'saturday' => ['showitem' => 'openingsaturday, closuresaturday'],
		'sunday' => ['showitem' => 'openingsunday, closuresunday'],
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
                // 'default' => 0,
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
				'foreign_table' => 'tx_eannuaires_domain_model_horaires',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_horaires.pid=###CURRENT_PID### AND tx_eannuaires_domain_model_horaires.sys_language_uid IN (-1,0)',
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
				'default' => 0
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
				'default' => 0
			],
		],
		'title' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'description' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_fiche.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
                'fieldControl' => [
                    'fullScreenRichtext'=> [
                        'disabled' => false
                    ]
                ],
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'enableRichtext' => true,
			],
		],
        'liens' => [
            'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_fiche.liens',
            'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_lien',
                'minitems' => 0,
                'maxitems' => 15,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ], 
		/*'week' => [//// TODO: Mettre en place un weekpicker
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.week',
			'config' => [				
				'type' => 'user',
				'userFunc' => ' Emagineurs\\EAnnuaires\\Wizards\\userFunc->weekPicker',
				'parameters' => [
					'color' => 'green'
				)                                 
			),
        ),  */
		'week' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.week',
			'config' => [
				'type' => 'input',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'date',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
        ], 
		'duration' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.duration',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,int',
                                'default' => 0,
			],
		],
		'openingmonday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingmonday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closuremonday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closuremonday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingtuesday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingtuesday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closuretuesday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closuretuesday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingwednesday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingwednesday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closurewednesday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closurewednesday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingthursday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingthursday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closurethursday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closurethursday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingfriday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingfriday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closurefriday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closurefriday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingsaturday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingsaturday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closuresaturday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closuresaturday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'openingsunday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.openingsunday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
		'closuresunday' => [
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_horaires.closuresunday',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				// 'size' => 13,
				// 'max' => 20,
				'eval' => 'time',
				// 'checkbox' => 0,
				// 'default' => 0,
			],
		],
	],
];

return $tx_eannuaires_domain_model_horaires;
?>
