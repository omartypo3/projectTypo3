<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant',
        'label' => 'gender',
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
        'searchFields' => 'gender,title,academic_title,first_name,last_name,email,company,city,country,interventional_pulmonologist,pneumologist,thoracic_surgeon,general_practitioner,distributor,specialist_other,information_product_portfolio,informaztion_clinical_evidence,information_other,contact,contact_reason,captured_by,event',
        'iconfile' => 'EXT:contact_form/Resources/Public/Icons/tx_contactform_domain_model_participant.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, gender, title, academic_title, first_name, last_name, email, company, city, country, interventional_pulmonologist, pneumologist, thoracic_surgeon, general_practitioner, distributor, specialist_other, information_product_portfolio, informaztion_clinical_evidence, information_other, contact, contact_reason, captured_by, event',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, gender, title, academic_title, first_name, last_name, email, company, city, country, interventional_pulmonologist, pneumologist, thoracic_surgeon, general_practitioner, distributor, specialist_other, information_product_portfolio, informaztion_clinical_evidence, information_other, contact, contact_reason, captured_by, event, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_contactform_domain_model_participant',
                'foreign_table_where' => 'AND tx_contactform_domain_model_participant.pid=###CURRENT_PID### AND tx_contactform_domain_model_participant.sys_language_uid IN (-1,0)',
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

        'gender' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.gender',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'first_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.first_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'last_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.last_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'nospace,email'
            ]
        ],
        'company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.company',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.country',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'static_countries',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'interventional_pulmonologist' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.interventional_pulmonologist',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'pneumologist' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.pneumologist',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'thoracic_surgeon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.thoracic_surgeon',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'general_practitioner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.general_practitioner',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'distributor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.distributor',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'specialist_other' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.specialist_other',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'information_product_portfolio' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.information_product_portfolio',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'informaztion_clinical_evidence' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.informaztion_clinical_evidence',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'information_other' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.information_other',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.contact',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'contact_reason' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.contact_reason',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'captured_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.captured_by',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'event' => [
            'exclude' => true,
            'label' => 'LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contactform_domain_model_participant.event',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_contactform_domain_model_event',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    
    ],
];
