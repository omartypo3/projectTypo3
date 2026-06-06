<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio',
		'label' => 'datum',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
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
		'searchFields' => 'datum,alias,titel,untertitel,beschreibung,link,zeitraum,system,teaser_bild,youtube,bilder,seo_keywords,seo_description,kundenname,kundennamecheck,kunde,kategorie,hashtags,related,',
		'iconfile' => 'EXT:bb_portfolio/Resources/Public/Icons/tx_bbportfolio_domain_model_portfolio.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, datum, alias, titel, untertitel, beschreibung, link, zeitraum, system, teaser_bild, youtube, bilder, seo_keywords, seo_description, kundenname, kundennamecheck, kunde, kategorie, hashtags, related',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,datum,alias,titel,untertitel,beschreibung,--palette--,link,zeitraum,system,teaser_bild,youtube,bilder,kundenname,kundennamecheck,kunde,kategorie,hashtags,related,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime'),
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
				'foreign_table' => 'tx_bbportfolio_domain_model_portfolio',
				'foreign_table_where' => 'AND tx_bbportfolio_domain_model_portfolio.pid=###CURRENT_PID### AND tx_bbportfolio_domain_model_portfolio.sys_language_uid IN (-1,0)',
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

		'datum' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.datum',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00',
				'renderType' => 'inputDateTime'
			),
		),
		'alias' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.alias',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'titel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.titel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'untertitel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.untertitel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'beschreibung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.beschreibung',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'enableRichtext' => true,
				'fieldControl' => ['fullScreenRichtext' => ['disabled' => false, 'options' => ['title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE']]]
			),
		),
		'link' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.link',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zeitraum' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.zeitraum',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'system' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.system',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'teaser_bild' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.teaser_bild',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'teaser_bild',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					),
					'maxitems' => 999,
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
		'youtube' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.youtube',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bilder' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.bilder',
			'config' => 
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'bilder',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					),
					'maxitems' => 999,
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
		'seo_keywords' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.seo_keywords',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'seo_description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.seo_description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'kundenname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.kundenname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'kundennamecheck' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.kundennamecheck',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'kunde' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.kunde',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_bbportfolio_domain_model_kunden',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'kategorie' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.kategorie',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_bbportfolio_domain_model_kategorien',
				'MM' => 'tx_bbportfolio_portfolio_kategorien_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => ['editPopup' => ['disabled' => false, 'options' => ['title' => 'Edit']], 'addRecord' => ['disabled' => false, 'options' => ['title' => 'Create new', 'table' => 'tx_bbportfolio_domain_model_kategorien', 'pid' => '###CURRENT_PID###', 'setValue' => 'prepend']]],
			),
		),
		'hashtags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.hashtags',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_bbportfolio_domain_model_hashtags',
				'MM' => 'tx_bbportfolio_portfolio_hashtags_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => ['editPopup' => ['disabled' => false, 'options' => ['title' => 'Edit']], 'addRecord' => ['disabled' => false, 'options' => ['title' => 'Create new', 'table' => 'tx_bbportfolio_domain_model_hashtags', 'pid' => '###CURRENT_PID###', 'setValue' => 'prepend']]],
			),
		),
		'related' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.related',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_bbportfolio_domain_model_portfolio',
				'MM' => 'tx_bbportfolio_portfolio_portfolio_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => ['editPopup' => ['disabled' => false, 'options' => ['title' => 'Edit']], 'addRecord' => ['disabled' => false, 'options' => ['title' => 'Create new', 'table' => 'tx_bbportfolio_domain_model_portfolio', 'pid' => '###CURRENT_PID###', 'setValue' => 'prepend']]],
			),
		),

	),
);## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder