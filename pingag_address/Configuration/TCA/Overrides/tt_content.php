<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'PingagAddress',
    'Mapshow',
    'mapShow'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'PingagAddress',
    'AddressCommunication',
    'addressCommunication'
);
// plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
$pluginSignature = 'pingagaddress_mapshow';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    // Flexform configuration schema file
    'FILE:EXT:pingag_address/Configuration/FlexForms/locations.xml'
);