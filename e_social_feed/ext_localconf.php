<?php
defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Emagineurs.' . $_EXTKEY,
	'Pi1',
	array(
		'Social' => 'handleFacebook, handleTwitter, handleInstagram, handleVimeo',		
	),
	// non-cacheable actions
	array(
		'Social' => 'handleFacebook, handleTwitter, handleInstagram, handleVimeo',		
	)
);

// Gestion du Wizicon
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:e_social_feed/Configuration/TSConfig/tsconfig.txt">'
);

$iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'esocialfeed-wizicon',
    TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:e_social_feed/Resources/Public/Icons/ce_wiz.png']
);
