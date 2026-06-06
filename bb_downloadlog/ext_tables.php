<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$_EXTKEY = "bb_downloadlog";
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Downloadlog');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bbdownloadlog_domain_model_entry', 'EXT:bb_downloadlog/Resources/Private/Language/locallang_csh_tx_bbdownloadlog_domain_model_entry.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bbdownloadlog_domain_model_entry');
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder