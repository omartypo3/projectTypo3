<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role',
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
        'searchFields' => 'title,user,institution',
        'iconfile' => 'EXT:fag_institution_management/Resources/Public/Icons/tx_faginstitutionmanagement_domain_model_role.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource ,isadmin, hidden, title, show_in_register, user, institution, address, zip, city, company, phone, mobile, fax, email, www',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, isadmin, hidden, title, show_in_register, user, institution, --palette--;;address, --palette--;;zip, --palette--;;city, --palette--;;company, --palette--;;phone, --palette--;;mobile, --palette--;;fax, --palette--;;email, --palette--;;www, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'palettes' => [
			'address' => ['showitem' => 'address, hide_address'],
			'zip' => ['showitem' => 'zip, hide_zip'],
			'city' => ['showitem' => 'city, hide_city'],
			'company' => ['showitem' => 'company, hide_company'],
			'phone' => ['showitem' => 'phone, hide_phone'],
			'mobile' => ['showitem' => 'mobile, hide_mobile'],
			'fax' => ['showitem' => 'fax, hide_fax'],
			'email' => ['showitem' => 'email, hide_email'],
			'www' => ['showitem' => 'www, hide_www'],
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
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_role',
                'foreign_table_where' => 'AND tx_faginstitutionmanagement_domain_model_role.pid=###CURRENT_PID### AND tx_faginstitutionmanagement_domain_model_role.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.address',
            'config' => [
                'type' => 'text',
                'cols' => '20',
                'rows' => '3'
            ],
        ],
        'hide_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_address',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.zip',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '10',
                'max' => '20'
            ],
        ],
        'hide_zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_zip',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.city',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ],
        ],
        'hide_city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_city',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.company',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            ]
        ],
        'hide_company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_company',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '30'
            ],
        ],
        'hide_phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_phone',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'mobile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.mobile',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '30'
            ],
        ],
        'hide_mobile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_mobile',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'fax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.fax',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '30'
            ],
        ],
        'hide_fax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_fax',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.email',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'softref' => 'email'
            ],
        ],
        'hide_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_email',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'www' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.www',
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
        'hide_www' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.hide_www',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'show_in_register' => [
            'exclude' => true,
            'label' => 'show in register',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'foreign_table' => 'fe_users',
                'minitems' => 1,
                'maxitems' => 1,
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'pid' => '30',
                        ],
                    ],
                    'elementBrowser' => [
                        'disabled' => false,
                    ],
                ],
            ],

        ],
        'institution' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.institution',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_faginstitutionmanagement_domain_model_institution',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'isadmin' => [
            'exclude' => true,
            'label' => 'Is Admin',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
    
    ],
];
