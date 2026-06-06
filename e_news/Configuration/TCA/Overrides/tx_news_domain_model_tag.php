<?php
/**
 * Add extra fields to tx_news_domain_model_tag record
 */

// Define language label prefix
$ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';

$tmp_tag_columns = array(
	'media' => [
        'exclude' => 1,
        'behaviour' => [
			   'allowLanguageSynchronization' => true
			],
        'label' => 'Media',
        'config' => [
            'type' => 'file',
            'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ',flv,mp4',
            'appearance' => [
                'createNewRelationLinkTitle' => $ll . 'tx_news_domain_model_news.fal_media.add',
                'showPossibleLocalizationRecords' => 1,
                'showRemovedLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1,
                'showSynchronizationLink' => 1
            ],
            'overrideChildTca' => [
                'types' => [
                    '0' => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                        'showitem' => '
					--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
					--palette--;;imageoverlayPalette,
					--palette--;;filePalette'
                    ]
                ]
            ]
        ]
    ],
	'sys_language_uid' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'special' => 'languages',
			'items' => [
				[
					'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
					-1,
					'flags-multiple'
				],
			],
			'default' => 0,
		]
	],
	'l10n_parent' => [
		'displayCond' => 'FIELD:sys_language_uid:>:0',
		'exclude' => 1,
		'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['', 0],
			],
			'foreign_table' => 'tx_news_domain_model_news',
			'foreign_table_where' => 'AND tx_news_domain_model_news.pid=###CURRENT_PID### AND tx_news_domain_model_news.sys_language_uid IN (-1,0)',
			'showIconTable' => false
		]
	],
	'l10n_diffsource' => [
		'config' => [
			'type' => 'passthrough',
			'default' => ''
		]
	]
);

$GLOBALS['TCA']['tx_news_domain_model_tag']['ctrl'] = [
	'title' => $ll . 'tx_news_domain_model_tag',
	'label' => 'title',
	'tstamp' => 'tstamp',
	'crdate' => 'crdate',
	'cruser_id' => 'cruser_id',
	'default_sortby' => 'ORDER BY title',
	'delete' => 'deleted',
	'enablecolumns' => [
		'disabled' => 'hidden',
	],
	'typeicon_classes' => [
		'default' => 'ext-news-tag'
	],
	'languageField' => 'sys_language_uid',
	'transOrigPointerField' => 'l10n_parent',
	'transOrigDiffSourceField' => 'l10n_diffsource',
	'searchFields' => 'uid,title',
];

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_tag',$tmp_tag_columns);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_tag',
    'media',
	'',
	'after:title'
);

