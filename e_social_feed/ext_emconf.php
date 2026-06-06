<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "e_social_feed"
 *
 * 
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Remontées de flux de réseaux sociaux',
	'description' => 'Extension permettant la remontée d\'infos depuis les réseaux sociaux facebook, instagram et twitter',
	'category' => 'plugin',
	'author' => 'Xavier Ley',
	'author_email' => 'xley@e-magineurs.com',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.1',
	'constraints' => array(
		'depends' => array(
			'typo3' => '11.5.0-13.4.99',
			'php' => '8.1.0-8.4.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'autoload' => array(
		'psr-4' => array(
			'Emagineurs\\ESocialFeed\\' => 'Classes'
		)
	)
);