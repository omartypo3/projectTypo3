<?php


/**
 * Add extra fields to sys_file_reference record
 */
$newSysFileReferenceColumns = array(
	'copyright' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_efilereference.copyright',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'largeur' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_efilereference.largeur',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'hauteur' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_efilereference.hauteur',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newSysFileReferenceColumns);

// add special news palette
$GLOBALS['TCA']['sys_file_reference']['palettes']['imageoverlayPalette']['showitem'] .= ',--linebreak--,copyright,--linebreak--,largeur,hauteur';

