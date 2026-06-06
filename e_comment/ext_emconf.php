<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Comment System',
    'description' => 'A comment interface',
    'category' => '',
    'author' => 'Le Sommer Léo-Robin',
    'author_email' => 'llesommer@e-magineurs.com',
    'author_company' => 'E-magineurs',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '1.0.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-8.4.0',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Emagineurs\\EComment\\' => 'Classes'
        )
    )
);