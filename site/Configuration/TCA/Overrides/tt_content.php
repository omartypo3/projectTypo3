<?php
defined('TYPO3_MODE') or die();

/*----------------------------------------------------
 * temp columns
 ----------------------------------------------------*/


$temporaryColumns = array(// if you add columns to tt_content table, add TCA config here...
    'tx_site_link' => array(
        'exclude' => 0,
        'label' => 'Link',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_link',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_radical' => array(
        'exclude' => 0,
        'label' => 'Radical',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_radical',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_slide' => array(
        'exclude' => 0,
        'label' => 'Slide',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_slide',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_country' => array(
        'exclude' => 0,
        'label' => 'country',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_country',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_partner' => array(
        'exclude' => 0,
        'label' => 'Partner',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_partner',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'body_text' => array(
        'exclude' => 0,
        'label' => 'Teaser',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15
        ],
    ),
    'link_title' => array(
        'exclude' => 0,
        'label' => 'Link Title',
        'config' => [
            'type' => 'input',
        ],
    ),
    'big_slider' => [
        'exclude' => 1,
        'label' => 'big slider Teaser',
        'config' => [
            'type' => 'check',
            'items' => [
                '1' => [
                    '0' => ''
                ]
            ],
        ],
    ],
    'type_slant' => [
        'exclude' => 1,
        'label' => 'big slider Teaser',
        'config' => [
            'type' => 'radio',
            'items' => [
                ['slantUpWhite', 0],
                ['slantUpBlack', 1],
                ['slantV', 2],
                ['slantDown', 3],
            ]
        ],
    ],
    'tx_site_quotes' => array(
        'exclude' => 0,
        'label' => 'Quoteslide',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_quotes',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_footer' => array(
        'exclude' => 0,
        'label' => 'partners footer in row1',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_footer',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_row' => array(
        'exclude' => 0,
        'label' => 'partners footer in row2',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_row',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_social' => array(
        'exclude' => 0,
        'label' => 'social',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_social',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_toursorbigslider' => array(
        'exclude' => 0,
        'label' => 'Toursorbigslider',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_toursorbigslider',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
    'tx_site_players' => array(
        'exclude' => 0,
        'label' => 'players',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_players',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),

    'tx_site_spansors' => array(
        'exclude' => 0,
        'label' => 'Spansors',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_spansors',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),

    'tx_site_businesslist' => array(
        'exclude' => 0,
        'label' => 'businesslist',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_site_businesslist',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'appearance' => array(
                'collapseAll' => 1,
                'useSortable' => 1,
                'newRecordLinkPosition' => 'top',
//		        'showSynchronizationLink' => 1,
//                'showRemovedLocalizationRecords' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
            'behaviour' => array(
//                'localizeChildrenAtParentLocalization' => 1
//                'allowLanguageSynchronization' => 1,
            )
        ]
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);



$GLOBALS['TCA']['tt_content']['types']['site_intro_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             subheader,
             bodytext,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);
$GLOBALS['TCA']['tt_content']['types']['site_intro_element']['columnsOverrides'] = array(
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site intro element',
        'site_intro_element',
        'site_intro_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_newsroom_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site newsroom element',
        'site_newsroom_element',
        'site_newsroom_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_whyinter_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             subheader,
             image,
             bodytext,
             tx_site_link,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site whyinter element',
        'site_whyinter_element',
        'site_whyinter_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_whyinter_element']['columnsOverrides'] = array(
    'subheader' => [
        'label' => 'header in mobile',
    ],
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);

$GLOBALS['TCA']['tt_content']['types']['site_threepillars_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             subheader,
             bodytext,
             image,
             tx_site_link,
             tx_site_radical,
             tx_site_slide,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site three pillars element',
        'site_threepillars_element',
        'site_threepillars_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_threepillars_element']['columnsOverrides'] = array(
    'subheader' => [
        'label' => 'sub title',
    ],
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);


$GLOBALS['TCA']['tt_content']['types']['site_sgeagles_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
             image,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site segeagles element',
        'site_sgeagles_element',
        'site_sgeagles_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['site_sgeagles_element']['columnsOverrides'] = array(
    'subheader' => [
        'label' => 'title of partners',
    ],
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);

$GLOBALS['TCA']['tt_content']['types']['site_quotes_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_site_quotes,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site quotes element',
        'site_quotes_element',
        'site_quotes_element'
    )
);


$GLOBALS['TCA']['tt_content']['types']['site_footer_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             subheader,
             tx_site_footer,
             tx_site_row,
             tx_site_social,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site footer element',
        'site_footer_element',
        'site_footer_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_footer_element']['columnsOverrides'] = array(
    'subheader' => [
        'label' => 'copyright',
    ],
);

$GLOBALS['TCA']['tt_content']['types']['site_Headvisual_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site Headvisual element',
        'site_Headvisual_element',
        'site_Headvisual_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_Headvisual_element']['columnsOverrides'] = array(
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
);

$GLOBALS['TCA']['tt_content']['types']['site_introContent_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             subheader,
             bodytext,
             image,
             link_title,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site introContent element',
        'site_introContent_element',
        'site_introContent_element'
    )
);

// OVERRIDE TCA CONFIG IF NEEDED

$GLOBALS['TCA']['tt_content']['types']['site_introContent_element']['columnsOverrides'] = array(

    'media' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'media',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'subheader' => [
        'label' => 'title',
    ],
    'link_title' => [
        'label' => 'caption',
    ],
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

);


$GLOBALS['TCA']['tt_content']['types']['site_academy_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             media,
             header,
             bodytext,
             image,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site academy element',
        'site_academy_element',
        'site_academy_element'
    )
);

// OVERRIDE TCA CONFIG IF NEEDED

$GLOBALS['TCA']['tt_content']['types']['site_academy_element']['columnsOverrides'] = array(
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add background'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'media' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'media',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add video'
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
                ],
                'mp4'
            ),

    ],
    'bodytext' => [
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

);

$GLOBALS['TCA']['tt_content']['types']['site_international_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             subheader,
             bodytext,
             tx_site_country,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site international element',
        'site_international_element',
        'site_international_element'
    )
);

// OVERRIDE TCA CONFIG IF NEEDED

$GLOBALS['TCA']['tt_content']['types']['site_international_element']['columnsOverrides'] = array(

    'subheader' => [
        'label' => 'title',
    ],
    'bodytext' => [
        'label' => 'Text',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);



$GLOBALS['TCA']['tt_content']['types']['site_toursorbigslider_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             big_slider,
             tx_site_toursorbigslider,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site toursorbigslider element',
        'site_toursorbigslider_element',
        'site_toursorbigslider_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_players_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             tx_site_players,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site Players element',
        'site_players_element',
        'site_players_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_players_element']['columnsOverrides'] = array(
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add background'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],


);
$GLOBALS['TCA']['tt_content']['types']['site_spansors_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             tx_site_spansors,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site spansors element',
        'site_spansors_element',
        'site_spansors_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_business_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             image,
             subheader,
             bodytext,
             tx_site_businesslist,
             tx_site_link,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site business element',
        'site_business_element',
        'site_business_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['site_business_element']['columnsOverrides'] = array(
    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add background'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],

    'subheader' => [
        'label' => 'business-img caption',
    ],
    'bodytext' => [
        'label' => 'Text',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],


);


$GLOBALS['TCA']['tt_content']['types']['site_pars_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             subheader,
             body_text,
             tx_site_partner,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site pars element',
        'site_pars_element',
        'site_pars_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['site_pars_element']['columnsOverrides'] = array(
    'subheader' => [
        'label' => 'title of partners',
    ],
    'body_text' => [
        'label' => 'Text Content of partners',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);


$GLOBALS['TCA']['tt_content']['types']['site_youthtext_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             header,
             bodytext,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);
$GLOBALS['TCA']['tt_content']['types']['site_youthtext_element']['columnsOverrides'] = array(

    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add background'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'bodytext' => [
        'label' => 'Text',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],

);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site youthtext element',
        'site_youthtext_element',
        'site_youthtext_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['site_youthtextbottom_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             subheader,
             body_text,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site youthtextbottom element',
        'site_youthtextbottom_element',
        'site_youthbottom_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['site_youthbottom_element']['columnsOverrides'] = array(

    'subheader' => [
        'label' => 'title of youth content bottom',
    ],
    'body_text' => [
        'label' => 'Text in bottom youth content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);

$GLOBALS['TCA']['tt_content']['types']['site_slant_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             type_slant,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site slant element',
        'site_slant_element',
        'site_slant_element'
    )
);


$GLOBALS['TCA']['tt_content']['types']['site_slant_element']['columnsOverrides'] = array(
    'type_slant' => [
        'exclude' => 1,
        'label' => 'Type of Slant',
        'config' => [
            'type' => 'radio',
            'items' => [
                ['slantUpWhite', '0'],
                ['slantUpBlack', '1'],
                ['slantV', '2'],
                ['slantDown', '3'],
            ],
        ]
    ],
);


$GLOBALS['TCA']['tt_content']['types']['site_video_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             media,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site video element',
        'site_video_element',
        'site_video_element'
    )
);


$GLOBALS['TCA']['tt_content']['types']['site_video_element']['columnsOverrides'] = array(

    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add Placeholder'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'media' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'media',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add video'
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
                ],
                'mp4'
            ),

    ],
);


$GLOBALS['TCA']['tt_content']['types']['site_imagecaption_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             link_title,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended
     '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCASelectItem(
    'tt_content',
    'CType',
    array(
        'site imagecaption element',
        'site_imagecaption_element',
        'site_imagecaption_element'
    )
);


$GLOBALS['TCA']['tt_content']['types']['site_imagecaption_element']['columnsOverrides'] = array(

    'image' => [
        'exclude' => false,
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'Add Placeholder'
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'link_title' => [
        'label' => 'caption',
    ],
);