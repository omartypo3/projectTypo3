<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fag_institution_management', 'Configuration/TypoScript', 'FRONTAL / Institutionen');
