<?php
defined('TYPO3_MODE') or die();

// Realurl Configuration Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['pingag_thurcom'] = 'Pingag\\PingagThurcom\\Hooks\\Realurl->addConfig';

// Add Plugins to Plugin Wizard
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pingag_thurcom/Configuration/TSconfig/ContentElementWizard.txt">');

// Channel Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'channel',
    ['Channel' => 'list, iconlist, listPackages'],
    ['Channel' => 'list, iconlist, listPackages']
);

// Service Location Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'service_location',
    ['ServiceLocation' => 'list, search, searchAdvanced, searchService, listService, searchAdvancedAbo'],
    ['ServiceLocation' => 'list, search, searchAdvanced, searchService, listService, searchAdvancedAbo']
);

// City Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'city',
    ['City' => 'search, searchAdvanced, searchAbo'],
    ['City' => 'search, searchAdvanced, searchAbo']
);

// Subscription Order Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'subscription',
    ['Subscription' => 'order, create, listPackages'],
    ['Subscription' => 'order, create, listPackages']
);

// Zubehör / Produkte Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'product',
    ['Product' => 'list, show'],
    ['Product' => 'list, show']
);

// Abo-Berater Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'product_consultation',
    ['ProductConsultation' => 'show'],
    ['ProductConsultation' => 'show']
);

// Zusatzpakete Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'channel_package',
    ['ChannelPackage' => 'list, listOrder'],
    ['ChannelPackage' => 'list, listOrder']
);
// wizards
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('Pingag\\PingagThurcom\\Property\\TypeConverter\\UploadedFileReferenceConverter');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('Pingag\\PingagThurcom\\Property\\TypeConverter\\ObjectStorageConverter');



