<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente',
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
        'searchFields' => 'element,ueberschrift,anlagen,maschinerel,ansatzgroesse,automatisierungsgrad,autor,beschreibungstext,bild,branche,branchenicon,endprodukte,anwendungsbereich,fuellstoffanteil,kapazitaet,linkespalte,platzbedarf,portraitbild,pulverzufuehrung,rechtespalte,reinigungsfaehigkeit,zitat,weitereanforderungrepeater',
        'iconfile' => 'EXT:j77products/Resources/Public/Icons/tx_j77products_domain_model_anlagenelemente.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, element, ueberschrift, anlagen, maschinerel, ansatzgroesse, automatisierungsgrad, autor, beschreibungstext, bild, branche, branchenicon, endprodukte, anwendungsbereich, fuellstoffanteil, kapazitaet, linkespalte, platzbedarf, portraitbild, pulverzufuehrung, rechtespalte, reinigungsfaehigkeit, zitat, weitereanforderungrepeater',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, element, ueberschrift, anlagen, maschinerel, ansatzgroesse, automatisierungsgrad, autor, beschreibungstext, bild, branche, branchenicon, endprodukte, anwendungsbereich, fuellstoffanteil, kapazitaet, linkespalte, platzbedarf, portraitbild, pulverzufuehrung, rechtespalte, reinigungsfaehigkeit, zitat, weitereanforderungrepeater, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_j77products_domain_model_anlagenelemente',
                'foreign_table_where' => 'AND tx_j77products_domain_model_anlagenelemente.pid=###CURRENT_PID### AND tx_j77products_domain_model_anlagenelemente.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.element',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Wähle Element', -1],
                    ['Beschreibungstext', 0],
                    ['Steckbrief', 1],
                    ['Kundenanforderungen', 2],
                    ['Vorteile', 3],
                    ['Zitat-Teaser', 4],
                    ['Weitere Anlagen', 5],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'ueberschrift' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.ueberschrift',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:0'
        ],
        'anlagen' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.anlagen',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_j77products_domain_model_prozessanlage',
                'enableMultiSelectFilterTextfield' => true,
                'maxitems' => 9999
            ],
            'displayCond' => 'FIELD:element:IN:5'
        ],
        'maschinerel' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.maschinerel',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_j77products_domain_model_maschine',
                'enableMultiSelectFilterTextfield' => true,
                'maxitems' => 9999
            ],
            'displayCond' => 'FIELD:element:IN:5'
        ],
        'bild' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.bild',
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
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'kapazitaet' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.kapazitaet',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'ansatzgroesse' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.ansatzgroesse',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'branche' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.branche',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'branchenicon' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.branchenicon',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'branchenicon',
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
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'endprodukte' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.endprodukte',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'anwendungsbereich' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.anwendungsbereich',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:1'
        ],
        'automatisierungsgrad' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.automatisierungsgrad',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'autor' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.autor',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'beschreibungstext' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.beschreibungstext',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:0'
        ],
        'fuellstoffanteil' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.fuellstoffanteil',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'linkespalte' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.linkespalte',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:3'
        ],
        'platzbedarf' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.platzbedarf',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'portraitbild' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.portraitbild',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'portraitbild',
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
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'pulverzufuehrung' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.pulverzufuehrung',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'rechtespalte' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.rechtespalte',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform',
            'displayCond' => 'FIELD:element:IN:3'
        ],
        'reinigungsfaehigkeit' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.reinigungsfaehigkeit',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:element:IN:2'
        ],
        'zitat' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.zitat',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'displayCond' => 'FIELD:element:IN:4'
        ],
        'weitereanforderungrepeater' => [
            'exclude' => false,
            'label' => 'LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_anlagenelemente.weitereanforderungrepeater',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_j77products_domain_model_weitereanforderungen',
                'foreign_field' => 'anlagenelemente',
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

        'prozessanlage' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
