<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');


$locallang_path = 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:';

$tx_eannuaires_domain_model_fiche = [
	'ctrl' => [
		'title'	=> 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_fiche',
		'label' => 'title',
		'label_alt' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'versioningWS' => true,
		'origUid' => 't3_origuid',
        'type' => 'typeelement',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'title,name,firstname,address,zipcode,bp,cell,phone,config,typeelement,lat,lng,picto,description,image,www,email,feuser,civility,office,categories,city,district,documents,path_segment',
		'iconfile' => 'EXT:e_annuaires/Resources/Public/Icons/tx_eannuaires_domain_model_fiche.gif',
		'security' => [
			'ignorePageTypeRestriction' => true,
		],
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
                'foreign_table' => 'tx_eannuaires_domain_model_fiche',
                'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.pid=###CURRENT_PID### AND tx_eannuaires_domain_model_fiche.sys_language_uid IN (-1,0)',
                'showIconTable' => false
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
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
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'sorting' => [
            'label' => 'sorting',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'starttime' => [
            'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 8,
                'max' => 20,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 8,
                'max' => 20,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
		'title' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'name' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'firstname' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.firstname',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'intituleaddress' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.intituleAddress',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'address' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.address',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
        'address2' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.address2',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'cedex' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.cedex',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'liens' => [
            'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.liens',
            'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_lien',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
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
		'zipcode' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.zipcode',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'bp' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.bp',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'cell' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.cell',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'phone' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.phone',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'phonesecondaire' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.phoneSecondaire',
			'config' => [
				'type' => 'input',
				'size' => '30',
				'max' => '256',
				'eval' => 'trim',
			],
		],
        'fax' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.fax',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'faxsecondaire' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.faxSecondaire',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
		'typeelement' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.typeelement',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'minitems' => 1,
				'maxitems' => 1,
				'foreign_table' => 'tx_eannuaires_domain_model_typeannuaire',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_typeannuaire.hidden=0 AND tx_eannuaires_domain_model_typeannuaire.deleted=0'
			],
		],
		'description' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
                'enableRichtext' => true,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
			],
		],
        'datefiche' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.datefiche',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 8,
                'max' => 20,
                'eval' => 'datetime',
                'default' => 0,
			],
        ],
		'image' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_image.media',
			'config' => [
				'type' => 'file',
				'allowed' => 'common-image-types',
				'maxitems' => 10,
				'appearance' => [
					'collapseAll' => true,
				]
			]
		],
		'media' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_image.media',
			'config' => [
				'type' => 'file',
				'allowed' => 'common-media-types',
				'maxitems' => 10,
				'appearance' => [
					'collapseAll' => true,
				]
			]
		],
		'www' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.www',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'email' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.email',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'mail' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.mail',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'feuser' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.feuser',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'foreign_table' => 'fe_users',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ]
		],
		'civility' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.civility',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['Mr', 0],
					['Mlle', 1],
					['Mme', 2],
				],
				'eval' => ''
			],
		],
		'office' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.office',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
        'country' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.country',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
		'categories' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf:tx_eannuaires_domain_model_fiche.categories',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectTree',
				'treeConfig' => [
					'parentField' => 'parent',
					'appearance' => [
						'showHeader' => TRUE,
						'expandAll' => TRUE,
						'maxLevels' => 99,
					],
				],
				'MM' => 'sys_category_record_mm',
				'MM_match_fields' => [
					'fieldname' => 'categories',
					'tablenames' => 'tx_eannuaires_domain_model_fiche',
				],
				'MM_opposite_field' => 'items',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
				'minitems' => 0,
				'maxitems' => 99,
				'size' => 10,
				'appearance' => [
					'showHeader' => TRUE,
					'allowRecursiveMode' => TRUE,
					'expandAll' => TRUE,
					'maxLevels' => 99,
				],
			],
		],
		'city' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.city',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'foreign_table' => 'tx_enews_domain_model_commune',
				'foreign_table_where' => 'AND tx_enews_domain_model_commune.hidden=0 AND tx_enews_domain_model_commune.deleted=0',
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                    '_VERTICAL' => 1,
                    '_PADDING' => 4,
                ],
			],
		],
		'citylinked' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.cityLinked',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 100,
				'foreign_table' => 'tx_enews_domain_model_commune',
				'foreign_table_where' => 'AND tx_enews_domain_model_commune.hidden=0 AND tx_enews_domain_model_commune.deleted=0',
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                    '_VERTICAL' => 1,
                    '_PADDING' => 4,
                ],
			],
		],
		'district' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.district',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_eannuaires_domain_model_district',
				'minitems' => 0,
			],
		],
		'documents' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.documents',
			'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_documents',
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
        'canton' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.canton',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size'=> 5,
				'minitems' => 0,
				'maxitems' => 10,
				'foreign_table' => 'tx_eannuaires_domain_model_fiche',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.hidden=0 AND tx_eannuaires_domain_model_fiche.deleted=0',
			],
        ],
        'commission' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.commission',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 100,
				'foreign_table' => 'tx_eannuaires_domain_model_commission',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_commission.hidden=0 AND tx_eannuaires_domain_model_commission.deleted=0',
			],
        ],
        'actions' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.actions',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'minitems' => 0,
				'maxitems' => 100,
				'size' => 5,
				'foreign_table' => 'tx_eannuaires_domain_model_actions',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_actions.hidden=0 AND tx_eannuaires_domain_model_actions.deleted=0',
			],
        ],
        'production' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.production',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
		'ouvert' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.ouvert',
			'config' => [
				'type' => 'check',
			],
		],
		'ouvertcomment' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.ouvertcomment',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 10,
				'eval' => 'trim'
			],
		],
		'beneficiaire' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.beneficiaire',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 10,
				'eval' => 'trim',				
                'enableRichtext' => true,
			],
		],
        'objet' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.objet',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 100,
				'foreign_table' => 'tx_eannuaires_domain_model_objet',
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_objet.hidden=0 AND tx_eannuaires_domain_model_objet.deleted=0',
			],
        ],
		'enjeux' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.enjeux',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 10,
				'eval' => 'trim'
			],
		],
        'uploadimage' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.uploadimage',
			'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_image',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
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
		'contacts' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.contacts',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
                'enableRichtext' => true,
			],
		],
        'linkcontact' => [
            'exclude' => 1,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.linkcontact',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'foreign_table' => 'pages',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ]
        ],        
		'hebergementtemp' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.hebergementtemp',
			'config' => [
				'type' => 'check',
			],
		],
		'accueiljour' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.accueiljour',
			'config' => [
				'type' => 'check',
			],
		],
        'uniteterritoriale' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.uniteterritoriale',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'cantonstexte' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.cantonstexte',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'intercommunalite' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.intercommunalite',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
        ],
        'typeepci' => [ 
        	'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.epci',
			'config' => [
				'foreign_table' => 'tx_eannuaires_domain_model_fiche', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.hidden=0 AND tx_eannuaires_domain_model_fiche.deleted=0 AND tx_eannuaires_domain_model_fiche.pid = "###PAGE_TSCONFIG_ID###" ', 
				'maxitems' => '100',
				'minitems' => '0',
				'size' => '5',
				'renderType' => 'selectMultipleSideBySide',
				'type' => 'select'
			]
		],
		'mandats' => [ 
        	'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.mandats',
            'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_mandat',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
                'foreign_table_where' => 'AND tx_eannuaires_domain_model_mandat.hidden=0 AND tx_eannuaires_domain_model_mandat.deleted=0 ORDER BY tx_eannuaires_domain_model_mandat.sorting', 
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
		'typehandicap' => [ 
        	'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.typeHandicap',
            'config' => [
                'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemHandicap',
				'maxitems' => '50',
				'minitems' => '0',
				'size' => '5',
				'renderType' => 'selectMultipleSideBySide',
				'type' => 'select'
            ]
		],
		'contrat' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.contrat',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'minitems' => '0',
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemContrat'
			]
        ],
		'population' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.population',
			'config' => [
				'type' => 'input',
				'size' => '30',
				'max' => '256',
				'eval' => 'trim'
			]
        ],
		'cdps' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.cdps',
			'config' => [
			    'foreign_table' => 'tx_eannuaires_domain_model_fiche', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.deleted=0 AND tx_eannuaires_domain_model_fiche.pid = "###PAGE_TSCONFIG_ID###" ', 
				'maxitems' => '100',
				'minitems' => '0',
				'size' => '5',
				'renderType' => 'selectMultipleSideBySide',
				'type' => 'select'
			]
        ],
		'mds' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.mds',
			'config' => [
			    'foreign_table' => 'tx_eannuaires_domain_model_fiche', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_fiche.hidden=0 AND tx_eannuaires_domain_model_fiche.deleted=0 AND tx_eannuaires_domain_model_fiche.pid = "###PAGE_TSCONFIG_ID###" ', 
				'maxitems' => '100',
				'minitems' => '0',
				'size' => '5',
				'renderType' => 'selectMultipleSideBySide',
				'type' => 'select'
			]
        ],
		'pack' => [ 
        	'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.pack',
            'config' => [
				'foreign_table' => 'tx_eannuaires_domain_model_pack', 
				'foreign_table_where' => 'AND tx_eannuaires_domain_model_pack.hidden=0 AND tx_eannuaires_domain_model_pack.deleted=0 ', 
				'minitems' => '0',
				'renderType' => 'selectSingle',
				'type' => 'select'
            ],
		],
		'partipolitique' => [ 
        	'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.feuser',
            'config' => [
				'itemsProcFunc' => 'Emagineurs\EAnnuaires\Hooks\ItemsProcFunc->user_itemPartiPolitique', 
				'maxitems' => '100',
				'minitems' => '0',
				'size' => '5',
				'renderType' => 'selectMultipleSideBySide',
				'type' => 'select'
            ],
		],
		'latsecondaire' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.latsecondaire',
			'config'=> [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'wizards' => [
					'_PADDING' => 2,
					'map' => [
						'type' => 'popup',
						'title' => 'Choisir centre',
						'icon' => 'i/domain.gif',
						'module' => [
							'name' => 'choosePoi'
						],
						'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
					]
				]
			]
		],
		'lngsecondaire' => [
			'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.lngsecondaire',
			'config'=>[
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'wizards' => [
					'_PADDING' => 2,
					'map' => [
						'type' => 'popup',
						'title' => 'Choisir centre',
						'icon' => 'i/domain.gif',
						'module' => [
							'name' => 'choosePoi'
						],
						'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
					]
				]
				
			]
		],
        'horaires' => [
            'exclude' => 0,
			'label' => $locallang_path.'tx_eannuaires_domain_model_fiche.horaires',
            'config' => [
                'type' => 'inline',    
                'foreign_table' => 'tx_eannuaires_domain_model_horaires',
                'foreign_field' => 'uid_foreign',
                'foreign_table_field' => 'tablenames',
                'minitems' => 0,
                'maxitems' => 150,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
		],

		'path_segment' => [
			'label' => 'URL Segment',
			'config' => [
				'type' => 'slug',
				'generatorOptions' => [
					'fields' => ['title', 'uid'],
					'fieldSeparator' => '-',
					'prefixParentPageSlug' => false,
				],
				'fallbackCharacter' => '-',
			],
		],

		

    ]
];

