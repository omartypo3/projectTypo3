<?php
defined('TYPO3_MODE') or die();

/*----------------------------------------------------
 * temp columns
 ----------------------------------------------------*/


$temporaryColumns = array(// if you add columns to tt_content table, add TCA config here...
    'tx_logifact_footer_button' => array(
        'exclude' => 0,
        'label' => 'Footer buttons',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_footer_button',
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
    'tx_logifact_team' => array(
        'exclude' => 0,
        'label' => 'Team Members',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_team',
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
    'tx_logifact_camaliga' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:logifact/Resources/Private/Language/locallang_csh_tx_logifact_contact_person.xlf:tx_logifact_contact_person.contact',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_camaliga',
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
    'tx_logifact_slide' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:logifact/Resources/Private/Language/locallang_csh_tx_logifact_slide.xlf:tx_logifact_slide',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_slide',
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
    'tx_logifact_file_tab' => array(
        'exclude' => 0,
        'label' => 'Slider',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_file_tab',
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
    'tx_logifact_opinion' => array(
        'exclude' => 0,
        'label' => 'Customer Opinion',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_opinion',
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
    'tx_logifact_tab' => array(
        'exclude' => 0,
        'label' => 'Tab',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_tab',
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
    'tx_logifact_teaser_big' => array(
        'exclude' => 0,
        'label' => 'Teaser',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_teaser_big',
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
    'tx_logifact_link' => array(
        'exclude' => 0,
        'label' => 'Link',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_link',
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
    'tx_logifact_service' => array(
        'exclude' => 0,
        'label' => 'Teaser',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_service',
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
    'tx_logifact_product' => array(
        'exclude' => 0,
        'label' => 'Product',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_product',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'maxitems' => 2,
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
    'tx_logifact_cobra_product' => array(
        'exclude' => 0,
        'label' => 'Product',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_logifact_cobra_product',
            'foreign_field' => 'parent_uid',
            'foreign_sortby' => 'sorting',
            'maxitems' => 3,
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
    'link' => array(
        'exclude' => 0,
        'label' => 'Link',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputLink',
        ],
    ),
    'link_title' => array(
        'exclude' => 0,
        'label' => 'Link Title',
        'config' => [
            'type' => 'input',
        ],
    ),
    'show_header' => [
        'exclude' => 1,
        'label' => 'Hide Header',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                    'labelChecked' => 'Enabled',
                    'labelUnchecked' => 'Disabled',
                ]
            ],
        ]
    ]
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);

$GLOBALS['TCA']['tt_content']['types']['logifact_hero_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             media,
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
        'Hero Image',
        'logifact_hero_element',
        'logifact_hero_element'
    )
);

// OVERRIDE TCA CONFIG IF NEEDED

$GLOBALS['TCA']['tt_content']['types']['logifact_hero_element']['columnsOverrides'] = array(

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


);

$GLOBALS['TCA']['tt_content']['types']['logifact_camaliga_slider_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_camaliga,
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
        'Camaliga Slider
        ',
        'logifact_camaliga_slider_element',
        'logifact_camaliga_slider_element'
    )
);


$GLOBALS['TCA']['tt_content']['types']['logifact_slider_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
            tx_logifact_slide,
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
        'Slider',
        'logifact_slider_element',
        'logifact_slider_element'
    )
);



$GLOBALS['TCA']['tt_content']['types']['header'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
               --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
             --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
     '
);

$GLOBALS['TCA']['tt_content']['types']['logifact_opinion_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_opinion,
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
        'opinion',
        'logifact_opinion_element',
        'logifact_opinion_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_tabs_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_tab,
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
        'Tabs element ',
        'logifact_tabs_element',
        'logifact_tabs_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_teaser_big_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_teaser_big,
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
        'Big Teaser element ',
        'logifact_teaser_big_element',
        'logifact_teaser_big_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_network_service_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
             body_text,
             subheader,
             header_link,
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
        'Network Service element ',
        'logifact_network_service_element',
        'logifact_network_service_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_network_service_element']['columnsOverrides'] = array(
    'bodytext' => [
        'label' => 'Left side text',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'body_text' => [
        'label' => 'Right side text',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'subheader' => [
        'label' => 'Button text',
    ],
    'header_link' => [
        'label' => 'Link',

    ],
);
$GLOBALS['TCA']['tt_content']['types']['logifact_software_solutions_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
             image,
             subheader,
             tx_logifact_link,
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
        'Commercial software solutions',
        'logifact_software_solutions_element',
        'logifact_software_solutions_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_software_solutions_element']['columnsOverrides'] = array(
    'bodytext' => [
        'label' => 'Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'subheader' => [
        'label' => 'Links header',
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
                    'minitems' => 1,
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],

);
$GLOBALS['TCA']['tt_content']['types']['logifact_services_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_service,
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
        'Services solutions',
        'logifact_services_element',
        'logifact_services_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_product_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             tx_logifact_product,
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
        'Products',
        'logifact_product_element',
        'logifact_product_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_training_element'] = array(
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
        'Training element',
        'logifact_training_element',
        'logifact_training_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_training_element']['columnsOverrides'] = array(
    'bodytext' => [
        'label' => 'Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
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
                    'minitems' => 1,
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],

);
$GLOBALS['TCA']['tt_content']['types']['logifact_support_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
            --div--; Left Side element,
             bodytext,
             subheader,
             header_link,  
            --div--; Right Side element,
             body_text,
             link,
             link_title,
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
        'Support element',
        'logifact_support_element',
        'logifact_support_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['logifact_support_element']['columnsOverrides'] = array(
    'bodytext' => [
        'label' => ' Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'body_text' => [
        'label' => ' Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'subheader' => [
        'label' => ' Link title',
    ],
    'header_link' => [
        'label' => ' Link',
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
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
);

$GLOBALS['TCA']['tt_content']['types']['logifact_cobra_element'] = array(
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
        'Cobra element',
        'logifact_cobra_element',
        'logifact_cobra_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_cobra_element']['columnsOverrides'] = array(
    'bodytext' => [
        'label' => 'Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
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
                    'minitems' => 1,
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],

);

$GLOBALS['TCA']['tt_content']['types']['logifact_cobra_products_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
           tx_logifact_cobra_product,
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
        'Cobra Products element',
        'logifact_cobra_products_element',
        'logifact_cobra_products_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_header_text_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
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
        'Header Text element',
        'logifact_header_text_element',
        'logifact_header_text_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_header_text_element']['columnsOverrides'] = array(
    'header' => [
        'label' => 'Left Side Text title',
    ],
    'subheader' => [
        'label' => 'Right Side Text title',
    ],
    'bodytext' => [
        'label' => 'Left Side Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'body_text' => [
        'label' => 'Right Side Text Content',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);
$GLOBALS['TCA']['tt_content']['types']['logifact_team_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_team,
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
        'Team element',
        'logifact_team_element',
        'logifact_team_element'
    )
);

$GLOBALS['TCA']['tt_content']['types']['logifact_file_tabs_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_file_tab,
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
        'File Tabs element ',
        'logifact_file_tabs_element',
        'logifact_file_tabs_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_teaser_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             image,
             header,
             bodytext,
             link,
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
        'Teaser element ',
        'logifact_teaser_element',
        'logifact_teaser_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_teaser_element']['columnsOverrides'] = array(
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
                    'minitems' => 1,
                ],
                'jpg,jpeg,png,svg,gif'
            ),

    ],
    'bodytext' => [
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);
$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem'] = '
	--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
	--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
	show_header,
	tx_gridelements_backend_layout,
	pi_flexform,
	tx_gridelements_children,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
    media,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,
	categories,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription
	';
$GLOBALS['TCA']['tt_content']['types']['logifact_download_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             header,
             bodytext,
             media,
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
        'download list',
        'logifact_download_element',
        'logifact_download_element'
    )
);
$GLOBALS['TCA']['tt_content']['types']['logifact_download_element']['columnsOverrides'] = array(
    'bodytext' => [
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
    'body_text' => [
        'label'=>'Post download list text',
        'exclude' => false,
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
);
$GLOBALS['TCA']['tt_content']['types']['logifact_footer_buttons_element'] = array(
    'showitem' => '
             --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
             tx_logifact_footer_button,
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
        'Footer Buttons',
        'logifact_footer_buttons_element',
        'logifact_footer_buttons_element'
    )
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:typo3conf/ext/logifact/Resources/Ext/Form/FlexForm/FormFramework.xml',
    'form_formframework'
);