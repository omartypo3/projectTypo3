<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden',
		'label' => 'alias',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'alias,name,beschreibung,logo,ort,betreuung,unternehmen_groesse,link_webseite,link_facebook,primaer_farbe,seo_title,seo_keywords,seo_description,branche,',
		'iconfile' => 'EXT:bb_portfolio/Resources/Public/Icons/tx_bbportfolio_domain_model_kunden.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, alias, name, beschreibung, logo, ort, betreuung, unternehmen_groesse, link_webseite, link_facebook, primaer_farbe, seo_title, seo_keywords, seo_description, branche',
	),
	'types' => array(
		'1' => array(
			'showitem' => 'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,alias,name,beschreibung,logo,ort,betreuung,unternehmen_groesse,link_webseite,link_facebook,primaer_farbe,branche,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime'
		),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_bbportfolio_domain_model_kunden',
				'foreign_table_where' => 'AND tx_bbportfolio_domain_model_kunden.pid=###CURRENT_PID### AND tx_bbportfolio_domain_model_kunden.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'renderType' => 'inputDateTime',
				['behaviour' => ['allowLanguageSynchronization' => true]],
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'renderType' => 'inputDateTime',
				['behaviour' => ['allowLanguageSynchronization' => true]],
			),
		),

		'alias' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.alias',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'beschreibung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.beschreibung',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'logo' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.logo',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'logo',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					),
					'maxitems' => 1,
					'overrideChildTca' => ['types' => array(
						'0' => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
							'showitem' => '
							--palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						)
					)]
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'ort' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.ort',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'betreuung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.betreuung',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'unternehmen_groesse' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.unternehmen_groesse',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'link_webseite' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.link_webseite',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'link_facebook' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.link_facebook',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'primaer_farbe' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.primaer_farbe',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'seo_title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.seo_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'seo_keywords' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.seo_keywords',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'seo_description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.seo_description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'branche' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.branche',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_bbportfolio_domain_model_branchen',
				'MM' => 'tx_bbportfolio_kunden_branchen_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => ['editPopup' => ['disabled' => false, 'options' => ['title' => 'Edit']], 'addRecord' => ['disabled' => false, 'options' => ['title' => 'Create new', 'table' => 'tx_bbportfolio_domain_model_branchen', 'pid' => '###CURRENT_PID###', 'setValue' => 'prepend']]],
			),
		),

	),
);## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder