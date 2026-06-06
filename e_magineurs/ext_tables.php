<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}
$_EXTKEY = 'e_magineurs';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'plaine-commune/Configuration/TypoScript',
    'Configuration du site plaine-commune'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $_EXTKEY,
    'plaine-commune/Configuration/TSConfig/tsconfig.txt',
    'EXT:e_magineurs : plaine-commune - Tsconfig'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $_EXTKEY,
    'plaine-commune/Configuration/TSConfig/publications.txt',
    'EXT:e_magineurs : plaine-commune - Publications'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'site-factory/Configuration/TypoScript',
    'Configuration du Site Factory'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $_EXTKEY,
    'site-factory/Configuration/TSConfig/tsconfig.txt',
    'EXT:e_magineurs : site-factory - Tsconfig'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:news/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:e_magineurs/locallang_db.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:e_news/Resources/Private/Language/locallang_csh_tx_news_domain_model_news.xlf'][] = 'EXT:e_magineurs/locallang_db.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:e_news/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:e_magineurs/locallang_db.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:e_news/Resources/Private/Language/locallang.xlf'][] = 'EXT:e_magineurs/locallang_db.xlf';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:e_magineurs/locallang_db.xml';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['fr']['EXT:e_annuaires/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:e_magineurs/locallang_db.xml';

// Add custom Solr translations
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:solr/Resources/Private/Language/locallang.xlf'][] = 'EXT:e_magineurs/plaine-commune/Resources/Extensions/solr/Language/locallang.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['fr']['EXT:solr/Resources/Private/Language/locallang.xlf'][] = 'EXT:e_magineurs/plaine-commune/Resources/Extensions/solr/Language/locallang.xlf';

//Handler pour vider les enregistrements jours de collecte avant import
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['import']['csv'] = 'Emagineurs\\EMagineurs\\ImportExport\\ImportCsvHandlers';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Emagineurs\\EAnnuaires\\Controller\\FicheController']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\EFicheController';
