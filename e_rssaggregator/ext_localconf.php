<?php
defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'e_rssaggregator';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Aggregator',
	[
		\Emagineurs\ERssaggregator\Controller\AggregatorController::class => 'list',
	],
	[
		\Emagineurs\ERssaggregator\Controller\AggregatorController::class => 'list',
	]
);