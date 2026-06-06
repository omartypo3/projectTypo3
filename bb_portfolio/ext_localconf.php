<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Kundenslider',
	array(
		\BravoBuero\BbPortfolio\Controller\KundenController::class => 'listslider',
		
	),
	// non-cacheable actions
	// array(
	// 	'Kunden' => 'listslider',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'PortfolioausgabeKunden',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'listkunden, detailkunden',
		
	),
	// non-cacheable actions
	// array(
	// 	'Kunden' => 'listslider',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'PortfolioausgabeLatest',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'latest',
		
	),
	// non-cacheable actions
	// array(
	// 	'Kunden' => 'listslider',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'PortfolioausgabeKategorien',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'latestkategorien',
		
	),
	// non-cacheable actions
	// array(
	// 	'Kunden' => 'listslider',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Portfolioausgabe',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'list, latest, listkunden, detailkunden, detail, megamenu, latestkategorien',
		
	),
	// non-cacheable actions
	// array(
	// 	'Portfolio' => 'list, latest, megamenu, latestkategorien',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Megamenu',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'megamenu',
		
	),
	// non-cacheable actions
	// array(
	// 	'Portfolio' => 'megamenu',
		
	// )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Pagebrowser',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailnav',
		
	),
	// non-cacheable actions
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailnav',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Pagebrowserback',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailback',
		
	),
	// non-cacheable actions
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailback',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Pagebrowserkunden',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailkundennav',
		
	),
	// non-cacheable actions
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailkundennav',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbPortfolio',
	'Portfoliodetailrelated',
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailrelated',
		
	),
	// non-cacheable actions
	array(
		\BravoBuero\BbPortfolio\Controller\PortfolioController::class => 'detailrelated',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

/**
     * Hook for initially filling the marker field in backend
     */
   // $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =        'EXT:powermail/Classes/Hook/CreateMarker.php:In2code\Powermail\Hook\CreateMarker';

//$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['bb_portfolio'] = 'BravoBuero\\BbPortfolio\\Hook\\TCEmainHook';
//$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['bb_portfolio'] = 'BravoBuero\\BbPortfolio\\Hook\\TCEmainHook';