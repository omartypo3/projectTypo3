<?php
$ll = 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:';

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:tx_eimportexport_domain_model_conf',
		'label' => 'title',
		'label_userFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getConfTitle',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'type' => 'type',

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'requestUpdate' => 'interaction',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,tag,export,import,module,scheduler,ajax,tables,fields,',
		'iconfile' => 'EXT:e_import_export/Resources/Public/Icons/tx_eimportexport_domain_model_conf.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, tag, title, type, interaction, interface, url, tables, uniqfield, forceadd, fields',
	),
	'types' => array(
		'1' => array('showitem' => 'title, tag, hidden, type, interaction, interface, url, tables, uniqfield, forceadd, fields'),
	),
	'palettes' => array(
		'paletteDates' => array('showitem' => 'starttime, endtime'),
	),
	'columns' => array(
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'interaction' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.interaction',
			'config' => array(
				'type' => 'radio',
				'items' => array(
					array($ll.'tx_eimportexport_domain_model_conf.export', 0),
					array($ll.'tx_eimportexport_domain_model_conf.import', 1),
				),
			)
		),
		'type' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.type',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'itemsProcFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getFileTypes',
				'size' => 1,
				'maxitems' => 1,
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.title',
			'config' => array(
				'type' => 'input',
				'size' => 10,
			)
		),
		'tag' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.tag',
			'config' => array(
				'type' => 'input',
				'size' => 10,
			)
		),
		'url' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.url',
			'config' => array(
				'type' => 'input',
			),
			'displayCond' => 'FIELD:interaction:=:1'
		),
		'interface' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.interface',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array($ll.'tx_eimportexport_domain_model_conf.module', 0),
					array($ll.'tx_eimportexport_domain_model_conf.scheduler', 1),
					array($ll.'tx_eimportexport_domain_model_conf.ajax', 2),
				),
				'minitems' => 1,
				'maxitems' => 3,
				'size' => 3,
			)
		),
		'tables' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.tables',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eimportexport_domain_model_table',
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'uniqfield' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.uniqfield',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'size' => 3,
				'maxitems' => 99,
				'eval' => '',
				'itemsProcFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getAllFieldsUniqField',
			),
			'displayCond' => 'FIELD:interaction:=:1'
		),
                'forceadd' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.forceadd',
			'config' => array(
				'type' => 'select',
                                'renderType' => 'selectSingle',
				'items' => array(
					array($ll.'tx_eimportexport_domain_model_conf.forceadd0', 0),
					array($ll.'tx_eimportexport_domain_model_conf.forceadd1', 1),
				),
			),
			'displayCond' => 'FIELD:interaction:=:1'
		),
		'fields' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_conf.fields',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eimportexport_domain_model_field',
				'foreign_sortby' => 'sorting',
				'minitems' => 1,
				'maxitems' => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'useSortable' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		
	),
);
