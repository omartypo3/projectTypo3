<?php
defined('TYPO3') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'egestiondocs',
    'LLL:EXT:e_gestiondocs/Resources/Private/Language/locallang_be.xlf:plugin.group.documentmanagement'
);

// Plugin: Folders and File List
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGestiondocs',
    'List',
    'Gestion documentaire - Folders and File List',
    'EXT:e_gestiondocs/Resources/Public/Icons/ext_icon.gif',
    'egestiondocs'
);
$pluginSignature = 'egestiondocs_list';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gestiondocs/Configuration/FlexForms/flexform_list.xml'
);

// Plugin: Search form
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGestiondocs',
    'Search',
    'Gestion documentaire - Search form',
    'EXT:e_gestiondocs/Resources/Public/Icons/ext_icon.gif',
    'egestiondocs'
);
$pluginSignature = 'egestiondocs_search';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gestiondocs/Configuration/FlexForms/flexform_search.xml'
);

// Plugin: List new files
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGestiondocs',
    'ListNew',
    'Gestion documentaire - List new files',
    'EXT:e_gestiondocs/Resources/Public/Icons/ext_icon.gif',
    'egestiondocs'
);
$pluginSignature = 'egestiondocs_listnew';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gestiondocs/Configuration/FlexForms/flexform_listnew.xml'
);

// Plugin: Browse directories
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGestiondocs',
    'Browse',
    'Gestion documentaire - Browse directories',
    'EXT:e_gestiondocs/Resources/Public/Icons/ext_icon.gif',
    'egestiondocs'
);
$pluginSignature = 'egestiondocs_browse';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gestiondocs/Configuration/FlexForms/flexform_browse.xml'
);

// Plugin: Select files to list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGestiondocs',
    'ListSelected',
    'Gestion documentaire - Select files to list',
    'EXT:e_gestiondocs/Resources/Public/Icons/ext_icon.gif',
    'egestiondocs'
);
$pluginSignature = 'egestiondocs_listselected';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gestiondocs/Configuration/FlexForms/flexform_listselected.xml'
);

