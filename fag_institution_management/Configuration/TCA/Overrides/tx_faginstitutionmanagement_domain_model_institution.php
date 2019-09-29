<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
   'fag_institution_management',
   'tx_faginstitutionmanagement_domain_model_institution'
);
