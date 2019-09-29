<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event',
        'label' => 'titel',
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
        'searchFields' => 'titel,untertitel,bild,text,zusatztext,preishinweis,text_email,treffpunkt,datum,gruppen_fuhrer,sendemail',
        'iconfile' => 'EXT:fag_besichtigung/Resources/Public/Icons/tx_fagbesichtigung_domain_model_event.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, titel, untertitel, bild, text, zusatztext, preishinweis  ,text_email,treffpunkt, datum, gruppen_fuhrer ,sendemail',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, titel, untertitel, bild, text, zusatztext, preishinweis,text_email,treffpunkt, datum, gruppen_fuhrer, sendemail, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_fagbesichtigung_domain_model_event',
                'foreign_table_where' => 'AND tx_fagbesichtigung_domain_model_event.pid=###CURRENT_PID### AND tx_fagbesichtigung_domain_model_event.sys_language_uid IN (-1,0)',
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

        'titel' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.titel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'untertitel' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.untertitel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'bild' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.bild',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'bild',
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
                    'minitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.text',
            'config' => [
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
        'zusatztext' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.zusatztext',
            'config' => [
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
        'preishinweis' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.preishinweis',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ],
        ],
        'text_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.text_email',
            'config' => [
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
        'treffpunkt' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.treffpunkt',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'datum' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.datum',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fagbesichtigung_domain_model_datum',
                'foreign_field' => 'event',
                'maxitems' => 9999,
                'minitems' => 1,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'gruppen_fuhrer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fagbesichtigung_domain_model_event.gruppen_fuhrer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_fagbesichtigung_domain_model_gruppenfuhrer',
                'MM' => 'tx_fagbesichtigung_event_gruppenfuhrer_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 999,
                'minitems' => 1,
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
        'sendemail' => [
            'exclude' => 1,
            'label' => 'Spezielle und Absage- E-mail an Frau Helfenstein',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['Aktivieren', ''],
                ],
            ]
        ],
    
    ],
];
