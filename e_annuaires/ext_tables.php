<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'annuaires',
    'Annuaires'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('e_annuaires', 'Configuration/TypoScript/', 'Annuaires');

