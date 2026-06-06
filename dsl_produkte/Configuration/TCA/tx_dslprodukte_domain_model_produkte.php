<?php
return [
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte',
        'label' => 'titel',
        'label_alt' => 'artikelnummer',
        'label_alt_force' =>',',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
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
        'searchFields' => 'alias,artikelnummer,titel,preis,teaser,text,technischedaten,keywords,bilder,anlage,anwendungsbereiche,eigenschaften,zubehoer,kategorien,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Configuration/TCA/tx_dslprodukte_domain_model_produkte.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Resources/Public/Icons/tx_dslprodukte_domain_model_produkte.gif'

    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, alias, titel, preis, teaser, text, technischedaten, keywords, bilder, anlage, kategorien, anwendungsbereiche, eigenschaften, zubehoer',
	),
	//beschreibung;;;richtext:rte_transform[mode=ts_links],
	'types' => array(
		'1' => array(
			'showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, alias, titel, preis, teaser, text, technischedaten, keywords, bilder, anlage, kategorien, anwendungsbereiche, eigenschaften, zubehoer, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime',
			'columnsOverrides' => [
			  'text' => [
				'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
			  ]
			]
		),
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
				'foreign_table' => 'tx_dslprodukte_domain_model_produkte',
				'foreign_table_where' => 'AND tx_dslprodukte_domain_model_produkte.pid=###CURRENT_PID### AND tx_dslprodukte_domain_model_produkte.sys_language_uid IN (-1,0)',
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
		
		
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
//			'l10n_mode' => 'mergeIfNotBlank',
			'l10n_mode' => 'exclude',
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
//			'l10n_mode' => 'mergeIfNotBlank',
			'l10n_mode' => 'exclude',
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
		'alias' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.alias',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),/*
		'artikelnummer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.artikelnummer',
			'l10n_mode' => 'exclude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),*/
		'titel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.titel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'preis' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.preis',
			'l10n_mode' => 'exclude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'teaser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		
		'text' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.text',
			'config' => array(
				
				
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
				
			),
		),
		'technischedaten' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.technischedaten',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'keywords' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.keywords',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bilder' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.bilder',
			'l10n_mode' => 'exclude',
			/*'l10n_mode' => 'mergeIfNotBlank',*/
			/*'l10n_mode' => '',
			'l10n_display' => 'hideDiff,defaultAsReadonly',*/
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'bilder',
				array('maxitems' => 5),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'kategorien' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.kategorien',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslprodukte_domain_model_kategorien',
			    'MM' => 'tx_dslprodukte_produkte_kategorien_mm',
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
			                'table' => 'tx_dslprodukte_domain_model_kategorien',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
		'anlage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.anlage',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'anlage',
				array('maxitems' => 1),
				'pdf,doc,xls,docx,xlsx'
			),
		),
		'anwendungsbereiche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.anwendungsbereiche',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslprodukte_domain_model_anwendungsbereiche',
			    'MM' => 'tx_dslprodukte_produkte_anwendungsbereiche_mm',
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
			                'table' => 'tx_dslprodukte_domain_model_anwendungsbereiche',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
		'eigenschaften' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.eigenschaften',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslprodukte_domain_model_eigenschaften',
			    'MM' => 'tx_dslprodukte_produkte_eigenschaften_mm',
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
			                'table' => 'tx_dslprodukte_domain_model_eigenschaften',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
		/*
		'eigenschaften' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.eigenschaften',
/*			'l10n_mode' => 'exclude',*/
/*'l10n_mode' => 'exclude',
		
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dslprodukte_domain_model_eigenschaften',
				'foreign_table_where' => ' AND sys_language_uid=0 ORDER BY UCASE(tx_dslprodukte_domain_model_eigenschaften.titel)',
				/* AND sys_language_uid=0*/
/*				'MM' => 'tx_dslprodukte_produkte_eigenschaften_mm',
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
						/*'script' => 'wizard_edit.php',*/
/*						'module' => array('name' => 'wizard_edit'),
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_dslprodukte_domain_model_eigenschaften',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),*/
		'zubehoer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_produkte.zubehoer',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslprodukte_domain_model_zubehoer',
			    'MM' => 'tx_dslprodukte_produkte_zubehoer_mm',
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
			                'table' => 'tx_dslprodukte_domain_model_zubehoer',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
		
	),
];
//http://typo3-blog.net/tutorials/news/eval-funktion-tca-array.html
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['alias']['config']['eval'] = implode(",",array_unique(array_merge(array_values(explode(",",$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['alias']['config']['eval'])), array_values(array('lower','alphanum_x','nospace','unique')))));
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['artikelnummer']['config']['eval'] = implode(",",array_unique(array_merge(array_values(explode(",",$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['artikelnummer']['config']['eval'])), array_values(array('unique')))));
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['anwendungsbereiche']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['eigenschaften']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['kategorien']['config']['minitems'] = 1;
//'eval' => 'trim	
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['tstamp'] = Array (
            'exclude' => 1,
            'label' => 'Modification date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
 
            ));
			
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['crdate'] = Array (
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
 
            ));
			
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['columns']['starttime']['config']['range']['lower'] = mktime(0, 0, 0, 1, 1, 2015);			
unset($GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['ctrl']['sortby']);
$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['ctrl']['default_sortby'] = ' ORDER BY starttime DESC';

$GLOBALS['TCA']['tx_dslprodukte_domain_model_produkte']['ctrl']['iconfile'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Resources/Public/Icons/tx_dslprodukte_domain_model_produkte.gif';
	