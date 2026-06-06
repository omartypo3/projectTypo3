<?php
declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function() {
    $extensionKey = 'bb_wissenswertes';
    $vendorExtensionName = 'BbWissenswertes';
    $tableName = 'tx_bbwissenswertes_domain_model_wissenswertes';

    // Register Wissenswertes plugin
    ExtensionUtility::registerPlugin(
        $vendorExtensionName,
        'Wissenswertes',
        'wissenswertes',
        'EXT:bb_wissenswertes/Resources/Public/Icons/Extension.svg'
    );

    // Add TypoScript static template
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Wissenswertes'
    );

    // Add TCA descriptions
    ExtensionManagementUtility::addLLrefForTCAdescr(
        $tableName,
        'EXT:bb_wissenswertes/Resources/Private/Language/locallang_csh_' . $tableName . '.xlf'
    );

    // Allow table on standard pages
    ExtensionManagementUtility::allowTableOnStandardPages($tableName);
});