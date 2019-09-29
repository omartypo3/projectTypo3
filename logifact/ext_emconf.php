<?php
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Base Extension for logifact.de Website',
	'description' => 'This extension offers templates & basic content elements for the logifact.de Website',
	'category' => 'distribution',
	'author' => 'Logifact',
	'author_email' => 'example@example.com',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '0.1',
	'constraints' => array(
		'depends' => array(
		    'typo3' => '9.5.0-9.5.99',
            'fluid_styled_content' => '9.5.0-9.5.99',
            'rte_ckeditor' => '9.5.0-9.5.99',
            'gridelements' => '9.0.0 ',
			'news' => '7.0.0-7.0.99',
		),
		'conflicts' => array(
			'css_styled_content' => '',
		),
		'suggests' => array(
		),
	),
    'autoload' => array(
        'psr-4' => array("Logifacttheme\\Logifact\\" => "Classes/")
    ),
);
