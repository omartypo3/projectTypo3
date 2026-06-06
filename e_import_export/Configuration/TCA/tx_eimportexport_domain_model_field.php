<?php
$ll = 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:';

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_import_export/Resources/Private/Language/locallang_db.xlf:tx_eimportexport_domain_model_field',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'hideTable' => TRUE,
		'requestUpdate' => 'type',

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
		'searchFields' => 'type,name,tablefield,stdwrap,multiple,relation,',
		'iconfile' => 'EXT:e_import_export/Resources/Public/Icons/tx_eimportexport_domain_model_field.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, type, name, tablefield, format, stdwrap, relation, multiple',
	),
	'types' => array(
		'1' => array('showitem' => 'type, name, tablefield, format, userpost, stdwrap, arrcheck, relation, multiple,ifempty,forcefield'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'type' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.type',
			'config' => array(
				'type' => 'select',
                                'renderType' => 'selectSingle',
				'items' => array(
					array('VALUE', 0),
					array('RELATION', 1),
				//	array('MULTIPLE', 2),
					array('TIME', 3),
					array('FILE', 4),
					array('FIXED VALUE', 5),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'name' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'tablefield' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.tablefield',
			'config' => array(
				'type' => 'select',
                    'renderType' => 'selectSingle',
				'items' => array(
					array($ll.'tx_eimportexport_domain_model_field.choose_a_field', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => '',
				'itemsProcFunc' => 'Emagineurs\EImportExport\UserItemProcFunc->getAllFields',
			),
			'displayCond' => 'FIELD:type:!IN:2'
		),
		'format' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.format',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:IN:3,4,5'
		),
		'stdwrap' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.stdwrap',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:!=:1'
		),
                'userpost' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.userpost',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 3,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		'arrcheck' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.arrcheck',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		'isunique' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.isunique',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			),
			'displayCond' => 'FIELD:type:=:0'
		),
		'forcefield' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.forcefield',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		'ifempty' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.ifempty',
			'config' => array(
				'type' => 'select',
                                'renderType' => 'selectSingle',
				'items' => array(
					array('DEFAULT', 0),
					array('NULL', 1),
					array('ARRAY', 2),
					array('EMPTY', 3),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'multiple' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.multiple',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eimportexport_domain_model_field',
				'minitems' => 1,
				'maxitems' => 999,
				'appearance' => array(
					'collapseAll' => 1,
					'useSortable' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		'relation' => array(
			'exclude' => 1,
			'label' => $ll.'tx_eimportexport_domain_model_field.relation',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_eimportexport_domain_model_table',
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 1,
					'useSortable' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		
	),
);
