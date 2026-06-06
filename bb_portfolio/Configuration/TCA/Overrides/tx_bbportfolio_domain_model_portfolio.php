<?php


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder




$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label'] = 'kunde';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label_alt'] = 'kundenname, titel, kategorie';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['label_alt_force'] = 1;


$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['related']['config']['enableMultiSelectFilterTextfield'] = true;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['datum']['config']['eval'] = 'datetime,required';
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['datum']['config']['default'] = '2010-11-11 11:11:11';

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem'] = str_replace(', kundenname, kundennamecheck, kunde, kategorie, hashtags','',$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem']);
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem'] = str_replace(', datum',', --palette--;LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.kundenauswahl;kundenauswahl, kategorie, hashtags, datum',$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem']);//kunde, kundenname


$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['alias']['config']['eval'] = 'trim,alphanum_x,nospace,lower,unique,required';


$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['config']['foreign_table_where'] = 'AND 1=1 Order by name ASC';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kategorie']['config']['foreign_table_where'] = 'AND 1=1 Order by name ASC';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['hashtags']['config']['foreign_table_where'] = 'AND 1=1 Order by name ASC';
//$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['related']['config']['foreign_table_where'] = 'AND 1=1 Order by titel ASC';

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['related']['config']['foreign_table_where'] = 'AND 1=1 AND tx_bbportfolio_domain_model_portfolio.uid != ###THIS_UID### Order by tx_bbportfolio_domain_model_portfolio.sorting ASC';
//sorting

/*
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['related']['config']['wizards']['list'] = [
                        'type' => 'script',
                        'title' => 'Projekte',
                        'icon' => 'actions-system-list-open',
                        'params' => [
                            'table' => 'tx_bbportfolio_domain_model_portfolio',
                            'pid' => 45,//$configuration->getTagPid(),
                        ],
                        'module' => [
                            'name' => 'wizard_list',
                        ],
                    ];
*/

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['related']['config']['wizards']['suggest'] = [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => true,
							'additionalSearchFields' => 'beschreibung, kunde, alias',
                            //'receiverClass' => \GeorgRinger\News\Hooks\SuggestReceiver::class
                        ],
                    ];


	//'trim,BravoBuero\\BbPortfolio\\Evaluation\\ExampleEvaluation,unique,required';
	//'trim,required,unique,nospace,lower,alphanum_x,alpha';


//$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['bilder']['config']['maxitems'] = 5;

#$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kundenname']['config']['checkbox'] = 1;


				
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['displayCond'] = 'FIELD:kundennamecheck:=:0';				$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kundenname']['displayCond'] = 'FIELD:kundennamecheck:=:1';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['ctrl']['requestUpdate'] = 'kundennamecheck';

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kundenname']['config']['eval']='trim,required';

//'requestUpdate' => 'hidecontent',
//$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kundenname']['exclude'] =0;
	
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['link'] = array(
	'exclude' => 0,
	'label' => 'LLL:EXT:bb_portfolio/Resources/Private/Language/locallang_db.xlf:tx_bbportfolio_domain_model_portfolio.link',
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
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['seo_keywords']['config']['rows'] = 5;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['seo_keywords']['config']['cols'] = 30;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['seo_keywords']['config']['placeholder'] = 'Schlüsselwort1, Schlüsselwort2, Schlüsselwort3';
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['seo_description']['config']['rows'] = 4;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['seo_description']['config']['cols'] = 30;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['palettes']['metatags'] = array(
            'showitem' => 'seo_keywords,--linebreak--,seo_description,',
            'canNotCollapse' => 1
        );



$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kundennamecheck']['config']=array('type' => 'check','default'=>0);
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['config']['default']=0;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['config']['eval']='required';
/*$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['config']['items'] = array(
                        array(' --- Bitte wählen --- ',0)
);*/
$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['columns']['kunde']['config']['size'] = 8;

$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem'] = str_replace(', seo_keywords, seo_description','',$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem']);


$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['types']['1']['showitem'].= ',
--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags';


$GLOBALS['TCA']['tx_bbportfolio_domain_model_portfolio']['palettes']['kundenauswahl'] = array(
            'showitem' => 'kunde,kundennamecheck,kundenname,',
			'canNotCollapse' => 1
        );

