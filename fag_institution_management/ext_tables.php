<?php
defined('TYPO3_MODE') || die('Access denied.');

// Institution Model
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_faginstitutionmanagement_domain_model_institution');

// Role Model
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_faginstitutionmanagement_domain_model_role');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_faginstitutionmanagement_domain_model_dates');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_faginstitutionmanagement_domain_model_linkev');

// Override label_alt for tt_address items
$GLOBALS['TCA']['tt_address']['ctrl']['label_alt'] = 'company';
