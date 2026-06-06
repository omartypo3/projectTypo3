<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$_EXTKEY = "dsl_t3sbootstrap";
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Bootstrap Template');
