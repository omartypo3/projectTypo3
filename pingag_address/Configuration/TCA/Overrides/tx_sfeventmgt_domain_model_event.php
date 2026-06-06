<?php


$new_event_columns = [
    'goal' => [
        'exclude' => 1,
        'label' => 'Kompetenzen',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'requirements' => [
        'exclude' => 1,
        'label' => 'Methodik und Selbstlernaktivitäten',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'vorkenntnisse' => [
        'exclude' => 1,
        'label' => 'Vorkenntnisse',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'zgroup' => [
        'exclude' => 1,
        'label' => 'Zielgruppe',
        'config' => [
            'type' => 'text',
            'cols' => 60,
            'rows' => 5,
        ]
    ],

    'leader' => [
        'exclude' => 1,
        'label' => 'Leitung',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'comment' => [
        'exclude' => 1,
        'label' => 'Kommentar',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'infos' => [
        'exclude' => 1,
        'label' => 'Auskünfte',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

    'dateextra' => [
        'exclude' => 1,
        'label' => 'Date Info',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],

    'otherdates' => [
        'exclude' => 1,
        'label' => 'Other Dates',
        'config' => [
            'type' => 'text',
            'cols' => 60,
            'rows' => 5,
        ]
    ],


    'price' => [
        'exclude' => 1,
        'label' => 'Preis Text',
        'config' => [
            'type' => 'input',
        ],
    ],

    'veranstaltung' => [
        'exclude' => 1,
        'label' => 'Art der Veranstaltung',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_veranstaltung',
            'MM' => 'tx_pingagaddress_event_veranstaltung_mm',
            'size' => 10,
            'autoSizeMax' => 30,
            'maxitems' => 9999,
            'multiple' => 0,
            'fieldControl' => [
                'editPopup' => [
                    'disabled' => false,
                ],
                'addRecord' => [
                    'disabled' => false,
                ],
                'listModule' => [
                    'disabled' => true,
                ],
            ],
        ],
    ],
    'zielgruppe' => [
        'exclude' => 1,
        'label' => 'Zielgruppe',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_zielgruppe',
            'MM' => 'tx_pingagaddress_event_zielgruppe_mm',
            'size' => 10,
            'autoSizeMax' => 30,
            'maxitems' => 9999,
            'multiple' => 0,
            'fieldControl' => [
                'editPopup' => [
                    'disabled' => false,
                ],
                'addRecord' => [
                    'disabled' => false,
                ],
                'listModule' => [
                    'disabled' => true,
                ],
            ],
        ],
    ],
    'kursthemen' => [
        'exclude' => 1,
        'label' => 'Kursthemen',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_kursthemen',
            'MM' => 'tx_pingagaddress_event_kursthemen_mm',
            'size' => 10,
            'autoSizeMax' => 30,
            'maxitems' => 9999,
            'multiple' => 0,
            'fieldControl' => [
                'editPopup' => [
                    'disabled' => false,
                ],
                'addRecord' => [
                    'disabled' => false,
                ],
                'listModule' => [
                    'disabled' => true,
                ],
            ],
        ],
    ],
    'sprache' => [
        'exclude' => 1,
        'label' => 'Sprache',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_sprache',
            'MM' => 'tx_pingagaddress_event_sprache_mm',
            'size' => 10,
            'autoSizeMax' => 30,
            'maxitems' => 9999,
            'multiple' => 0,
            'fieldControl' => [
                'editPopup' => [
                    'disabled' => false,
                ],
                'addRecord' => [
                    'disabled' => false,
                ],
                'listModule' => [
                    'disabled' => true,
                ],
            ],
        ],
    ],
];

$price = [
    'pricetext' => [
        'exclude' => 1,
        'label' => 'Preis Text',
        'config' => [
            'type' => 'input',
        ],
    ],
];


$desc = [
    'description' => [
        'exclude' => 1,
        'l10n_mode' => 'prefixLangTitle',
        'label' => 'Lernziele',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim',
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_event',$new_event_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_event', $price);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_event', $desc);
#TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("tx_sfeventmgt_domain_model_event", "goal,requirements,zgroup,leader,comment,infos,dateextra,otherdates;;;;1-1-1", '', 'after:description');

$GLOBALS['TCA']['tx_sfeventmgt_domain_model_event']['types'] =[
    '1' => [
        'showitem' => '--palette--;;titleTopEvent, --palette--;;paletteDates, teaser,slug, goal,description,requirements,vorkenntnisse,zgroup,leader,comment,infos,dateextra,otherdates,

                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.additional,
                    --palette--;;palettePrice, price_options, link, program,
    
                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.relations,
                    --palette--;;location, organisator, speaker, related,
    
                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.media,
                    image, files, additional_image,
    
                --div--;Kategorien,
                    category,
    
                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.registration_options,
                    enable_registration, registration_deadline, --palette--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.sections.cancellation;paletteCancellation,
                    max_participants, max_registrations_per_user, enable_autoconfirm, enable_waitlist, unique_email_check,
                    --palette--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.sections.notification;paletteNotification,
    
                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.registration_fields,
                    registration_fields,
    
                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.registrations,
                    registration,registration_waitlist,
    
                --div--;Zahlung,
                     enable_payment, restrict_payment_methods, selected_payment_methods,

                --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_be.xlf:tabs.language,
                    --palette--;;language,

                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, 
                    hidden, --palette--;;timeRestriction, fe_group,
                    
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    rowDescription,    
                    
                 --div--;' . 'Filter, veranstaltung,zielgruppe,kursthemen,sprache,'
    ],
];

$GLOBALS['TCA']['tx_sfeventmgt_domain_model_event']['palettes'] =[
    '1' => [
        'showitem' => '',
    ],
    'timeRestriction' => ['showitem' => 'starttime, endtime'],
    'language' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource'],
    'location' => [
        'showitem' => 'location, --linebreak--,room,',
        'canNotCollapse' => true
    ],
    'titleTopEvent' => ['showitem' => 'title, top_event'],
    'paletteDates' => [
        'showitem' => 'startdate, enddate,',
        'canNotCollapse' => true
    ],
    'palettePrice' => [
        'showitem' => 'pricetext, currency,',
        'canNotCollapse' => true
    ],
    'paletteNotification' => [
        'showitem' => 'notify_admin, notify_organisator,',
        'canNotCollapse' => true
    ],
    'paletteCancellation' => [
        'showitem' => 'enable_cancel, cancel_deadline,',
        'canNotCollapse' => true
    ],

];