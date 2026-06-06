<?php

defined('TYPO3_MODE') or die();
$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL_tca = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf';
$_LLL_ttc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf';
$_LLL = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf';
$_LLL_cart = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$new_cart_columns = [

    'files' => [
        'exclude' => 1,
        'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.files',
        'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
            'files',
            [
                'appearance' => [
                    'createNewRelationLinkTitle' => $_LLL_ttc . ':images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                ],
                'foreign_match_fields' => [
                    'fieldname' => 'files',
                    'tablenames' => 'tx_cartproducts_domain_model_product_product',
                    'table_local' => 'sys_file',
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;' . $_LLL_tca . ':sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                    ],
                ],
                'minitems' => 0,
                'maxitems' => 99,
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ', pdf, docs ,doc ,docx'
        ),
    ],
    'Szblindnummer' => [
        'exclude' => true,
        'label' => 'ISBN-Nr',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'Verfasser' => Array(
        'exclude' => 1,
        'label' => 'Verfasser',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ),
    'Verlag' => [
        'exclude' => true,
        'label' => 'Ort/Verlag',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'Jahr' => [
        'exclude' => true,
        'label' => 'Jahr',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'Seitenanzahl' => [
        'exclude' => true,
        'label' => 'Seitenanzahl',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'teaser' => [
        'exclude' => 1,
        'label' => 'Zusatzinfo',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_cartproducts_domain_model_product_product',$new_cart_columns);
//$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['types']['1']['showitem'] .= ' --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.images_and_files,';
//$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['types']['1']['showitem'] .= 'header_image, images, files';
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['types']['1']['showitem'] .= ',--div--;Bücher,';
$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['types']['1']['showitem'] .= 'Szblindnummer, Verfasser, Verlag, Jahr, Seitenanzahl ';
