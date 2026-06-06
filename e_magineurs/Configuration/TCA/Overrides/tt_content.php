<?php
defined('TYPO3') or die();

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu Sites Plaine Commune',
	        'menu_Sites',
	        'menu_Sites_icon'
	    ],
	    'menu_Sites',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_Sites'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu Home',
	        'menu_Home',
	        'menu_Home_icon'
	    ],
	    'menu_Home',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_Home'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];



	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu mini icon',
	        'menu_miniicon',
	        'menu_miniicon_icon'
	    ],
	    'menu_miniicon_pages',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_miniicon'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];



	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu Mini Head',
	        'menu_miniHead',
	        'menu_miniHead_icon'
	    ],
	    'menu_sitemap_pages',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_miniHead'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];


	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu header Page',
	        'menu_headerPage',
	        'menu_headerPage_icon'
	    ],
	    'menu_headerPage',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_headerPage'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];


	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu Secondaire',
	        'menu_secondaire',
	        'menu_secondaire_icon'
	    ],
	    'menu_sitemap_pages',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_secondaire'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu plan Site',
	        'menu_plansite',
	        'menu_plansite_icon'
	    ],
	    'menu_plansite',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_plansite'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];
?>