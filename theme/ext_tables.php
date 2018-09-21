<?php
if ( !defined('TYPO3_MODE') ) {
	die ('Access denied.');
}

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Avonis Fluid powered theme for Wagner');

/**
 * Override Ratios
 */
$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config']['ratios'] = array(
	'1'                  => '1:1',
	'1.3333333333333333' => '4:3',
	'1.5'                => '3:2',
	'1.7777777777777777' => '16:9',
	'2.6'                => '13:5',
	'3.8'                => '19:5',
	'NaN'                => 'Frei',
);