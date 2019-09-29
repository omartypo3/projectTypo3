<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
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
        'searchFields' => 'title,first_name,last_name,logo,images,address,zip,city,company,phone,mobile,fax,email,description,detail_site,roles,events,links',
        'iconfile' => 'EXT:fag_institution_management/Resources/Public/Icons/tx_faginstitutionmanagement_domain_model_institution.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, first_name, last_name, address, zip, city, company, phone, mobile, fax, email, www, logo, images, description, roles, events',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, --div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_sites, detail_site,--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_media,logo, images,--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_events,events,--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_onlineswitch,links,--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_contact,--palette--;;name,--palette--;;address,--palette--;;phone,--palette--;;mail,roles,--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.sheet_admin,fe_users,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'palettes' => [
        'name' => ['showitem' => 'institution_contact_label, first_name, last_name, company'],
        'address' => ['showitem' => 'address, zip, city'],
        'phone' => ['showitem' => 'phone, mobile, fax'],
        'mail' => ['showitem' => 'email, www'],
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
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_institution',
                'foreign_table_where' => 'AND tx_faginstitutionmanagement_domain_model_institution.pid=###CURRENT_PID### AND tx_faginstitutionmanagement_domain_model_institution.sys_language_uid IN (-1,0)',
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
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'first_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.first_name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ]
        ],
        'institution_contact_label' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.institution_contact_label',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ]
        ],
        'last_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.last_name',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ]
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.address',
            'config' => [
                'type' => 'text',
                'cols' => '20',
                'rows' => '3'
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.zip',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '10',
                'max' => '20'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.city',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ],
        ],
        'company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.company',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ]
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '30'
            ],
        ],
        'mobile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.mobile',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '30'
            ],
        ],
        'fax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.fax',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '30'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.email',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'softref' => 'email'
            ],
        ],
        'www' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.www',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '255',
				'softref' => 'typolink,url',
                'wizards' => array(
                    '_PADDING' => 2,
                    'link' => array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
                        'icon' => $version7 ? 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif' : 'link_popup.gif',
                        'module' => array(
                            'name' => $version7 ? 'wizard_link' : 'wizard_element_browser',
                            'urlParameters' => array(
                                'mode' => 'wizard',
                                'act' => 'url|page'
                            )
                        ),
                        'params' => array(
                            'blindLinkOptions' => 'mail,file,spec,folder',
                        ),
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
                    ),
                )
            ],
        ],
	    'main_address' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.mainAddress',
	        'config' => [
			    'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0]
                ],
                'foreign_table' => 'tt_address',
                'foreign_table_where' => 'ORDER BY name',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
			],
	    ],
        'logo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.logo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logo',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 1,
                    'foreign_match_fields' => [
                        'fieldname' => 'logo',
                        'tablenames' => 'tx_faginstitutionmanagement_domain_model_institution',
                        'table_local' => 'sys_file',
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images', [
                'maxitems'	=> 10
            ],$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
//        'document' => [
//            'exclude' => true,
//            'label' => 'Document',
//            'config' =>   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
//                'document',
//                [
//                    'appearance' => [
//                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
//                    ],
//                    'foreign_types' => [
//                        '0' => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ],
//                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ],
//                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ],
//                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ],
//                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ],
//                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
//                            'showitem' => '
//                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
//                            --palette--;;filePalette'
//                        ]
//                    ],
//                    'maxitems' => 999,
//                    'foreign_match_fields' => [
//                        'fieldname' => 'document',
//                        'tablenames' => 'tx_faginstitutionmanagement_domain_model_institution',
//                        'table_local' => 'sys_file',
//                    ],
//
//                ],
//                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
//            ),
//        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.description',
            'config' => [
                'type' => 'text',
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
        'roles' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.roles',
            'config' => [
                'type' => 'inline',
                'foreign_sortby' => 'sorting',
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_role',
                'foreign_field' => 'institution',
            ],

        ],
        'events' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.events',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fagcalendar_domain_model_event',
                'foreign_field' => 'institution',
                'foreign_default_sortby' => 'start',
            ],

        ],
        'links' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.links',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_faginstitutionmanagement_domain_model_link',
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_link',
                'MM_opposite_field' => 'related_from',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_faginstitutionmanagement_link_institution_mm',
                'suggestOptions' => [
                    'default' => [
                        'suggestOptions' => true,
                        'addWhere' => ' AND tx_faginstitutionmanagement_domain_model_institution.uid != ###THIS_UID###'
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'admin' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.admin',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'foreign_table' => 'fe_users',
                'size' => 5,
                'minitems' => 1,
                'maxitems' => 100,
                'MM' => 'tx_faginstitutionmanagement_institution_user_mm',
                'suggestOptions' => [
                    'default' => [
                        'suggestOptions' => true,
                        'addWhere' => ' AND tx_faginstitutionmanagement_domain_model_institution.uid != ###THIS_UID###'
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'fe_users' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_institution.admin',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'foreign_table' => 'fe_users',
                'size' => 5,
                'minitems' => 1,
                'maxitems' => 100,
                'MM' => 'tx_faginstitutionmanagement_fe_users_institution_mm',
                'suggestOptions' => [
                    'default' => [
                        'suggestOptions' => true,
                        'addWhere' => ' AND tx_faginstitutionmanagement_domain_model_institution.uid != ###THIS_UID###'
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'detail_site' => [
            'exclude' => true,
            'label' => 'Spezielle Detail-Seite',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,num',
            ]
        ],
    ],
];
