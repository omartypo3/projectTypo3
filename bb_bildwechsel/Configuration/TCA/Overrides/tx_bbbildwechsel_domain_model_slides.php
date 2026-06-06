<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label'] = 'titel';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label_alt'] = 'link, bild';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label_alt_force'] = 1;


$GLOBALS['TCA']['tx_bbbildwechsel_domain_model_slides']['columns']['farbe']['config'] = array (
   'type' => 'input',
   'size' => 10,
   'wizards' => array(
       '_PADDING' => 2,
       'color' => array(
           'title' => 'Color:',
           'type' => 'colorbox',
           'dim' => '16×12',
          /* 'tableStyle' => 'border:solid 1px black;',*/
		   'module' => array(
				'name' => 'wizard_colorpicker'
			),
           //'script' => 'wizard_colorpicker.php',
           'JSopenParams' => 'height=500,width=500,status=0,menubar=0,scrollbars=1',
      ),
   ),
);

$GLOBALS['TCA']['tx_bbbildwechsel_domain_model_slides']['columns']['titel']['config']['rows']=3;
$GLOBALS['TCA']['tx_bbbildwechsel_domain_model_slides']['columns']['untertitel']['config']['rows']=3;
$GLOBALS['TCA']['tx_bbbildwechsel_domain_model_slides']['columns']['text']['config']['rows']=5;


$GLOBALS['TCA']['tx_bbbildwechsel_domain_model_slides']['columns']['link'] = array(
	'exclude' => 0,
	'label' => 'LLL:EXT:bb_bildwechsel/Resources/Private/Language/locallang_db.xlf:tx_bbbildwechsel_domain_model_slides.link',
	'config' => array(
		'type' => 'input',
		'size' => '30',
		'softref' => 'typolink',
		'wizards' => array(
			'_PADDING' => 2,
			'link' => array(
				 'type' => 'popup',
				 'title' => 'Link',
				 'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
				 'module' => array(
					'name' => 'wizard_element_browser',
					'urlParameters' => array(
						'mode' => 'wizard'
					) ,
				 ) ,
				 'JSopenParams' => 'height=600,width=500,status=0,menubar=0,scrollbars=1'
			)
		)
	)
);