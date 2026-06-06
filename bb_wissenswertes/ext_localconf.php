<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbwissenswertes',
	'Wissenswertes',
	array(
		\BravoBuero\BbWissenswertes\Controller\WissenswertesController::class => 'list',
		
	),
	// non-cacheable actions
	array(
		\BravoBuero\BbWissenswertes\Controller\WissenswertesController::class => '',
		
	)
);
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['custom'] = 'fileadmin/template_web/Configuration/RTE/Custom.yaml';