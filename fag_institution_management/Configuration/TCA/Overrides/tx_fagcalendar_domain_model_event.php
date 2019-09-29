<?php
defined('TYPO3_MODE') || die();

$tmp_fag_institution_management_columns = [

    'institution' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_function.institution',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_faginstitutionmanagement_domain_model_institution',
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
    'images' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_calendar/Resources/Private/Language/locallang_db.xml:tx_fagcalendar_domain_model_event.image',
        'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
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
                    'maxitems' => 999
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

    ],
    'links' => [
        'exclude' => true,
        'label' => 'Links',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_faginstitutionmanagement_domain_model_linkev',
            'MM' => 'tx_faginstitutionmanagement_event_linkev_mm',

        ],
    ],
    'dates' => [
        'exclude' => true,
        'label' => 'dates',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_faginstitutionmanagement_domain_model_dates',
            'MM' => 'tx_fagcalendar_event_dates_mm',
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_fagcalendar_domain_model_event',$tmp_fag_institution_management_columns);

//$GLOBALS['TCA']['tx_fagcalendar_domain_model_event']['types']['1']['showitem'] .= ',--div--;Allgemein,';
$GLOBALS['TCA']['tx_fagcalendar_domain_model_event']['types']['1']['showitem'] = 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, images, dates , institution , links, --palette--;;startfields,--palette--;;endfields, date_text, --palette--;;locationfields,--palette--;,teaser_text, body_text, detail_link, organizer_text, document, additional_field_one, additional_field_two, organizer, category,--div--;LLL:EXT:fag_calendar/Resources/Private/Language/locallang_db.xml:tab.signup,signup_email,signup_date,signup_max_participants,signup_text,signup_email_text,signup_email_attachments,--div--;LLL:EXT:fag_calendar/Resources/Private/Language/locallang_db.xml:tab.participants,participants,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime';
$GLOBALS['TCA']['tx_fagcalendar_domain_model_event']['ctrl']['hideTable'] = 1;