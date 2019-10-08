<?php
defined('TYPO3_MODE') or die();

$extKey = 'pingag_real_estate';

// Register Plugins
$configurePlugin = function ($pluginKey, $pluginLabel, $useFlexform = true, $flexFormFile = null) use (&$extKey, &$TCA) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Pingag.' . $extKey,
        $pluginKey,
        $pluginLabel
    );

    if ($useFlexform) {
        $pluginSignature = str_replace('_', '', $extKey) . '_' . $pluginKey;
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        if (!$flexFormFile) $flexFormFile = $pluginKey;
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/' . $flexFormFile . '.xml');
    }
};

$configurePlugin('list', 'Real Estate: Liste');
$configurePlugin('list_new_buildings', 'Real Estate: Neubauten');
$configurePlugin('show', 'Real Estate: Detail', false);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Pingag Real Estate');