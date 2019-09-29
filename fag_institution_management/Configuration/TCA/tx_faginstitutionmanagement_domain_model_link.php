<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link',
        'label' => 'title',
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
		'searchFields' => 'title,link_internal,link_external,link_form,type,categories',
        'iconfile' => 'EXT:fag_institution_management/Resources/Public/Icons/tx_faginstitutionmanagement_domain_model_link.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 
            'sys_language_uid, 
            l10n_parent, 
            l10n_diffsource, 
            hidden, 
            title, 
            link,
            link_type,
            link_target,  
            link_download, 
            link_download_icon,
            link_form,
            price, 
            categories,
            form_options,
            parent',
    ],
    'types' => [
		'1' => [
            'showitem' => '
                --palette--;Titel;link_title, 
                --palette--;Link;link_internal, 
                --palette--;Download;link_file, 
                --palette--;Formular;link_form_and_price, 
                form_options,
                categories, 
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, 
                sys_language_uid, 
                l10n_parent, 
                l10n_diffsource, 
                hidden, 
                starttime, 
                endtime'
            ],
    ],
    'palettes' => [
        'link_title' => [
            'showitem' => 'title, link_type',
            'canNotCollapse' => TRUE,
        ],
        'link_internal' => [
            'showitem' => 'link, link_target',
            'canNotCollapse' => TRUE,
        ],
        'link_file' => [
            'showitem' => 'link_download, link_download_icon',
            'canNotCollapse' => TRUE,
        ],
        'link_form_and_price' => [
            'showitem' => 'link_form, price',
            'canNotCollapse' => TRUE,
        ]
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
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_link',
                'foreign_table_where' => 'AND tx_faginstitutionmanagement_domain_model_link.pid=###CURRENT_PID### AND tx_faginstitutionmanagement_domain_model_link.sys_language_uid IN (-1,0)',
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
        'title' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.title',
	        'config' => [
			    "type" => "input",
			    "size" => 30,
			    "eval" => "trim"
			],
	    ],
	    'link' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link',
	        'config' => [
			    "type" => "input",
			    "size" => 30,
			    "eval" => "trim",
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'actions-wizard-link',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    ],
                ],
                'softref' => 'typolink'
			],
	    ],
        'link_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link_type',
            'config' => [
                "type" => "select",
                "renderType" => "selectSingle",
                "items" => [
                    ['Allgemein', 0],
                    ['Gesuch', 10],
                    ['Formular', 20],
                    ['Download', 30],
                ],
                "size" => 1,
                "maxitems" => 1,
                "eval" => ""
            ]
        ],
        'link_target' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link_target',
            'config' => [
                "type" => "select",
                "renderType" => "selectSingle",
                "items" => [
                    ["Normaler Link", ''],
                    ['Externer Link', '_blank'],
                ],
                "default" => "_blank",
                "size" => 1,
                "maxitems" => 1,
                "eval" => ""
            ]
        ],
	    'link_download' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link_download',
	        'config' => [
			    "type" => "input",
			    "size" => 30,
			    "eval" => "trim",
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'actions-wizard-link',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    ],
                ],
                'softref' => 'typolink'
			],
	    ],
        'link_download_icon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link_download_icon',
            'config' => [
                "type" => "select",
                "renderType" => "selectSingle",
                "items" => [
                    ["PDF", 'pdf'],
                    ['Word', 'word'],
                ],
                "size" => 1,
                "maxitems" => 1,
                "eval" => ""
            ]
        ],
	    'link_form' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.link_form',
	        'config' => [
			    "type" => "input",
			    "size" => 30,
			    "eval" => "trim",
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'actions-wizard-link',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    ],
                ],
                'softref' => 'typolink'
			],
	    ],
        'price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_link.price',
            'config' => [
                "type" => "input",
                "size" => 4,
                "eval" => "trim, double2"
            ]
        ],
    ],
];
