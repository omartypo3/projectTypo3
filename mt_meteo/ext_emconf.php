<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mt_meteo".
 *
 * Auto generated 15-04-2014 15:24
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Montreux Météo Suisse',
	'description' => 'Affichage de la météo du jour depuis MétéoSuisse',
	'category' => 'plugin',
	'author' => 'David Ansermot',
	'author_email' => 'david.ansermot@wng.ch',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => 'L',
	'author_company' => 'WnG Solutions SA',
	'version' => '1.0.0',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '4.6.0-9.9.99',
			'php' => '3.0.0-0.0.0',
			'cms' => '',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'_md5_values_when_last_written' => 'a:14:{s:9:"ChangeLog";s:4:"cac0";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"0a98";s:14:"ext_tables.php";s:4:"fb6b";s:13:"locallang.xml";s:4:"b80f";s:16:"locallang_db.xml";s:4:"ab4a";s:10:"README.txt";s:4:"ee2d";s:19:"doc/wizard_form.dat";s:4:"2d80";s:20:"doc/wizard_form.html";s:4:"e6eb";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:28:"pi1/class.tx_mtmeteo_pi1.php";s:4:"eea3";s:36:"pi1/class.tx_mtmeteo_pi1_wizicon.php";s:4:"e87f";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"538a";}',
	'suggests' => 
	array (
	),
);

?>