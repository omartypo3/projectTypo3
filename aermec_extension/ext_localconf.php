<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'AermecExtension.' . $_EXTKEY,
	'Aermecextension',
	array(
		'AermecExtension' => 'list, show, new, create, edit, update, delete,setLanguage,setCatalogue',
		
	),
	// non-cacheable actions
	array(
		'AermecExtension' => 'list, show, new, create, edit, update, delete,setLanguage,setCatalogue',
		
	)
);
