<?php

defined('TYPO3') or die();



/***************

 * Plugin

 */



#$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['news_pi1'] = 'recursive,select_key,pages';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immoout'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immoout',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_ausgabe.xml');


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immodetail'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immodetail',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_ausgabe.xml');



$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immosearch'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immosearch',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_ausgabe.xml');



$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immobookmark'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immobookmark',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_bookmarks.xml');



$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immohighlights'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immohighlights',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_highlights.xml');



$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immolatest'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immolatest',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_latest.xml');


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['dslimmo_immoselected'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('dslimmo_immoselected',

    'FILE:EXT:dsl_immo/Configuration/FlexForms/flexform_selected.xml');



$GLOBALS['TCA']['tt_content']['types']['extkey_element']['columnsOverrides']['image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = [
    'pdf3zu2' => [
        'title' => 'Crop auf 3:2',
        'allowedAspectRatios' => [
            '3 : 2' => [
                'title' => '3 : 3',
                'value' => 16 / 2
            ]
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'Immobiliensuche',
        'dslimmo_immosearch',
        ''
    ),
    'CType',
    'dsl_immo'
);



