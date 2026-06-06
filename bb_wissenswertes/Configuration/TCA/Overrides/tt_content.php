<?php
defined('TYPO3') or die();

// 1. Force-enable colPos=10 for all content types
$GLOBALS['TCA']['tt_content']['columns']['colPos']['config']['items'][] = [
    'label' => 'SLIDER (bb_wissenswertes)',
    'value' => 10,
    'icon' => 'content-special-html'
];

// 2. Ensure gridelements respects colPos=10
$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['columnsOverrides']['colPos'] = [
    'config' => [
        'items' => [
            ['SLIDER Area', 10, 'content-special-html']
        ]
    ]
];

// 3. Remove any backend restrictions
$GLOBALS['TCA']['tt_content']['ctrl']['security']['ignorePageTypeRestriction'] = true;

call_user_func(
    function ($extKey) {

	$frontendLanguageFilePrefix = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
	$languageFilePrefix = 'LLL:EXT:t3sbootstrap/Resources/Private/Language/locallang_be.xlf:';
	$dbFilePrefix = 'LLL:EXT:t3sbootstrap/Resources/Private/Language/locallang_db.xlf:';

	/***************
	 * Add new CTypes
	 */
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tt_content',
		'CType',
		[
			'BS Panel',
			't3sbs_panel',
			'bs-panel'
		],
		'textmedia',
		'after'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tt_content',
		'CType',
		[
			'BS Thumbnails (in thumbnail container)',
			't3sbs_thumbnails',
			'bs-thumbnail-element'
		],
		't3sbs_panel',
		'after'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tt_content',
		'CType',
		[
			'BS Carousel (in carousel container)',
			't3sbs_carousel',
			'bs-carousel-element'
		],
		't3sbs_thumbnails',
		'after'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tt_content',
		'CType',
		[
			'Fluidtemplate',
			't3sbs_fluidtemplate',
			'bs-fluidtemplate'
		],
		't3sbs_carousel',
		'after'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tt_content',
		'CType',
		[
			'Bootstrap Image Gallery',
			't3sbs_gallery',
			'bs-gallery'
		],
		't3sbs_fluidtemplate',
		'after'
	);

	/***************
	 * New fields in table:tt_content
	*/
	$tempContentColumns = [
		'tx_t3sbootstrap_header_position' => array(
			'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position',
			'exclude' => 1,
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array(
						'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value',
						''
					),
					array(
						'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.1',
						'center'
					),
					array(
						'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.2',
						'right'
					),
					array(
						'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.3',
						'left'
					)
				),
				'default' => ''
			)
		),
		'tx_t3sbootstrap_imagestyle' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sbootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_t3sbootstrap_image_style',
			'config' => [
				'type' => 'select',
				'items' => [
					['Default', '0'],
					['Rounded', 'img-rounded'],
					['Circle', 'img-circle'],
					['Thumbnail', 'img-thumbnail'],
				],
				'renderType' => 'selectSingle'
			]
		],
		'tx_t3sbootstrap_content_slide' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:t3sbootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_t3sbootstrap_content_slide',
			'config' => [
				'type' => 'select',
				'items' => [
					['None', 0],
					['Top', 1],
					['Bottom', 2],
				],
				'renderType' => 'selectSingle'
			]
		],
		'tx_t3sbootstrap_fontawesome_icon' => [
			'exclude' => 1,
			'label'   => 'LLL:EXT:t3sbootstrap/Resources/Private/Language/locallang_db.xlf:pages.tx_t3sbootstrap_fontawesome_icon',
			'config' => [
				'type' => 'input',
				'size' => '20',
			]
		],
		'tx_t3sbootstrap_flexform' => [
			'exclude' => 1,
			'l10n_display' => 'hideDiff',
			'label' => 'EXT:t3sbootstrap SETTINGS',
			'config' => [
				'type' => 'flex',
				'ds_pointerField' => 'tx_gridelements_backend_layout,CType',
				'ds' => [
					'default' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Bootstrap_7.xml',
					'*,t3sbs_panel' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Panel.xml',
					'*,table' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Table.xml',
					'tabs_tab,gridelements_pi1' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Nada.xml',
				]
			]
		],
		'tx_t3sbootstrap_animateCss' => [
			'exclude' => 1,
			'l10n_display' => 'hideDiff',
			'label' => 'Animate.css:',
			'config' => [
				'type' => 'select',
				'items' => [
					['None', '0'],
					['bounce', 'bounce'],
					['flash', 'flash'],
					['pulse', 'pulse'],
					['rubberBand', 'rubberBand'],
					['shake', 'shake'],
					['headShake', 'headShake'],
					['swing', 'swing'],
					['tada', 'tada'],
					['wobble', 'wobble'],
					['jello', 'jello'],
					['bounceIn', 'bounceIn'],
					['bounceInDown', 'bounceInDown'],
					['bounceInLeft', 'bounceInLeft'],
					['bounceInRight', 'bounceInRight'],
					['bounceInUp', 'bounceInUp'],
					['bounceOut', 'bounceOut'],
					['bounceOutDown', 'bounceOutDown'],
					['bounceOutLeft', 'bounceOutLeft'],
					['bounceOutRight', 'bounceOutRight'],
					['bounceOutUp', 'bounceOutUp'],
					['fadeIn', 'fadeIn'],
					['fadeInDown', 'fadeInDown'],
					['fadeInDownBig', 'fadeInDownBig'],
					['fadeInLeft', 'fadeInLeft'],
					['fadeInLeftBig', 'fadeInLeftBig'],
					['fadeInRight', 'fadeInRight'],
					['fadeInRightBig', 'fadeInRightBig'],
					['fadeInUp', 'fadeInUp'],
					['fadeInUpBig', 'fadeInUpBig'],
					['fadeOut', 'fadeOut'],
					['fadeOutDown', 'fadeOutDown'],
					['fadeOutDownBig', 'fadeOutDownBig'],
					['fadeOutLeft', 'fadeOutLeft'],
					['fadeOutLeftBig', 'fadeOutLeftBig'],
					['fadeOutRight', 'fadeOutRight'],
					['fadeOutRightBig', 'fadeOutRightBig'],
					['fadeOutUp', 'fadeOutUp'],
					['fadeOutUpBig', 'fadeOutUpBig'],
					['flipInX', 'flipInX'],
					['flipInY', 'flipInY'],
					['flipOutX', 'flipOutX'],
					['flipOutY', 'flipOutY'],
					['lightSpeedIn', 'lightSpeedIn'],
					['lightSpeedOut', 'lightSpeedOut'],
					['rotateIn', 'rotateIn'],
					['rotateInDownLeft', 'rotateInDownLeft'],
					['rotateInDownRight', 'rotateInDownRight'],
					['rotateInUpLeft', 'rotateInUpLeft'],
					['rotateInUpRight', 'rotateInUpRight'],
					['rotateOut', 'rotateOut'],
					['rotateOutDownLeft', 'rotateOutDownLeft'],
					['rotateOutDownRight', 'rotateOutDownRight'],
					['rotateOutUpLeft', 'rotateOutUpLeft'],
					['rotateOutUpRight', 'rotateOutUpRight'],
					['hinge', 'hinge'],
					['rollIn', 'rollIn'],
					['rollOut', 'rollOut'],
					['zoomIn', 'zoomIn'],
					['zoomInDown', 'zoomInDown'],
					['zoomInLeft', 'zoomInLeft'],
					['zoomInRight', 'zoomInRight'],
					['zoomInUp', 'zoomInUp'],
					['zoomOut', 'zoomOut'],
					['zoomOutDown', 'zoomOutDown'],
					['zoomOutLeft', 'zoomOutLeft'],
					['zoomOutRight', 'zoomOutRight'],
					['zoomOutUp', 'zoomOutUp'],
					['slideInDown', 'slideInDown'],
					['slideInLeft', 'slideInLeft'],
					['slideInRight', 'slideInRight'],
					['slideInUp', 'slideInUp'],
					['slideOutDown', 'slideOutDown'],
					['slideOutLeft', 'slideOutLeft'],
					['slideOutRight', 'slideOutRight'],
					['slideOutUp', 'slideOutUp'],
				],
				'renderType' => 'selectSingle'
			]
		],
		'tx_t3sbootstrap_animateCssRepeat' => [
			'exclude' => 1,
			'label' => 'Repeat (jQuery-viewport-checker option):',
			'config' => [
				'type' => 'check'
			]
		],
		'tx_t3sbootstrap_animateCssDuration' => [
			'exclude' => 1,
			'label'   => 'Duration in seconds:',
			'config' => [
				'type' => 'input',
				'eval' => 'int',
				'size' => '3',
			]
		],
	];


	if ((int)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getBranch() > 7) {
		unset($tempContentColumns['tx_t3sbootstrap_header_position']);
		unset($tempContentColumns['tx_t3sbootstrap_flexform']);

		$tempContentColumns['tx_t3sbootstrap_flexform'] = [
			'exclude' => 1,
			'l10n_display' => 'hideDiff',
			'label' => 'EXT:t3sbootstrap SETTINGS',
			'config' => [
				'type' => 'flex',
				'ds_pointerField' => 'tx_gridelements_backend_layout,CType',
				'ds' => [
					'default' => 'FILE:fileadmin/template_web/Configuration/FlexForms/Bootstrap.xml',
					'*,t3sbs_panel' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Panel.xml',
					'tabs_tab,gridelements_pi1' => 'FILE:EXT:t3sbootstrap/Configuration/FlexForms/Nada.xml',
				]
			]
		];
	}

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tempContentColumns);
	unset($tempContentColumns);


	/***************
	 * Header Layout sorting
	 */
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items'] = [
		[$frontendLanguageFilePrefix . 'LGL.default_value', '0'],
		[$languageFilePrefix .'tt_content.header_layout.ph1', '1'],
		[$languageFilePrefix .'tt_content.header_layout.ph2', '6'],
		[$languageFilePrefix .'tt_content.header_layout.2', '2'],
		[$languageFilePrefix .'tt_content.header_layout.3', '3'],
		[$languageFilePrefix .'tt_content.header_layout.4', '4'],
		[$languageFilePrefix .'tt_content.header_layout.5', '5'],
		[$languageFilePrefix .'tt_content.header_layout.6', '7'],
		[$frontendLanguageFilePrefix . 'header_layout.I.6', '100']
	];


	/***************
	 * Bullets
	 */
	// add extra column
	$GLOBALS['TCA']['tt_content']['columns']['bullets_type']['config']['items'][2] = ['BS Inline list', 2];
	$GLOBALS['TCA']['tt_content']['columns']['bullets_type']['config']['items'][3] = ['BS Unstyled list',3];
	$GLOBALS['TCA']['tt_content']['columns']['bullets_type']['config']['items'][4] = ['BS Listengruppen',4];
	$GLOBALS['TCA']['tt_content']['columns']['bullets_type']['config']['items'][5] = ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bullets_type.2',5];
	$GLOBALS['TCA']['tt_content']['columns']['bullets_type']['config']['items'][6] = ['BS Definition list (horizontal)',6];


	/***************
	 * Gridelements
	 */
	if (!isset($GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem'])) {
    	$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem'] = '';
	}
	$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem'] = str_replace('pi_flexform,', '', $GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem']);
	$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['showitem'] .= ',--div--;Settings,assets, pi_flexform';
	$GLOBALS['TCA']['tt_content']['types']['gridelements_pi1']['columnsOverrides'] = [
		'assets' => [
			'config' => [
				'maxitems' => 1
			]
		]
	];


	/***************
	 * Panels
	 */
	$GLOBALS['TCA']['tt_content']['types']['t3sbs_panel'] = [
		'showitem' => '
				--palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.header;header, rowDescription,
				bodytext;' . $frontendLanguageFilePrefix . 'bodytext_formlabel,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.appearance,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.appearanceLinks;appearanceLinks,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.access,
				hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.access;access,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.extended
		'
	];

	if ((int)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getBranch() < 8) {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_panel']['columnsOverrides']['bodytext'] = ['defaultExtras' => 'richtext:rte_transform[mode=ts_css]'];
	} else {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_panel']['columnsOverrides']['bodytext']['config']['enableRichtext'] = true;
	}


	/***************
	 * Thumbnails
	 */
	$GLOBALS['TCA']['tt_content']['types']['t3sbs_thumbnails'] = [
		'showitem' => '
				--palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.header;header,rowDescription,
				bodytext;' . $frontendLanguageFilePrefix . 'bodytext_formlabel,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.media,assets,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.imagelinks;imagelinks,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.appearance,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.appearanceLinks;appearanceLinks,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.access,
				hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.access;access
		',
		'columnsOverrides' => [
			'assets' => [
				'config' => [
					'maxitems' => 1
				]
			]
		]
	];

	if ((int)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getBranch() < 8) {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_thumbnails']['columnsOverrides']['bodytext'] = ['defaultExtras' => 'richtext:rte_transform[mode=ts_css]'];
	} else {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_thumbnails']['columnsOverrides']['bodytext']['config']['enableRichtext'] = true;
	}


	/***************
	 * BS Carousel
	 */
	$GLOBALS['TCA']['tt_content']['types']['t3sbs_carousel'] = [
		'showitem' => '
				--palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.header;header,rowDescription,
				bodytext;' . $frontendLanguageFilePrefix . 'bodytext_formlabel,
				--div--;' . $frontendLanguageFilePrefix . 'tabs.media,assets,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.appearance,
				layout;' . $frontendLanguageFilePrefix . 'layout_formlabel,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.appearanceLinks;appearanceLinks,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.access,
				hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.access;access
		',
		'columnsOverrides' => [
			'assets' => [
				'config' => [
					'maxitems' => 1
				]
			]
		]
	];

	if ((int)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getBranch() < 8) {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_carousel']['columnsOverrides']['bodytext'] = ['defaultExtras' => 'richtext:rte_transform[mode=ts_css]'];
	} else {
		$GLOBALS['TCA']['tt_content']['types']['t3sbs_carousel']['columnsOverrides']['bodytext']['config']['enableRichtext'] = true;
	}


	/***************
	 * FluidTemplate
	 */
	$GLOBALS['TCA']['tt_content']['types']['t3sbs_fluidtemplate']['showitem'] = '
			--palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
		header;LLL:EXT:' . 't3sbootstrap' . '/Resources/Private/Language/locallang_be.xlf:t3sbs_nonvisible_header,
		subheader;FluidTemplate,
			--palette--;' . $frontendLanguageFilePrefix . 'palette.appearanceLinks;appearanceLinks,
		--div--;' . $frontendLanguageFilePrefix . 'tabs.access,
			hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
			--palette--;' . $frontendLanguageFilePrefix . 'palette.access;access
	';


	/***************
	 * BS Image Gallery
	 */
	$GLOBALS['TCA']['tt_content']['types']['t3sbs_gallery'] = [
	    'showitem' => '
				--palette--;' . $frontendLanguageFilePrefix . 'palette.general;general,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.header;header,rowDescription,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.media,assets,
				LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.ALT.uploads_formlabel,
				--linebreak--, file_collections;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:file_collections.ALT.uploads_formlabel,
				--linebreak--, filelink_sorting,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.appearance,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
				--palette--;;mediaAdjustments,imagecols,
				 --palette--;' . $frontendLanguageFilePrefix . 'palette.appearanceLinks;appearanceLinks,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.access,
				hidden;' . $frontendLanguageFilePrefix . 'field.default.hidden,
				--palette--;' . $frontendLanguageFilePrefix . 'palette.access;access,
			--div--;' . $frontendLanguageFilePrefix . 'tabs.extended
		'
	];


	/***************
	 * DIV
	 */
	foreach ( $GLOBALS['TCA']['tt_content']['types'] as $key=>$type ) {
	    if (!is_numeric($key)) {
			if ( substr($key, 0, 5) == 't3sbs' ) {
				// Add category tab when categories column exits
				if (!empty($GLOBALS['TCA']['tt_content']['columns']['categories'])) {
					$GLOBALS['TCA']['tt_content']['types'][$key]['showitem'] .=
					',--div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,
					categories';
				}
				// Add gridelements_columns
				$GLOBALS['TCA']['tt_content']['types'][$key]['showitem'] .= ',--div--;' . $frontendLanguageFilePrefix . 'tabs.extended,tx_gridelements_container,tx_gridelements_columns';
			}
			// Add flexform from t3sbootstrap to all cTypes
			$GLOBALS['TCA']['tt_content']['types'][$key]['showitem'] .= ',--div--;T3SB,tx_t3sbootstrap_flexform';
	    }
	}


if ((int)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getBranch() < 8) {
	# add header_position to palette header
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'header',
		'tx_t3sbootstrap_header_position',
		'after:header_layout'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'headers',
		'tx_t3sbootstrap_header_position',
		'after:header_layout'
	);

	# add subheader to palette header
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'header',
		'--linebreak--,subheader',
		'after:header'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'headers',
		'--linebreak--,subheader',
		'after:header'
	);
}


	# add tx_t3sbootstrap_imagestyle
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'imagelinks',
		'--linebreak--,tx_t3sbootstrap_imagestyle',
		'after:imagelinks'
	);


	# Extension configuration
	$_extconf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get($extKey);

	if ($_extconf['contentSlide']) {
		# add tx_t3sbootstrap_content_slide
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
			'tt_content',
			'tx_t3sbootstrap_content_slide',
			'',
			'after:layout'
		);
	}

	if ($_extconf['animateCss']) {
		# add animate.css
		$GLOBALS['TCA']['tt_content']['palettes']['animate'] = [
		  'showitem' => 'tx_t3sbootstrap_animateCss,
		         tx_t3sbootstrap_animateCssDuration,
		         tx_t3sbootstrap_animateCssRepeat',
				 'canNotCollapse' => 1
		];
		# add palette animate
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
			'tt_content',
			'--palette--;Animation;animate',
			'',
			'after:layout'
		);
	}

	if ($_extconf['fontawesome']) {
		# add tx_t3sbootstrap_fontawesome_icon
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
			'tt_content',
			'header',
			'--linebreak--,tx_t3sbootstrap_fontawesome_icon',
			'after:subheader'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
			'tt_content',
			'headers',
			'--linebreak--,tx_t3sbootstrap_fontawesome_icon',
			'after:subheader'
		);
	}


}, 't3sbootstrap'
);