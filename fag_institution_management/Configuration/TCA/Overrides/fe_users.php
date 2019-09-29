<?php
defined('TYPO3_MODE') || die();

$tmp_fag_institution_management_columns = [
    'privileges' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_user.privilege',
        'config' => [
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_faginstitutionmanagement_domain_model_institution',
            'foreign_table' => 'tx_faginstitutionmanagement_domain_model_institution',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'MM' => 'tx_faginstitutionmanagement_fe_users_institution_mm',
            'MM_opposite_field' => 'fe_users',
            'suggestOptions' => [
                'default' => [
                    'suggestOptions' => true,
                    'addWhere' => ' AND tx_faginstitutionmanagement_domain_model_institution.uid != ###THIS_UID###'
                ]
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
    'roles' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.user',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_faginstitutionmanagement_domain_model_role',
            'foreign_field' => 'user',
        ],
    ],
    'iscitycouncil' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.citycouncil',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'show_in_register' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.show_in_register',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'ismanagement' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.ismanagement',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'management_position' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.management_position',
        'config' => [
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim,num'
        ],
    ],
    'ismanagement_deputy' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.ismanagement_deputy',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'management_deputy_position' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.management_deputy_position',
        'config' => [
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim,num'
        ],
    ],
    'no_frontend_login' => [
        'exclude' => true,
        'label' => 'LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_role.no_frontend_login',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'title_agency' => [
        'exclude' => true,
        'label' => 'Stellvertretung für:',
        'config' => [
            'type' => 'input',
            'max' => 40,
            'eval' => 'trim',
            'size' => 20
        ],
    ],
];

$tempImageColumn = Array (
    'secondary_image' => array(
        'exclude' => 1,
        'label' => 'Bild 2',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'secondary_image',
            array(
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'foreign_types' => array(
                    '0' => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                    )
                ),
                'maxitems' => 1
            ),
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
        'pdf,doc,docx'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_fag_institution_management_columns);

// create new palette for username and no_frontend_login
$GLOBALS['TCA']['fe_users']['palettes']['username'] = array(
    'showitem' => 'username,no_frontend_login',
);
$GLOBALS['TCA']['fe_users']['columns']['image']['config'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
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
        'foreign_match_fields' => [
            'fieldname' => 'image',
            'tablenames' => 'fe_users',
            'table_local' => 'sys_file',
        ],
    ],
    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
);
$GLOBALS['TCA']['fe_users']['palettes']['management']['showitem'] = 'ismanagement,management_position';
$GLOBALS['TCA']['fe_users']['palettes']['deputy']['showitem'] = 'ismanagement_deputy,management_deputy_position';

$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] .= ',--div--;LLL:EXT:fag_institution_management/Resources/Private/Language/locallang_db.xlf:tx_faginstitutionmanagement_domain_model_user,';
$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] .= 'privileges, roles, iscitycouncil,--palette--;;management,--palette--;;deputy,show_in_register';

$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] = str_replace('general,', 'general,--palette--;;username,', $GLOBALS['TCA']['fe_users']['types']['0']['showitem']);
$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] = str_replace('username,password,', 'password,', $GLOBALS['TCA']['fe_users']['types']['0']['showitem']);

$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] = str_replace('title,','title,title_agency,',$GLOBALS['TCA']['fe_users']['types']['0']['showitem']);

// secondary image
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("fe_users", $tempImageColumn, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("fe_users","secondary_image", 'after:image');
$GLOBALS['TCA']['fe_users']['types']['0']['showitem'] = str_replace('image,','image,secondary_image,',$GLOBALS['TCA']['fe_users']['types']['0']['showitem']);

// fe_users sorting
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users','sorting;;;;1-1-1');

$GLOBALS['TCA']['fe_users']['ctrl']['sortby'] = 'sorting';
unset($GLOBALS['TCA']['fe_users']['ctrl']['default_sortby']);

// override default configuration
$GLOBALS['TCA']['fe_users']['columns']['username']['config']['eval'] = 'nospace,trim,lower,FRONTAL\\FagInstitutionManagement\\Evaluation\\UniqueFrontendUserEvaluation,required,email';
//$GLOBALS['TCA']['fe_users']['columns']['username']['config']['eval'] = 'nospace,trim,lower,unique,required,email';
