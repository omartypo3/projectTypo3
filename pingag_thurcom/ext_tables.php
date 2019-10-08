<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('pingag_thurcom', 'Configuration/TypoScript', 'Thurcom');

    }
);

$configurePluginWithFlexform = function($pluginKey, $pluginName, $useFlexform = true) use (&$_EXTKEY, &$TCA)
{
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Pingag.' . $_EXTKEY,
        $pluginKey,
        $pluginName
    );

    if($useFlexform){
        $pluginSignature = str_replace('_','',$_EXTKEY) . '_' . $pluginKey;
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/'.$pluginKey.'.xml');
    }
};


$configurePluginWithFlexform('channel', 'Thurcom Sender');
$configurePluginWithFlexform('service_location', 'Thurcom-Partner');
$configurePluginWithFlexform('city', 'Versorgungsgebiet');
$configurePluginWithFlexform('subscription', 'Abo Übersicht');
$configurePluginWithFlexform('product', 'Produkte und Zubehör');
$configurePluginWithFlexform('product_consultation', 'Abo-Berater');
$configurePluginWithFlexform('channel_package', 'Zusatzpakete');
