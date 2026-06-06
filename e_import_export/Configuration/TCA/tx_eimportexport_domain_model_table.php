<?php

$ll = 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:';

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:tx_eimportexport_domain_model_table',
		'label' => 'name', 
		'label_userFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getTableName',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'requestUpdate' => 'principale,name',
		'hideTable' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'principale,name',
		'iconfile' => 'EXT:e_import_export/Resources/Public/Icons/tx_eimportexport_domain_model_table.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'name, wheretext',
	),
	'types' => array(
		'1' => array('showitem' => 'name, wheretext'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'name' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_table.name',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('Choisissez une table', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => '',
				'itemsProcFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getTables',
			),
		),
		'wheretext' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_table.wheretext',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
			)
		),
		
	),
);