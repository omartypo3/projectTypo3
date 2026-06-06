<?php
if (!defined('TYPO3')) {
	die('Access denied.');
}

$_EXTKEY = 'e_news';

$enewsAllActions = ['filterToday', 'filterWeekend', 'filterWeek', 'filterMonth', 'create', 'add', 'update', 'delete', 'validate'];
$enewsCacheableActions = ['create', 'add', 'edit', 'delete', 'validate'];

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['News']['plugins']['Pi1']['controllers']['News']['actions'] = array_merge(
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['News']['plugins']['Pi1']['controllers']['News']['actions'] ?? [],
	$enewsAllActions
);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['News']['plugins']['Pi1']['controllers']['News']['nonCacheableActions'] = array_merge(
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['News']['plugins']['Pi1']['controllers']['News']['nonCacheableActions'] ?? [],
	$enewsCacheableActions
);

// Inclusion of the static typoscript template of e_news
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'e_news');

// We add the dates fields of e_news to the sorting options in news flexform, or field for recurring date if it has been activated
$confExtTpl = [];
try {
    $confExtTpl = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('e_news');
} catch (\Exception $e) {
}

if($confExtTpl['useDateOcurrences'] ?? false){
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['orderByNews'] .= ',dates';
} else {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['orderByNews'] .= ',begindate,finishdate';
}
