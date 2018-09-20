<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente',
        'label' => 'element',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'element,ueberschrift,titel,beschreibungstext,bild,chargengroesse,dichtung,dispergierkammer,drehzahl,durchsatzfluessigkeit,einsaugleistungpulver,funktionsbild1,funktionsbild2,hauptbild,icon,lagerflansch,leistung,linkespalte,maschinenvariante,maximaleviskositaet,optionen,rechtespalte,schergeschwindigkeit,spannung,tauchteil,umfangsgeschwindigkeit,werkzeugschaft,downloadrepeater,iconrepeater',
        'iconfile' => 'EXT:j77products/Resources/Public/Icons/tx_j77products_domain_model_maschinenelemente.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, element, ueberschrift,  titel, beschreibungstext, bild, chargengroesse, dichtung, dispergierkammer, drehzahl, durchsatzfluessigkeit, einsaugleistungpulver, funktionsbild1, funktionsbild2, hauptbild, icon, lagerflansch, leistung, linkespalte, maschinenvariante, maximaleviskositaet, optionen, rechtespalte, schergeschwindigkeit, spannung, tauchteil,umfangsgeschwindigkeit, werkzeugschaft, downloadrepeater, iconrepeater',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, element, ueberschrift,  titel, beschreibungstext, bild, chargengroesse, dichtung, dispergierkammer, drehzahl, durchsatzfluessigkeit, einsaugleistungpulver, funktionsbild1, funktionsbild2, hauptbild, icon, lagerflansch, leistung, linkespalte, maschinenvariante, maximaleviskositaet, optionen, rechtespalte, schergeschwindigkeit, spannung, tauchteil,umfangsgeschwindigkeit, werkzeugschaft, downloadrepeater, iconrepeater, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sorting' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
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
                'foreign_table' => 'tx_j77products_domain_model_maschinenelemente',
                'foreign_table_where' => 'AND tx_j77products_domain_model_maschinenelemente.pid=###CURRENT_PID### AND tx_j77products_domain_model_maschinenelemente.sys_language_uid IN (-1,0)',
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
            ],
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
                ],
            ],
        ],
        'element' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.element',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Wähle Element', -1],
                    ['Bild / Beschreibungstext', 0],
                    ['Vorteile', 1],
                    ['Icon-Teaser', 2],
                    ['Funktionsbeschreibung', 3],
                    ['Technische Daten', 4],
                    ['Zertifizierungen', 5],
                    ['Downloads', 6],
                    ['Produktvarianten', 7],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'ueberschrift' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.ueberschrift',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:0,1,2,3'
        ],
        'beschreibungstext' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.beschreibungstext',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:0,3'
        ],
        'bild' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.bild',
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
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
            'displayCond' => 'FIELD:element:IN:0'
        ],
        'chargengroesse' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.chargengroesse',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'dichtung' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.dichtung',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'dispergierkammer' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.dispergierkammer',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'drehzahl' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.drehzahl',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'durchsatzfluessigkeit' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.durchsatzfluessigkeit',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'einsaugleistungpulver' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.einsaugleistungpulver',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'funktionsbild1' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.funktionsbild1',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'funktionsbild1',
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
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
            'displayCond' => 'FIELD:element:IN:3'
        ],
        'funktionsbild2' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.funktionsbild2',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'funktionsbild2',
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
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
            'displayCond' => 'FIELD:element:IN:3'
        ],
        'hauptbild' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.hauptbild',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'hauptbild',
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
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
            'displayCond' => 'FIELD:element:IN:3'
        ],
        'icon' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.icon',
            'l10n_mode' => 'exclude',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'icon',
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
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
            'displayCond' => 'FIELD:element:IN:5'
        ],
        'lagerflansch' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.lagerflansch',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'leistung' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.leistung',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'linkespalte' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.linkespalte',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'maschinenvariante' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.maschinenvariante',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_j77products_domain_model_maschine',
                'enableMultiSelectFilterTextfield' => true,
                'maxitems' => 9999
            ],
            'displayCond' => 'FIELD:element:IN:7'
        ],
        'maximaleviskositaet' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.maximaleviskositaet',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'optionen' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.optionen',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'rechtespalte' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.rechtespalte',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'schergeschwindigkeit' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.schergeschwindigkeit',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'spannung' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.spannung',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'tauchteil' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.tauchteil',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'titel' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.titel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:5'
        ],
        'umfangsgeschwindigkeit' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.umfangsgeschwindigkeit',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'werkzeugschaft' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.werkzeugschaft',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'downloadrepeater' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.downloadrepeater',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_j77products_domain_model_download',
                'foreign_field' => 'maschinenelemente',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
            'displayCond' => 'FIELD:element:IN:6'
        ],
        'iconrepeater' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschinenelemente.iconrepeater',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_j77products_domain_model_icon',
                'foreign_field' => 'maschinenelemente',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'maschine' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
