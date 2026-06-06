<?php


$desc = [
    'address' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            'rows' => 5,
            'cols' => 48,
            'richtextConfiguration' => 'cke_custome',
            'softref' => 'typolink_tag,url',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ]
    ],
    'marker_icon' => [
        'exclude' => true,
        'label' => 'marker',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'marker_icon',
            [
                'maxitems' => 1,
                'minitems' => 0,
                'appearance' => [
                    'collapseAll' => true,
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                    --palette--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                    ],
                ],
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        )
    ],
    "dienstleistungen" => [
        "exclude" => 1,
        "label" => "dienstleistungen",
        "config" => [
            "type" => "select",
            "renderType" => "selectMultipleSideBySide",
            "foreign_table" => "tx_pingagaddress_domain_model_dienstleistungen",
            "foreign_table_where" => " AND tx_pingagaddress_domain_model_dienstleistungen.l10n_parent = 0",
            "MM" => "tx_pingagaddress_tt_address_dienstleistungen_mm",
            "size" => 10,
            "autoSizeMax" => 30,
            "maxitems" => 9999,
            "multiple" => 0,
            "fieldControl" => [
                "editPopup" => ["disabled" => false],
                "addRecord" => ["disabled" => false],
                "listModule" => ["disabled" => true],
            ],
        ],
    ],
    'kantone' => [
        'exclude' => 1,
        'label' => 'kantone',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_kantone',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_kantone.l10n_parent = 0',
            'MM' => 'tx_pingagaddress_tt_address_kantone_mm',
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
    'description' => [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.description',
        'config' => [
            'type' => 'text',
            'rows' => 5,
            'cols' => 48,
            'enableRichtext' => true,
            'richtextConfiguration' => 'cke_custome',
            'softref' => 'typolink_tag,url',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ]
    ],

    'gehoerlos' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingagaddress_domain_model_addressperson.gehoerlos',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_gehoerlos',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_gehoerlos.l10n_parent = 0',
            'default' => 0,
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

    'einsatzort' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingagaddress_domain_model_addressperson.einsatzort',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'items' => [
                ['D-CH', 'D-CH'],
                ['Romandie', 'Romandie'],
                ['TI', 'TI'],
                ['Ganze Schweiz', 'Ganze Schweiz'],
                ['Ausland', 'Ausland'],
            ],
        ],
    ],
    'auto_benoetigt' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingagaddress_domain_model_addressperson.auto_benoetigt',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                ]
            ],
            'default' => 0,
        ]
    ],
    'verfuegbarkeit' => [
        'exclude' => true,
        'label' => 'verfuegbarkeit',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
            'default' => ''
        ],
    ],
    'technikenlevel' => [
        'exclude' => true,
        'label' => 'Techniques Level',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_techniqueslevel',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_techniqueslevel.l10n_parent = 0',
            'default' => 0,
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
    'mutter_sprache' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingagaddress_domain_model_addressperson.mutter_sprache',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_language',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_language.l10n_parent = 0',
            'default' => 0,
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
    'weitere_sprachen_written' => [
        'exclude' => true,
        'label' => 'Weitere Sprachen - schriftlich',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_languagewritten',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_languagewritten.l10n_parent = 0',
            'default' => 0,
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
    'weitere_sprachen_oral' => [
        'exclude' => true,
        'label' => 'Weitere Sprachen - gesprochen',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_languageoral',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_languageoral.l10n_parent = 0',
            'default' => 0,
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

    'spezielle' => [
        'exclude' => true,
        'label' => 'Spezielle Kompetenzen',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_spezielle',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_spezielle.l10n_parent = 0',
            'default' => 0,
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

    'available' => [
        'exclude' => true,
        'label' => 'Verfügbarkeit',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_available',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_available.l10n_parent = 0',
            'default' => 0,
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

    'placeofuse' => [
        'exclude' => true,
        'label' => 'Einsatzort',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_placeofuse',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_placeofuse.l10n_parent = 0',
            'default' => 0,
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

    'angebote' => [
        'exclude' => true,
        'label' => 'Angebote',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_angebote',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_angebote.l10n_parent = 0',
            'default' => 0,
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
    'lebensalter' => [
        'exclude' => true,
        'label' => 'Lebensalter',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pingagaddress_domain_model_lebensalter',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_lebensalter.l10n_parent = 0',
            'default' => 0,
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

    'weiterestandorte' => [
        'exclude' => 1,
        'label' => 'weitere standorte',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_pingagaddress_domain_model_weiterestandorte',
            'foreign_table_where' => ' AND tx_pingagaddress_domain_model_weiterestandorte.l10n_parent = 0',
            'foreign_field' => 'address',
            'maxitems' => 9999,
            'appearance' => [
                'collapseAll' => true,
                'expandSingle' => true,
                'levelLinksPosition' => 'bottom',
                'useSortable' => true,
                'showSynchronizationLink' => true,
                'showPossibleLocalizationRecords' => true,
                'showAllLocalizationLink' => true,
                'showPossibleRecordsSelector' => true,
                'showRemovedLocalizationRecords' => false,
                'enabledControls' => [
                    'info' => true,
                    'new' => true,
                    'dragdrop' => true,
                    'sort' => true,
                    'hide' => true,
                    'delete' => true,
                    'localize' => true,
                ],
            ],
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $desc);
$GLOBALS['TCA']['tt_address']['ctrl']['label_userFunc'] = \Pingag\PingagAddress\Hooks\Label::class . '->getAddressLabel';

$GLOBALS['TCA']['tt_address']['types'] =[
    '1' => [
        'showitem' => '
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.name;name,
                    image, description,
            --div--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_tab.address,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.address;address,marker_icon,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.coordinates;coordinates,

            --div--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_tab.contact,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.contact;contact,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.organization;organization,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.building;building,
                --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address_palette.social;social,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;paletteHidden,
                --palette--;;paletteAccess,
            --div--;' . 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category, categories,
            --div--;' . 'Dienstleistungen, dienstleistungen,
            --div--;' . 'Weitere standorte, weiterestandorte,
            --div--;' . 'Kantone, kantone,
            --div--;' . 'Lebensalter, lebensalter,
            --div--;' . 'Angebote, angebote,
            --div--;' . 'Kommunikationsassistenten, gehoerlos, placeofuse , auto_benoetigt , available , technikenlevel, mutter_sprache, weitere_sprachen_written , weitere_sprachen_oral , spezielle,

            '
    ]
];
$GLOBALS['TCA']['tx_sfeventmgt_domain_model_event']['palettes'] =[
    'name' => [
        'showitem' => 'gender, title, title_suffix,--linebreak--,
                            first_name, middle_name, last_name,--linebreak--,name,--linebreak--,slug'
    ],
    'organization' => [
        'showitem' => 'position, company'
    ],
    'address' => [
        'showitem' => 'address, --linebreak--,
                        marker_icon, --linebreak--,
                            city, zip, region, --linebreak--,
                            country,  --linebreak--,'
    ],
    'building' => [
        'showitem' => 'building, room'
    ],
    'coordinates' => [
        'showitem' => 'latitude,longitude'
    ],
    'contact' => [
        'showitem' => 'email, --linebreak--,
                            phone, mobile, fax, --linebreak--,
                            www, --linebreak--,
                            birthday'
    ],
    'social' => [
        'showitem' => 'skype, twitter, --linebreak--,
                            facebook, linkedin'
    ],
    'paletteHidden' => [
        'showitem' => 'hidden',
    ],
    'paletteAccess' => [
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
        'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--,
                fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel
            ',
    ],
    'language' => ['showitem' => 'sys_language_uid, l10n_parent'],

];