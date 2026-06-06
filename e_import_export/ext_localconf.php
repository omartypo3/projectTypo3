<?php
defined('TYPO3') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['eImportExport'] = \Emagineurs\EImportExport\AjaxHandler::class . '::processRequest';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Emagineurs\EImportExport\SchedulerTask\ImportExportTask::class] = [
	'extension' => 'e_import_export',
	'title' => 'LLL:EXT:e_import_export/Resources/Private/Language/locallang.xlf:ImportExportTask.name',
	'description' => 'LLL:EXT:e_import_export/Resources/Private/Language/locallang.xlf:ImportExportTask.description',
	'additionalFields' => \Emagineurs\EImportExport\SchedulerTask\ImportExportAdditionalFieldProvider::class
];

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['import']['json'] = \Emagineurs\EImportExport\Handlers\Import\JsonHandlers::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['import']['csv'] = \Emagineurs\EImportExport\Handlers\Import\CsvHandlers::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['import']['xml'] = \Emagineurs\EImportExport\Handlers\Import\XmlHandlers::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['export']['json'] = \Emagineurs\EImportExport\Handlers\Export\JsonHandlers::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['export']['xml'] = \Emagineurs\EImportExport\Handlers\Export\XmlHandlers::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['export']['csv'] = \Emagineurs\EImportExport\Handlers\Export\CsvHandlers::class;



$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['eImportExport']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['eImportExport']['options']['defaultLifetime'] = 60*60*24;

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'eimportexport-module-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:e_import_export/Resources/Public/Icons/importexport.png']
);

