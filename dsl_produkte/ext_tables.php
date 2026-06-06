<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$_EXTKEY ="dsl_produkte";
$extKey ="dsl_produkte";
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Produktsuche',
	'Produktsuche'
);

/*\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Produktshow',
    'Produktshow'
);*/
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Produkthighlights',
	'Produkthighlights'
);
//dslmod eingriff
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Produktbrowser',
	'Produktbrowser'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Produktopengraph',
	'Produktopengraph'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Produkte');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_eigenschaften', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_eigenschaften.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_eigenschaften');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_anwendungsbereiche', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_anwendungsbereiche.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_anwendungsbereiche');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_zubehoer', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_zubehoer.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_zubehoer');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_kategorien', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_kategorien.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_kategorien');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_produkte', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_produkte.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_produkte');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslprodukte_domain_model_highlights', 'EXT:dsl_produkte/Resources/Private/Language/locallang_csh_tx_dslprodukte_domain_model_highlights.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslprodukte_domain_model_highlights');


$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName).'_produkthighlights';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_highlight.xml');