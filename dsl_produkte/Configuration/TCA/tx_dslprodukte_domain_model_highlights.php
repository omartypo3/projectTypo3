<?php
return [
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_highlights',
        'label' => 'titel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
        ),
        'searchFields' => 'titel,produkte,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Configuration/TCA/tx_dslprodukte_domain_model_highlights.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Resources/Public/Icons/tx_dslprodukte_domain_model_highlights.gif'
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, titel, produkte',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, titel, produkte, '),
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
				'foreign_table' => 'tx_dslprodukte_domain_model_highlights',
				'foreign_table_where' => 'AND tx_dslprodukte_domain_model_highlights.pid=###CURRENT_PID### AND tx_dslprodukte_domain_model_highlights.sys_language_uid IN (-1,0)',
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
		
		
		'titel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_highlights.titel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		
		
		'produkte' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.produkte',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslprodukte_domain_model_produkte',
				'foreign_table_where' => ' AND tx_dslprodukte_domain_model_produkte.sys_language_uid=0 ORDER BY tx_dslprodukte_domain_model_produkte.titel ASC',
			    'MM' => 'tx_dslprodukte_highlights_produkte_mm',
			    'size' => 10,
			    'autoSizeMax' => 30,
			    'maxitems' => 9999,
			    'multiple' => 0,
			    'wizards' => [
			        '_PADDING' => 1,
			        '_VERTICAL' => 1,
			        'edit' => [
			            'module' => [
			                'name' => 'wizard_edit',
			            ],
			            'type' => 'popup',
			            'title' => 'Edit', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.edit
			            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
			            'popup_onlyOpenIfSelected' => 1,
			            'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
			        ],
			        'add' => [
			            'module' => [
			                'name' => 'wizard_add',
			            ],
			            'type' => 'script',
			            'title' => 'Create new', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.add
			            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
			            'params' => [
			                'table' => 'tx_dslprodukte_domain_model_produkte',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
		/*
		'produkte' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_highlights.produkte',
			'l10n_mode' => 'exclude',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dslprodukte_domain_model_produkte',
				'foreign_table_where' => ' AND tx_dslprodukte_domain_model_produkte.sys_language_uid=0 ORDER BY UCASE(tx_dslprodukte_domain_model_produkte.titel) ASC',
				'MM' => 'tx_dslprodukte_highlights_produkte_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						
						'module' => array('name' => 'wizard_edit'),
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_dslprodukte_domain_model_highlights',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),*/
		
	),
];
