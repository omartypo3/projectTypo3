<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bb_downloadlog/Resources/Private/Language/locallang_db.xlf:tx_bbdownloadlog_domain_model_entry',
		'label' => 'zeitpunkt',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',

		'enablecolumns' => array(

		),
		'searchFields' => 'zeitpunkt,feuser,feusergroups,file,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('bb_downloadlog') . 'Resources/Public/Icons/tx_bbdownloadlog_domain_model_entry.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, zeitpunkt, feuser, feusergroups, file',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, zeitpunkt, feuser, feusergroups, file, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_bbdownloadlog_domain_model_entry',
				'foreign_table_where' => 'AND tx_bbdownloadlog_domain_model_entry.pid=###CURRENT_PID### AND tx_bbdownloadlog_domain_model_entry.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),

		'zeitpunkt' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_downloadlog/Resources/Private/Language/locallang_db.xlf:tx_bbdownloadlog_domain_model_entry.zeitpunkt',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00'
			),
		),
		'feuser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_downloadlog/Resources/Private/Language/locallang_db.xlf:tx_bbdownloadlog_domain_model_entry.feuser',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'feusergroups' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_downloadlog/Resources/Private/Language/locallang_db.xlf:tx_bbdownloadlog_domain_model_entry.feusergroups',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'file' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_downloadlog/Resources/Private/Language/locallang_db.xlf:tx_bbdownloadlog_domain_model_entry.file',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_cms_core_resource_file',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		
	),
);## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder