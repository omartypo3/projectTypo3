<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "e_powermail_multirecip".
 *
 * Auto generated 23-10-2014 11:22
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Powermail multi-recipient',
	'description' => 'Setting a list of recipient',
	'category' => 'E-Magineurs',
	'author' => 'Julia PARDANAUD',
	'author_email' => 'jpardanaud@e-magineurs.com',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'author_company' => '',
	'version' => '0.2.1',
	'constraints' => array (
		'depends' => array (
			'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-8.4.0',
			'powermail' => '',
		),
		'conflicts' => array (
		),
		'suggests' => array (
		),
	),
	'autoload' => [
		'psr-4' => [
			'Emagineurs\\EPowermailMultirecip\\' => 'Classes'
		]	
	],
	'_md5_values_when_last_written' => 'a:14:{s:9:"ChangeLog";s:4:"3652";s:12:"ext_icon.gif";s:4:"70a6";s:17:"ext_localconf.php";s:4:"58e5";s:14:"ext_tables.php";s:4:"2371";s:13:"locallang.xml";s:4:"cca4";s:10:"README.txt";s:4:"ee2d";s:19:"doc/wizard_form.dat";s:4:"8e33";s:20:"doc/wizard_form.html";s:4:"ccd7";s:47:"lib/class.tx_powermail_FieldMarkerArrayHook.php";s:4:"1e37";s:38:"lib/class.tx_powermail_submitemail.php";s:4:"b043";s:36:"lib/def/def_field_multirecipents.xml";s:4:"3b26";s:41:"pi1/class.tx_epowermailmultirecip_pi1.php";s:4:"87ac";s:17:"pi1/locallang.xml";s:4:"18b9";s:37:"template/tx_epowermailmultirecip.html";s:4:"4698";}',
);

