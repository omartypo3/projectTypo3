<?php
	defined('TYPO3') or die();

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

	use TYPO3\CMS\Core\Utility\GeneralUtility;
use B13\Container\Tca\ContainerConfiguration;
use B13\Container\Tca\Registry;

/** @var Registry $registry */
$registry = GeneralUtility::makeInstance(Registry::class);

// 1 - Grid333333informationfooter (3 cols)
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_001',
        'Grid333333 information footer',
        '',
        [
            [
                ['name' => 'Colonne 1', 'colPos' => 80],
                ['name' => 'Colonne 2', 'colPos' => 81],
                ['name' => 'Colonne 3', 'colPos' => 82],
            ]
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Icons/grid333333informationfooter.svg')
);

// 2 - Grid5050informationfooter
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_002',
        'Grid5050-information-footer',
        '',
        [
            [
                ['name' => 'Colonne gauche', 'colPos' => 83],
                ['name' => 'Colonne droite', 'colPos' => 84],
            ]
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Icons/grid5050informationfooter.svg')
);

// 3 - Info_bulle (1 col)
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_003',
        'Info Bulle',
        '',
        [
            [
                ['name' => 'Contenu', 'colPos' => 85],
            ]
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Icons/info_bulle.svg')
);

// 4 - Grid25252525 (4 cols)
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_004',
        '4 Colonnes',
        '',
        [
            [
                ['name' => 'Colonne 1', 'colPos' => 86],
                ['name' => 'Colonne 2', 'colPos' => 87],
                ['name' => 'Colonne 3', 'colPos' => 88],
                ['name' => 'Colonne 4', 'colPos' => 89],
            ]
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Icons/grid25252525.svg')
);

// 101 - Deux colonnes 50%-50%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_101',
        'Deux colonnes 50%-50%',
        '',
        [
            [
                ['name' => 'Colonne gauche (50%)', 'colPos' => 10],
                ['name' => 'Colonne droite (50%)', 'colPos' => 11],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid5050.gif')
);

// 102 - Deux colonnes 25%-75%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_102',
        'Deux colonnes 25%-75%',
        '',
        [
            [
                ['name' => 'Colonne gauche (25%)', 'colPos' => 20],
                ['name' => 'Colonne droite (75%)', 'colPos' => 21],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid2575.gif')
);

// 103 - Deux colonnes 75%-25%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_103',
        'Deux colonnes 75%-25%',
        '',
        [
            [
                ['name' => 'Colonne gauche (75%)', 'colPos' => 30],
                ['name' => 'Colonne droite (25%)', 'colPos' => 31],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid7525.gif')
);

// 104 - Deux colonnes 33%-66%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_104',
        'Deux colonnes 33%-66%',
        '',
        [
            [
                ['name' => 'Colonne gauche (33%)', 'colPos' => 40],
                ['name' => 'Colonne droite (66%)', 'colPos' => 41],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid3366.gif')
);

// 105 - Deux colonnes 66%-33%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_105',
        'Deux colonnes 66%-33%',
        '',
        [
            [
                ['name' => 'Colonne gauche (66%)', 'colPos' => 50],
                ['name' => 'Colonne droite (33%)', 'colPos' => 51],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid6633.gif')
);

// 106 - Trois colonnes 33%-33%-33%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_106',
        'Trois colonnes 33%-33%-33%',
        '',
        [
            [
                ['name' => 'Colonne 1 (33%)', 'colPos' => 60],
                ['name' => 'Colonne 2 (33%)', 'colPos' => 61],
                ['name' => 'Colonne 3 (33%)', 'colPos' => 62],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid333333.gif')
);

// 107 - Une colonne 100%
$registry->configureContainer(
    (new ContainerConfiguration(
        'grid_107',
        'Une colonne 100%',
        '',
        [
            [
                ['name' => 'Colonne unique', 'colPos' => 70],
            ],
        ]
    ))->setIcon('EXT:e_package/Resources/Public/Images/grid100.gif')
);