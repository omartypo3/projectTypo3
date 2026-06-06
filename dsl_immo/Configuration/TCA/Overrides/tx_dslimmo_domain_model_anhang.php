<?php





## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['ctrl']['label_alt'] = 'datei';
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['ctrl']['label_alt_force'] = 1;
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['columns']['crdate'] = array(
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
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['columns']['type']['config']['items'] = array(
					array('TITELBILD', 10),
					array('INNENANSICHTEN', 20),
					array('AUSSENANSICHTEN', 30),
					array('GRUNDRISS', 40),
					array('KARTEN_LAGEPLAN', 50),
					array('ANBIETERLOGO', 60),
					array('BILD', 70),
					array('PANORAMA', 80),
					array('QRCODE', 90),
					array('FILM', 100),
					array('EPASS-SKALA', 110),
);

//nötig für backend dateierweiterungsvalidierung
//http://www.typo3.net/forum/thematik/zeige/thema/120073/
//http://www.typo3tiger.de/blog/post/extbase-fal-filereference-im-controller-erzeugen.html
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['columns']['datei']['config']['foreign_selector_fieldTcaOverride']['config']['appearance']['elementBrowserAllowed']='jpg,gif,png,pdf';
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['columns']['datei']['config']['filter'][0]['parameters']['allowedFileExtensions']='jpg,gif,png,pdf';
//$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['disallowedFileExtensions']='...(php)';
$GLOBALS['TCA']['tx_dslimmo_domain_model_anhang']['columns']['datei']['config']['foreign_match_fields'] = array(
						'fieldname' => 'datei',
						'tablenames' => 'tx_dslimmo_domain_model_anhang',
						'table_local' => 'sys_file'
);

