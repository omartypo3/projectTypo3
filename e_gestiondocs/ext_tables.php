<?php
defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'e_gestiondocs', 
    'Configuration/TypoScript', 
    'GestionDocs TS-config [default]'
);