<?php
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Base Extension for site.de Website',
	'description' => 'This extension offers templates & basic content elements for the site.de Website',
	'category' => 'distribution',
	'author' => 'site',
	'author_email' => 'example@example.com',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '0.1',
	'constraints' => array(
		'depends' => array(
		    'typo3' => '8.7.0-9.9.99',
            'fluid_styled_content' => '8.7.0-9.5.99',
		),
		'conflicts' => array(
			'css_styled_content' => '',
		),
		'suggests' => array(
		),
	),
    'autoload' => array(
        'psr-4' => array("sitetheme\\site\\" => "Classes/")
    ),
);
