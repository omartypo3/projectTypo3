<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Search');


$GLOBALS['TCA']['tx_kesearch_filteroptions']['ctrl']['hideTable'] = 1;	
$GLOBALS['TCA']['tx_kesearch_filters']['ctrl']['hideTable'] = 1;	
$GLOBALS['TCA']['tx_kesearch_index']['ctrl']['hideTable'] = 1;	


// enable:
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['startingpoints_recursive']['displayCond'] .= ','.\TYPO3\J77Kesearch\Hooks\RegisterIndexerFluidcontent::$indexerType;
#$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',customflexiblecontent';
// Show the sysfolder in the indexer configuration. From this, the data records to be indexed are read.
// Since the ke_search developers were combed with the hammer, this important field is hidden by default.
// Important here: "customansprechpartner" must be replaced by the TYPE that you set in the indexer.
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',customconferencecontent';

$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',customteamcontent';

$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['targetpid']['displayCond'] .= ','.\TYPO3\J77Kesearch\Hooks\RegisterIndexerFluidcontent::$indexerType;


