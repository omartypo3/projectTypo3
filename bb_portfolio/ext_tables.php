<?php
declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function() {
    $extensionKey = 'bb_portfolio';
    $vendorExtensionName = 'BbPortfolio';
    $tables = [
        'kunden',
        'portfolio',
        'hashtags',
        'kategorien',
        'branchen'
    ];

    // Register all plugins
    $plugins = [
        'Kundenslider' => 'Customer Slider',
        'Portfolioausgabe' => 'Portfolio Output',
        'PortfolioausgabeKunden' => 'Portfolio Output Liste mit Kunden',
        'PortfolioausgabeLatest' => 'Portfolio Output Latest Startseite Frische Projekte',
        'PortfolioausgabeKategorien' => 'Portfolio Output Latest nach Kategorien',
        'Megamenu' => 'Mega Menu',
        'Pagebrowser' => 'Page Browser',
        'Pagebrowserback' => 'Page Browser Back',
        'Pagebrowserkunden' => 'Customer Page Browser',
        'Portfoliodetailrelated' => 'Related Portfolio Items'
    ];

    foreach ($plugins as $pluginKey => $pluginTitle) {
        ExtensionUtility::registerPlugin(
            $vendorExtensionName,
            $pluginKey,
            $pluginTitle,
            'EXT:bb_portfolio/Resources/Public/Icons/Extension.gif'
        );
    }

    // Add FlexForm for Portfolioausgabe plugin
    $pluginSignature = strtolower($vendorExtensionName) . '_portfolioausgabe';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:bb_portfolio/Configuration/FlexForms/flexform_portfolioausgabe.xml'
    );

    // Add FlexForm for Portfolioausgabe plugin
    $pluginSignature = strtolower($vendorExtensionName) . '_portfolioausgabe';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:bb_portfolio/Configuration/FlexForms/flexform_portfolioausgabe.xml'
    );

    // Add FlexForm for Portfolioausgabelatest plugin
    $pluginSignaturelatest = strtolower($vendorExtensionName) . '_portfolioausgabelatest';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignaturelatest] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignaturelatest,
        'FILE:EXT:bb_portfolio/Configuration/FlexForms/flexform_portfolioausgabeLatest.xml'
    );

    // Add FlexForm for PortfolioausgabeKategorien plugin
    $pluginSignatureKategorien = strtolower($vendorExtensionName) . '_portfolioausgabekategorien';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignatureKategorien] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignatureKategorien,
        'FILE:EXT:bb_portfolio/Configuration/FlexForms/flexform_portfolioausgabeKategorien.xml'
    );

     // Add FlexForm for Portfolioausgabekunden plugin
    $pluginSignaturekunden = strtolower($vendorExtensionName) . '_portfolioausgabekunden';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignaturekunden] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignaturekunden,
        'FILE:EXT:bb_portfolio/Configuration/FlexForms/flexform_portfolioausgabekunden.xml'
    );

    // Add static TypoScript template
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'bb_portfolio'
    );

    // Configure all tables
    foreach ($tables as $table) {
        $tableName = 'tx_' . $extensionKey . '_domain_model_' . $table;
        ExtensionManagementUtility::addLLrefForTCAdescr(
            $tableName,
            'EXT:bb_portfolio/Resources/Private/Language/locallang_csh_' . $tableName . '.xlf'
        );
        ExtensionManagementUtility::allowTableOnStandardPages($tableName);
    }
});