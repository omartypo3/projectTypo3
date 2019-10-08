<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'list',
    ['RealEstate' => 'list'],
    ['RealEstate' => 'list']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'list_new_buildings',
    ['RealEstate' => 'listNewBuildings'],
    ['RealEstate' => 'listNewBuildings']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pingag.' . $_EXTKEY,
    'show',
    ['RealEstate' => 'show, contactFormSuccess'],
    ['RealEstate' => 'show, contactFormSuccess']
);

// Realurl Configuration Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['pingag_real_estate'] = 'Pingag\\PingagRealEstate\\Hooks\\Realurl->addConfig';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Pingag\PingagRealEstate\Task\ImportIdxFileTask::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'Immobilien Import IDX3',
    'description' => 'Immportiert Immobilien aus einem File im IDX3 Format.',
    'additionalFields' => \Pingag\PingagRealEstate\Task\ImportIdxFileAdditionalFieldProvider::class
);
