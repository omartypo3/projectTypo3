<?php
return [
    'ctrl' => array(
        'title'	=> 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer',
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
        'searchFields' => 'alias,artikelnummer,titel,preis,teaser,text,technischedaten,keywords,bilder,anlage,produkte,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Configuration/TCA/tx_dslprodukte_domain_model_zubehoer.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dsl_produkte') . 'Resources/Public/Icons/tx_dslprodukte_domain_model_zubehoer.gif'
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, alias, artikelnummer, titel, preis, teaser, text, technischedaten, keywords, bilder, anlage, produkte',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, alias, artikelnummer, titel, preis, teaser, text;;;richtext:rte_transform[mode=ts_links], technischedaten, keywords, bilder, anlage, produkte, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_dslprodukte_domain_model_zubehoer',
				'foreign_table_where' => 'AND tx_dslprodukte_domain_model_zubehoer.pid=###CURRENT_PID### AND tx_dslprodukte_domain_model_zubehoer.sys_language_uid IN (-1,0)',
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
		'alias' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.alias',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'artikelnummer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.artikelnummer',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'titel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.titel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'preis' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.preis',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'teaser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'text' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.text',
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
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		),
		'technischedaten' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.technischedaten',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'keywords' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.keywords',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bilder' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.bilder',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'bilder',
				array('maxitems' => 5),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'anlage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.anlage',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'anlage',
				array('maxitems' => 1),
				'pdf,doc,xls,docx,xlsx'
			),
		),
		'produkte' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.produkte',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dslprodukte_domain_model_produkte',
				'MM' => 'tx_dslprodukte_produkte_zubehoer_mm',
				'MM_opposite_field' => 'zubehoer',
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
							'table' => 'tx_dslprodukte_domain_model_produkte',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		
	),
];

//http://typo3-blog.net/tutorials/news/eval-funktion-tca-array.html
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['alias']['config']['eval'] = implode(",",array_unique(array_merge(array_values(explode(",",$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['alias']['config']['eval'])), array_values(array('lower','alphanum_x','nospace','unique')))));
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['artikelnummer']['config']['eval'] = implode(",",array_unique(array_merge(array_values(explode(",",$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['artikelnummer']['config']['eval'])), array_values(array('unique')))));
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['tstamp'] = Array (
            'exclude' => 1,
            'label' => 'Modification date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
 
            ));
			
			
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['crdate'] = Array (
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
 
            ));
			
			
			/*
			ACHTUNG:
			
			'produkte' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dsl_produkte/Resources/Private/Language/locallang_db.xlf:tx_dslprodukte_domain_model_zubehoer.produkte',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dslprodukte_domain_model_produkte',
!!!ändern!!!				'MM' => 'tx_dslprodukte_produkte_zubehoer_mm',
!!!ergänzen!!				'MM_opposite_field' => 'zubehoer',
			*/
			
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['columns']['starttime']['config']['range']['lower'] = mktime(0, 0, 0, 1, 1, 2015);						
unset($GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['ctrl']['sortby']);
$GLOBALS['TCA']['tx_dslprodukte_domain_model_zubehoer']['ctrl']['default_sortby'] = ' ORDER BY starttime DESC';