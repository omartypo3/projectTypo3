<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$_EXTKEY ="dsl_produkte";
$extKey ="dsl_produkte";
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DslFactory.' . $_EXTKEY,
	'Produktsuche',
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'list, search, show, showzubehoer, datenblattprodukt, datenblattzubehoer, sort',
		
	),
	// non-cacheable actions
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'list, search, show, datenblattprodukt, datenblattzubehoer, sort',
		
	)
);

//dslmod eingriff
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DslFactory.' . $_EXTKEY,
	'Produktbrowser',
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'browse',
		
	),
	// non-cacheable actions
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'browse',
		
	)
);


/*\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DslFactory.' . $_EXTKEY,
    'Produktshow',
    array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'show',

    ),
    // non-cacheable actions
    array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'show',

    )
);*/


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DslFactory.' . $_EXTKEY,
	'Produkthighlights',
	array(
        \DslFactory\DslProdukte\Controller\HighlightsController::class => 'list',
		
	),
	// non-cacheable actions
	array(
        \DslFactory\DslProdukte\Controller\HighlightsController::class => 'list',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DslFactory.' . $_EXTKEY,
	'Produktopengraph',
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'opengraph',
		
	),
	// non-cacheable actions
	array(
        \DslFactory\DslProdukte\Controller\ProdukteController::class => 'opengraph',
		
	)
);


/* ===========================================================================
		Hooks
	=========================================================================== */

//oben als action ergänzen: datenblattprodukt, datenblattzubehoer

//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['dslprodukte'] = 			'Tx_Dslprodukte_Hooks_RealUrlAutoConfiguration->addDslprodukteConfig';


//http://www.derhansen.de/2014/06/typo3-how-to-prevent-empty-flexform.html
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['DslFactory.' . $_EXTKEY] = 'DslFactory\DslProdukte\Hooks\DataHandlerHooks';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig("@import 'EXT:dsl_produkte/Configuration/PageTSConfig/BE_Layouts/t3sbootstrap_4.tsconfig'");