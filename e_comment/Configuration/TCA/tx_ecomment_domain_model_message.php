<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message',
		'label' => 'bodytext',
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
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'bodytext,title,feuser,name,firstname,email,children,parent',
		'iconfile' => 'EXT:e_comment/Resources/Public/Icons/tx_ecomment_domain_model_message.png'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,bodytext,title,feuser,name,firstname,email,file,children,parent,categories,validationtoken,paramfilter,paramvalue',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1,l10n_parent,l10n_diffsource,hidden;;1,bodytext,title,feuser,name,firstname,email,file,children,parent,categories,validationtoken,paramfilter,paramvalue,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime'),
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
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_ecomment_domain_model_message',
				'foreign_table_where' => 'AND tx_ecomment_domain_model_message.pid=###CURRENT_PID### AND tx_ecomment_domain_model_message.sys_language_uid IN (-1,0)',
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
		'starttime' => [
    'exclude' => true,
    'l10n_mode' => 'mergeIfNotBlank',
    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
    'config' => [
        'type' => 'datetime',
        'default' => 0,
        'eval' => 'datetime',
        'range' => [
            'lower' => 0,
        ],
    ],
],

'endtime' => [
    'exclude' => true,
    'l10n_mode' => 'mergeIfNotBlank',
    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
    'config' => [
        'type' => 'datetime',
        'default' => 0,
        'eval' => 'datetime',
        'range' => [
            'lower' => 0,
        ],
    ],
],
        'crdate' => array(
            'label' => 'crdate',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        'tstamp' => array(
            'label' => 'tstamp',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
		'bodytext' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.bodytext',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 6,
				'enableRichtext' => true
			),
		),
        'title' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.title',
            'config' => array(
                'type' => 'input',
                'size' => '255',
                'eval' => 'trim'
            )
        ),
        'name' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.name',
            'config' => array(
                'type' => 'input',
                'size' => '255',
                'eval' => 'trim'
            )
        ),
        'firstname' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.firstname',
            'config' => array(
                'type' => 'input',
                'size' => '255',
                'eval' => 'trim'
            )
        ),
        'email' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.email',
            'config' => array(
                'type' => 'input',
                'size' => '255',
                'eval' => 'trim'
            )
        ),

		'multiple_files' => [
            'exclude' => true,
            'label' => 'Multiple files',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
            ],
        ],

		
        'file' => array(
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.file',
            'config' => array(
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'],
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:media.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true
                ),
                'foreign_match_fields' => array(
                    'fieldname' => 'file',
                    'tablenames' => 'tx_ecomment_domain_model_message',
                    'table_local' => 'sys_file',
                ),
                'overrideChildTca' => array(
                    'types' => array(
                        '0' => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                        )
                    )
                )
            )
        ),
		'feuser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.feuser',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'fe_users'
			),
		),
		'children' => array(
            'exclude' => 1,
			'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.children',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_ecomment_domain_model_message',
				'foreign_field' => 'parent',
			),
		),
		'parent' => array(
			'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.parent',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_ecomment_domain_model_message'
			),
		),
        'categories' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.categories',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => array(
                    'parentField' => 'parent',
                    'appearance' => array(
                        'showHeader' => TRUE,
                        'expandAll' => TRUE,
                        'maxLevels' => 99,
                    ),
                ),
                'MM' => 'sys_category_record_mm',
                'MM_match_fields' => array(
                    'fieldname' => 'categories',
                    'tablenames' => 'tx_ecomment_domain_model_message',
                ),
                'MM_opposite_field' => 'items',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'minitems' => 0,
                'maxitems' => 99,
                'size' => 10,
                'appearance' => array(
                    'showHeader' => TRUE,
                    'allowRecursiveMode' => TRUE,
                    'expandAll' => TRUE,
                    'maxLevels' => 99,
                ),
            ),
        ),
        'validationtoken' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.validationtoken',
            'config' => array(
                'type' => 'input',
                'size' => '50',
                'eval' => 'trim'
            )
        ),
        'paramfilter' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.paramfilter',
            'config' => array(
                'type' => 'input',
                'size' => '50',
                'eval' => 'trim'
            )
        ),
        'paramvalue' => array(
            'label' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:tx_ecomment_domain_model_message.paramvalue',
            'config' => array(
                'type' => 'input',
                'size' => '50',
                'eval' => 'trim'
            )
        ),
	),
);
