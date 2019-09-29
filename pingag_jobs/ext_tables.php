<?php
defined('TYPO3_MODE') or die();

$configurePluginWithFlexform = function($pluginKey, $pluginLabel, $useFlexform = true) use (&$_EXTKEY, &$TCA)
{
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Pingag.' . $_EXTKEY,
        $pluginKey,
        $pluginLabel
    );

    if($useFlexform){
        $pluginSignature = str_replace('_','',$_EXTKEY) . '_' . $pluginKey;
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/'.$pluginKey.'.xml');
    }
};

// Register Plugins
$configurePluginWithFlexform('list', 'Jobangebote: Liste', false);
$configurePluginWithFlexform('show', 'Jobangebote: Details', false);

// Include TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Pingag Jobs');

// Allow Tables + add TCA

$extensionTables = [
];

// Register TCA & TableOnStandardPages
foreach ($extensionTables as $extensionTable) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr($extensionTable, "EXT:pingag_jobs/Resources/Private/Language/$extensionTable.xlf");
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages($extensionTable);
}

// Register Icons
// https://www.iconfinder.com/iconsets/circle-icons-1
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

$iconRegistry->registerIcon(
    'property-type',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:pingag_jobs/Resources/Public/Icons/property-type.svg']
);

$iconRegistry->registerIcon(
    'property-section',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:pingag_jobs/Resources/Public/Icons/property-section.svg']
);

$iconRegistry->registerIcon(
    'property-city',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:pingag_jobs/Resources/Public/Icons/property-city.svg']
);