$confExtTplAnnuaires = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] ?? [];



$typeCanton = $confExtTplAnnuaires['typeCanton'] ?? '';
if($typeCanton){
    $tx_eannuaires_domain_model_fiche['columns']['canton']['config']['foreign_table_where'] .= ' AND typeelement='.$typeCanton;
}


$confAnnuaires = $confExtTplAnnuaires['confAnnuaires'] ?? null;

if(is_array($confAnnuaires) && !empty($confAnnuaires)){
	$confExtTplAnnuaires['confType'] = $confAnnuaires;
}


if(is_array($confExtTplAnnuaires['confType'])){
						
	$page = (empty($_GET['id']))?0:intval($_GET['id']);

	
	/*$idTypePage = TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
		'pages',
		(int)$page,
		'uid,typeannuaire'
	);
		
		// $typeTsConfig = $tsconfig['annuaires.']['type'];
	$typeTsConfig = $idTypePage['typeannuaire'] ?? null;*/
	
	
	// $tsconfig = TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($page); 
	
	$typeTsConfig = null;
        
    foreach($confExtTplAnnuaires['confType'] as $idType => $confType){
        $fieldListeArray = array();
        if(is_array($confType)){
            foreach($confType as $field => $infos){        
			    
                if($field != 'titleType'){   
					if($infos['value']){   
						if($infos['sorting']){
							$fieldListeArray[$infos['sorting']] = ($infos['newTab'] != '') ? '--div--;'.$locallang_path.$infos['newTab'].',' : '';
							
							$fieldListeArray[$infos['sorting']] .= $infos['value'];
							if($infos['label']){
								$fieldListeArray[$infos['sorting']] .= ';'.$locallang_path.$infos['label'];
							}
						} else {
							$count = count($fieldListeArray)+1;
							$fieldListeArray[$count] = ($infos['newTab'] != '') ? '--div--;'.$locallang_path.$infos['newTab'].',' : '';
							$fieldListeArray[$count] .= $infos['value'];
						}
						
						if($infos['label'] && $idType == $typeTsConfig){                            
							$tx_eannuaires_domain_model_fiche['columns'][$infos['value']]['label'] = $locallang_path.$infos['label'];
						}
					}
                }
            }
            
            ksort($fieldListeArray);
            $fieldListeArray = array_unique($fieldListeArray);
            $fieldListe = implode(',',$fieldListeArray);

            
            if(in_array('typelement',$fieldListeArray)){
                $defaultFields = '';
            } else {
                $defaultFields = 'typeelement,';
            }
            
            if(!in_array('hidden',$fieldListeArray)){
                $defaultFields .= 'hidden,';
            }


			$defaultFields .= 'path_segment,';
            
            $tx_eannuaires_domain_model_fiche['types'][$idType]['showitem'] = $defaultFields.$fieldListe;          
        }
    }
} 

$tx_eannuaires_domain_model_fiche['types'][0]['showitem'] = $defaultFields.'title';

return $tx_eannuaires_domain_model_fiche;
?>