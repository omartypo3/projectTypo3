<?php
defined('TYPO3') || die('Access denied.');

$additionalColumns = array(
	'calameo' => array(
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:e_calameo_publisher/Resources/Private/Language/locallang_db.xml:e_calameos.calameo',
		'config' => array(
			'type' => 'input',	
		),
		'size' => 255,
		'autoSizeMax' => 255
	)
);

foreach ($GLOBALS['TCA']['sys_file_metadata']['types'] as $type => $tmp) {
	$GLOBALS['TCA']['sys_file_metadata']['types'][$type]['showitem'] .= ',--div--;LLL:EXT:e_calameo_publisher/Resources/Private/Language/locallang_db.xml:e_calameos.calameo';
	$GLOBALS['TCA']['sys_file_metadata']['types'][$type]['showitem'] .= ',calameo';
}

\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA']['sys_file_metadata']['columns'], $additionalColumns);

return $GLOBALS['TCA']['sys_file_metadata'];