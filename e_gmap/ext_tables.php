<?php
defined('TYPO3') || die('Access denied.');

// Register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EGmap',
    'Gmap',
    'Google Map',
    'EXT:e_gmap/Resources/Public/Icons/ce_wiz.gif'
);

$pluginSignature = 'egmap_gmap';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:e_gmap/Configuration/FlexForms/flexform_gmap.xml'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'e_gmap',
    'Configuration/TypoScript',
    'EGmap'
);
