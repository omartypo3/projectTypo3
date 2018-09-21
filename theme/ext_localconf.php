<?php
if ( !defined('TYPO3_MODE') ) {
	die ('Access denied.');
}

\FluidTYPO3\Flux\Core::registerProviderExtensionKey('Avonis.Theme', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('Avonis.Theme', 'Content');

//
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:flux/Resources/Private/Language/locallang.xlf'][] = 'EXT:theme/Resources/Private/Language/locallang.xlf';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['gb']['EXT:flux/Resources/Private/Language/locallang.xlf'][] = 'EXT:theme/Resources/Private/Language/gb.locallang.xlf';
