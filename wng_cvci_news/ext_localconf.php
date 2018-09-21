<?php

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

//Event view
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['--div--'] = 'Events';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->eventList;News->eventDetail'] = 'List view';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->eventSearchList;News->eventDetail'] = 'Search form + List view';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->eventDetail'] = 'Detail view';

//Register the hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['getFlexFormDSClass'][] = \Wng\WngCvciNews\Hooks\FlexFormHook::class;

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Controller/NewsController'][] = 'wng_cvci_news';

?>