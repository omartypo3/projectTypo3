<?php
defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'e_calameo_publisher';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = 'ecalameopublisher_calameoplugin';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$extensionName,
	'CalameoPlugin',
	'Afficher des publications Calameo'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_ds_pi1.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'CalameoModule');