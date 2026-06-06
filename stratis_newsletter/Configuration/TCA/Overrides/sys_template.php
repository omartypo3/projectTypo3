<?php
defined('TYPO3') or die();

/**
 * Register TS static file
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	'stratis_newsletter',
	'Configuration/TypoScript',
	'STRATIS : Newsletter'
);
