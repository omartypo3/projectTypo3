<?php
defined('TYPO3_MODE') or die();

$fields = array(
    'tx_wngcvcinews_is_event' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_is_event',
        'config' => array(
            'type' => 'check',
            'default' => 0
        ),
    ),
    'tx_wngcvcinews_start_date' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_start_date',
        'config' => array(
            'type' => 'input',
            'size' => 7,
            'eval' => 'date',
            'checkbox' => 1,
        ),
    ),
    'tx_wngcvcinews_start_time' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_start_time',
        'config' => array(
            'type' => 'input',
            'size' => 4,
            'eval' => 'time',
            'checkbox' => 1,
        ),
    ),
    'tx_wngcvcinews_end_date' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_end_date',
        'config' => array(
            'type' => 'input',
            'size' => 7,
            'eval' => 'date',
            'checkbox' => 1,
        ),
    ),
    'tx_wngcvcinews_end_time' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_end_time',
        'config' => array(
            'type' => 'input',
            'size' => 4,
            'eval' => 'time',
            'checkbox' => 1,
        ),
    ),
    'tx_wngcvcinews_all_day' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_all_day',
        'config' => array(
            'type' => 'check',
            'default' => 0
        ),
    ),

    'tx_wngcvcinews_price' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_price',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_url' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_url',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_url_title' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_url_title',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_theme' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_theme',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'file',
            'allowed' => 'pdf',
            'max' => 1,
            'min' => 0,
        )
    ),
    'tx_wngcvcinews_type' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_type',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_phone' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_phone',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_apero' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_apero',
        'config' => array(
            'type' => 'check',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_organisor' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organisor',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_form' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_form',
        'config' => array(
            'type' => 'check',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_participant' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_participant',
        'config' => array(
            'type' => 'check',
            'size' => '30',
        )
    ),

    'tx_wngcvcinews_organizer' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer',
        'config' => array(
            'type' => 'input',
            'size' => '30',
            'max' => '128'
        )
    ),
    'tx_wngcvcinews_organizer_id' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer_id',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'allowed' => 'tx_wngcvcinews_domain_model_organizer',
            'wizards' => array(
                '_PADDING' => 2,
                '_VERTICAL' => 1,
                'add' => array(
                    'type' => 'script',
                    'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer_id.createNew',
                    'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif', // \TYPO3\CMS\Backend\Utility\IconUtility::getIcon($useOrganizerStructure),
                    'params' => array(
                        'table' => 'tx_wngcvcinews_domain_model_organizer',
                        'pid' => '###CURRENT_PID###',
                        'setValue' => 'set'
                    ),
                    'module' => array(
                        'name' => 'wizard_add'
                    )
                ),
                'edit' => array(
                    'type' => 'popup',
                    'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer_id.edit',
                    'module' => array(
                        'name' => 'wizard_edit'
                    ),
                    'popup_onlyOpenIfSelected' => 1,
                    'icon' => 'edit2.gif',
                    'JSopenParams' => 'height=600,width=525,status=0,menubar=0,scrollbars=1',
                    'params' => array(
                        'table' => 'tx_wngcvcinews_domain_model_organizer'
                    )
                ),
                'suggest' => array(
                    'type' => 'suggest'
                )
            )
        )
    ),
    'tx_wngcvcinews_organizer_pid' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer_pid',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'pages',
            'size' => '1',
            'maxitems' => '1',
            'minitems' => '0',
            'show_thumbs' => '1',
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest'
                )
            )
        )
    ),
    'tx_wngcvcinews_organizer_link' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_organizer_link',
        'config' => array(
            'type' => 'input',
            'size' => '25',
            'max' => '128',
            'checkbox' => '',
            'eval' => 'trim',
            'wizards' => array(
                '_PADDING' => 2,
                'link' => array(
                    'type' => 'popup',
                    'title' => 'Link',
                    'icon' => 'link_popup.gif',
                    'module' => array(
                        'name' => 'wizard_element_browser',
                        'urlParameters' => array(
                            'mode' => 'wizard'
                        )
                    ),
                    'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                )
            )
        )
    ),

    'tx_wngcvcinews_location' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location',
        'config' => array(
            'type' => 'input',
            'size' => '30',
            'max' => '128'
        )
    ),

    'tx_wngcvcinews_latitude' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_latitude',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_longitude' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_longitude',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_wngcvcinews_address' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_address',
        'config' => array(
            'type' => 'input',
            'size' => '80',
        )
    ),
    'tx_wngcvcinews_map' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_map',
        'config' => array(
            'type' => 'user',
            'size' => '30',
            'userFunc' => 'Wng\\WngCvciNews\\UserFunc\\GoogleMaps->generateMap',
            'parameters' => array(
                'length' => 6,
            )
        )
    ),

    'tx_wngcvcinews_location_id' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location_id',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'allowed' => 'tx_wngcvcinews_domain_model_location',
            'wizards' => array(
                '_PADDING' => 2,
                '_VERTICAL' => 1,
                'add' => array(
                    'type' => 'script',
                    'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location_id.createNew',
                    'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif', // \TYPO3\CMS\Backend\Utility\IconUtility::getIcon($useLocationStructure),
                    'params' => array(
                        'table' => 'tx_wngcvcinews_domain_model_location',
                        'pid' => '###CURRENT_PID###',
                        'setValue' => 'set'
                    ),
                    'module' => array(
                        'name' => 'wizard_add'
                    )
                ),
                'edit' => array(
                    'type' => 'popup',
                    'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location_id.edit',
                    'module' => array(
                        'name' => 'wizard_edit'
                    ),
                    'popup_onlyOpenIfSelected' => 1,
                    'icon' => 'edit2.gif',
                    'JSopenParams' => 'height=600,width=525,status=0,menubar=0,scrollbars=1',
                    'params' => array(
                        'table' => 'tx_wngcvcinews_domain_model_location'
                    )
                ),
                'suggest' => array(
                    'type' => 'suggest'
                )
            )
        )
    ),
    'tx_wngcvcinews_location_pid' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location_pid',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'pages',
            'size' => '1',
            'maxitems' => '1',
            'minitems' => '0',
            'show_thumbs' => '1',
            'wizards' => array(
                'suggest' => array(
                    'type' => 'suggest'
                )
            )
        )
    ),
    'tx_wngcvcinews_location_link' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_location_link',
        'config' => array(
            'type' => 'input',
            'size' => '25',
            'max' => '128',
            'checkbox' => '',
            'eval' => 'trim',
            'wizards' => array(
                '_PADDING' => 2,
                'link' => array(
                    'type' => 'popup',
                    'title' => 'Link',
                    'icon' => 'link_popup.gif',
                    'module' => array(
                        'name' => 'wizard_element_browser',
                        'urlParameters' => array(
                            'mode' => 'wizard'
                        )
                    ),
                    'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                )
            )
        )
    ),
    'tx_wngcvcinews_event_emails' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_wngcvcinews_event_emails',
        'config' => array(
            'type' => 'inline',
            'foreign_table' => 'tx_wngcvcinews_domain_model_eventemail',
            'foreign_field' => 'event',
            'maxitems'      => 9999,
            'appearance' => array(
                'collapseAll' => 1,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ),
        ),

    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $fields, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news, tx_wngcvcinews_is_event, tx_wngcvcinews_all_day,
    tx_wngcvcinews_price, tx_wngcvcinews_url, tx_wngcvcinews_url_title, --linebreak--, tx_wngcvcinews_theme, tx_wngcvcinews_type, tx_wngcvcinews_phone, tx_wngcvcinews_apero, tx_wngcvcinews_organisor, tx_wngcvcinews_form, tx_wngcvcinews_participant,
    --div--;LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_organizer,tx_wngcvcinews_organizer, tx_wngcvcinews_organizer_id, tx_wngcvcinews_organizer_pid, tx_wngcvcinews_organizer_link,
    --div--;LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_location,tx_wngcvcinews_location, tx_wngcvcinews_latitude, tx_wngcvcinews_longitude, tx_wngcvcinews_address, tx_wngcvcinews_map, tx_wngcvcinews_location_id, tx_wngcvcinews_location_pid, tx_wngcvcinews_location_link,
    --div--;LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail,tx_wngcvcinews_event_emails,'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToAllPalettesOfField (
    'tx_news_domain_model_news',
    'tx_wngcvcinews_all_day',
    'tx_wngcvcinews_start_date, tx_wngcvcinews_start_time, --linebreak--, tx_wngcvcinews_end_date, tx_wngcvcinews_end_time,',
    'after:tx_wngcvcinews_all_day'
);
/*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToAllPalettesOfField (
    'tx_news_domain_model_news',
    'tx_wngcvcinews_price',
    'tx_wngcvcinews_url, tx_wngcvcinews_url_title, tx_wngcvcinews_theme, tx_wngcvcinews_type, tx_wngcvcinews_phone, tx_wngcvcinews_apero, tx_wngcvcinews_organisor, tx_wngcvcinews_form, tx_wngcvcinews_participant,',
    'after:tx_wngcvcinews_price'
);*/
/*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'tx_wngcvcinews_start_date, tx_wngcvcinews_end_date, tx_wngcvcinews_start_time, tx_wngcvcinews_end_time,',
    '',
    'after:tx_wngcvcinews_all_day'
);*/
//addToAllTCAtypes ($table, $newFieldsString, $typeList= '', $position= '')
//addFieldsToAllPalettesOfField ($table, $field, $addFields, $insertionPosition= '')
//addFieldsToPalette ($table, $palette, $addFields, $insertionPosition= '')