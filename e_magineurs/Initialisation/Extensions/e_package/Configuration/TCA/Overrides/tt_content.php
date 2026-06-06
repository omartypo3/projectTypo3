<?php
	defined('TYPO3_MODE') or die();

	// Ajout des cases à cocher
	$toggleContent = Array (
		"toggle_content" => Array (
			"exclude" => 1,
			"label" => "Contenu plié / déplié",
			"config" => Array (
	            'type' => 'check',
	            'default' => 0
			)
		),
		"toggle_position" => Array (
			"exclude" => 1,
			"label" => "Contenu déplié (plié par defaut)",
			"config" => Array (
	            'type' => 'check',
	            'default' => 0
			)
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$toggleContent);
	// Il faut ajouter les champs à la palette deux fois. Une fois pour header et une autre pour headerS (pour gridelements)
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'header',
		'toggle_content,toggle_position',
		'after:header_layout'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
		'tt_content',
		'headers',
		'toggle_content,toggle_position',
		'after:header_layout'
	);

	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['label'] = 'Taille du titre';
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['1'] = array('Titre 1','1');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['2'] = array('Titre 2','2');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['3'] = array('Titre 3','3');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['4'] = array('Titre 4','4');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['5'] = array('Titre 5','5');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['6'] = array('Titre 6','6');
	$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items']['7'] = array('Titre caché','100');

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu pied de page',
	        'menu_piedpage',
	        'e_magineurs_icon'
	    ],
	    'menu_sitemap_pages',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_piedpage'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
	    'tt_content',
	    'CType',
	    [
	        'Menu principal',
	        'menu_principal',
	        'e_magineurs_icon'
	    ],
	    'menu_sitemap_pages',
	    'after'
	);

	$GLOBALS['TCA']['tt_content']['types']['menu_principal'] = $GLOBALS['TCA']['tt_content']['types']['menu_pages'];