<?php
defined('TYPO3') || die('Access denied.');
$_EXTKEY = 'e_import_export';

// Cache hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['additionalBackendItems']['cacheActions']['ECacheStream'] = \Emagineurs\EImportExport\Hooks\Cache::class;
$GLOBALS['TYPO3_CONF_VARS']['BE']['AJAX']['ECacheStream'] = \Emagineurs\EImportExport\Hooks\Cache::class . '->emptyStream';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('e_import_export', 'Configuration/TypoScript', 'E-Import-Export');