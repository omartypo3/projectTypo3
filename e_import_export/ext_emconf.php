<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "e_export".
 *
 * Auto generated 08-09-2014 11:21
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'E-Import-Export',
	'description' => 'Outil d\'import et export. Nombreux formats supportés, dont JSON, XML, CSV...',
	'category' => 'be',
	'author' => 'Ian SEBBAGH',
	'author_email' => 'isebbagh@e-magineurs.com',
	'author_company' => 'E-magineurs',
	'state' => 'stable',
	'uploadfolder' => false,
	'clearCacheOnLoad' => 0,
	'version' => '2.0.0',
	'constraints' => [
		'depends' => [
			'typo3' => '11.5.0-13.4.99',
			'php' => '8.1.0-8.4.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
	'autoload' => [
		'psr-4' => [
			'Emagineurs\\EImportExport\\' => 'Classes'
		]
	]
];