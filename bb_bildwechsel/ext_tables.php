<?php
declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {
    $extensionKey = 'bb_bildwechsel';
    $pluginName = 'Bildwechsel';
    $tableName = 'tx_bbbildwechsel_domain_model_slides';

    // Register plugin with modern syntax
    ExtensionUtility::registerPlugin(
        'BbBildwechsel', // Vendor.ExtensionName format
        $pluginName,
        'Bildwechsel Slideshow', // More descriptive label
        'EXT:bb_bildwechsel/Resources/Public/Icons/Extension.svg' // Optional icon
    );

    // Add TypoScript static template
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Bildwechsel Configuration'
    );

    // Add TCA descriptions (if still needed)
    ExtensionManagementUtility::addLLrefForTCAdescr(
        $tableName,
        'EXT:bb_bildwechsel/Resources/Private/Language/locallang_csh_' . $tableName . '.xlf'
    );

    // Allow table on standard pages
    ExtensionManagementUtility::allowTableOnStandardPages($tableName);
});