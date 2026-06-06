<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'bbBildwechsel',
	'Bildwechsel',
	array(
		\BravoBuero\BbBildwechsel\Controller\SlidesController::class => 'list',

	),
	// non-cacheable actions
	array(
		\BravoBuero\BbBildwechsel\Controller\SlidesController::class => 'list',

	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder