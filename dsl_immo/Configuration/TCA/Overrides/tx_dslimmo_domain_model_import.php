<?php


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

#$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['ctrl']['label'] = 'titel';
$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['ctrl']['label_alt'] = 'crdate';
$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['ctrl']['label_alt_force'] = 1;

$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['columns']['crdate'] = array(
    			'exclude' => 1,
    			'config' => array(
    				'type' => 'input',
    				'size' => 13,
    				'max' => 20,
    				'eval' => 'datetime',
    				'checkbox' => 0,
    				'default' => 0,
    				'range' => array(
    					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
    				),
    			),
    		);

$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['columns']['type']['config']['items'] = array(
					array('TEIL', 10),
					array('VOLL', 20),
);


//nötig für backend dateierweiterungsvalidierung
//http://www.typo3.net/forum/thematik/zeige/thema/120073/
//http://www.typo3tiger.de/blog/post/extbase-fal-filereference-im-controller-erzeugen.html
$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['columns']['datei']['config']['foreign_selector_fieldTcaOverride']['config']['appearance']['elementBrowserAllowed']='zip';
$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['columns']['datei']['config']['filter'][0]['parameters']['allowedFileExtensions']='zip';
//$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['disallowedFileExtensions']='...(php)';
$GLOBALS['TCA']['tx_dslimmo_domain_model_import']['columns']['datei']['config']['foreign_match_fields'] = array(
						'fieldname' => 'datei',
						'tablenames' => 'tx_dslimmo_domain_model_import',
						'table_local' => 'sys_file'
);
