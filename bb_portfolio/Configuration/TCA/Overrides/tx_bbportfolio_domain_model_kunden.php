<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



//$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['branche']['config']['maxitems'] = 1;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['ctrl']['label'] = 'name';
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['ctrl']['label_alt'] = 'alias';
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['ctrl']['label_alt_force'] = 1;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['alias']['config']['eval'] = 'trim,alphanum_x,nospace,lower,unique,required';

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['unternehmen_groesse']['config']['items'] = array(
	array('1 - 10', 10),
	array('10 - 100', 20),
	array('100 - 1000', 30),
	array('über 1000', 40)
);

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['branche']['config']['foreign_table_where'] = 'AND 1=1 Order by name ASC';
	
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['primaer_farbe']['config'] = array (
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

//$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['beschreibung']['config']['rows']=7;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['beschreibung'] = array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.beschreibung',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		);


	
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['link_webseite'] = array(
	'exclude' => 0,
	'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.link_webseite',
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
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['link_facebook'] = array(
	'exclude' => 0,
	'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_kunden.link_facebook',
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


/*SEO Block*/
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['seo_keywords']['config']['rows'] = 5;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['seo_keywords']['config']['cols'] = 30;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['seo_keywords']['config']['placeholder'] = 'Schlüsselwort1, Schlüsselwort2, Schlüsselwort3';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['seo_description']['config']['rows'] = 4;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['columns']['seo_description']['config']['cols'] = 30;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['palettes']['metatags'] = array(
            'showitem' => 'seo_title,--linebreak--,seo_keywords,--linebreak--,seo_description,',
            'canNotCollapse' => 1
        );

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['types']['1']['showitem'] = str_replace(', seo_title, seo_keywords, seo_description','',$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['types']['1']['showitem']);


$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['types']['1']['showitem'].= ',
--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags';

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['types']['1']['showitem'] = str_replace('beschreibung,','beschreibung;;;richtext:rte_transform[mode=ts_links],',$GLOBALS['TCA']['tx_bbportfolio_domain_model_kunden']['types']['1']['showitem']);
