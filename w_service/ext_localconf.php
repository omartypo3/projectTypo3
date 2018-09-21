<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'ServicePartner' => 'map',
	),
	// non-cacheable actions
	array(
		'ServicePartner' => 'map',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'International',
	array(
		'ServicePartner' => 'internationalMap',
	),
	// non-cacheable actions
	array(
		'ServicePartner' => 'internationalMap',
	)
);


Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'ajax',
	array(
		'ServicePartner' => 'search',
	),
	// non-cacheable actions
	array(
		'ServicePartner' => 'search',
	)
);

$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_wservice_scheduler_converttask'] = array(
    'extension' => $_EXTKEY,
    'title'            => 'Address->Geo Convert',
    'description'      => 'Converts address info to geo coordinates',
    'additionalFields' => 'tx_wservice_scheduler_converttaskadditionalfieldprovider'
);
$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_wservice_scheduler_cleartask'] = array(
    'extension' => $_EXTKEY,
    'title'            => 'Address->Geo Clear',
    'description'      => 'Clears saved geo coordinates',
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Avonis\\WService\\Scheduler\\ImportTask'] = array(
    'extension' => $_EXTKEY,
    'title'            => 'Address->Geo Import',
    'description'      => 'Import Addresses records from xls files'
);

//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tx_WService_Command_ConvertCommandController';
?>