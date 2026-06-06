<?php

declare(strict_types=1);

defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Pi1',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'list'
	],
	// non-cacheable actions
	[
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Show',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'show'
	],
	// non-cacheable actions
	[
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Catmenu',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'catmenu'
	],
	// non-cacheable actions
	[
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Search',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'search'
	],
	// non-cacheable actions
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'search'
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Resultat',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'resultat'
	],
	// non-cacheable actions
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'resultat'
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'Gestion',
	[
		\Emagineurs\EAnnuaires\Controller\EditfeController::class => 'manage, edit, create, handleInlineGeneration, editLien, createLien, delete, handleInlineSubmit, removeInlineItem'
	],
	// non-cacheable actions
	[
		\Emagineurs\EAnnuaires\Controller\EditfeController::class => 'manage, edit, create, handleInlineGeneration, editLien, createLien, delete, handleInlineSubmit, removeInlineItem'
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'sendMail',
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'sendMail'
	],
	// non-cacheable actions
	[
		\Emagineurs\EAnnuaires\Controller\FicheController::class => 'sendMail'
	],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);




\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'EAnnuaires',
	'annuaireoffre',
	[
		\Emagineurs\EAnnuaires\Controller\OffreController::class => 'show,markAsRead,convertToPdf',
	],
	// non-cacheable actions
	[],
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

// Hook pour inclure la conf dans $GLOBALS avant d'arriver dans le TCA
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['e_annuaires'] = \Emagineurs\EAnnuaires\Hooks\IncludeConf::class;

// AJAX routes are now registered in Configuration/Backend/AjaxRoutes.php

//Tache pour l'import des fe_users
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Emagineurs\EAnnuaires\SchedulerTask\ImportTableTask::class] = [
	'extension' => 'e_annuaires',
	'title' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang.xlf:ImportTableTask.name',
	'description' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang.xlf:ImportTableTask.description',
	'additionalFields' => \Emagineurs\EAnnuaires\SchedulerTask\ImportTableAdditionalFieldProvider::class
];

//Tache pour la purge des candidatures
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Emagineurs\EAnnuaires\SchedulerTask\PurgeCandidaturesTask::class] = [
	'extension' => 'e_annuaires',
	'title' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang.xlf:PurgeCandidaturesTask.name',
	'description' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang.xlf:PurgeCandidaturesTask.description',
	'additionalFields' => \Emagineurs\EAnnuaires\SchedulerTask\PurgeCandidaturesTaskFieldProvider::class
];

// Configuration des templates proposés par défaut
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['liste'] = [
	30 => 'Personnes',
	40 => 'Galerie vidéo'
];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['detail'] = [
	30 => 'Personnes',
	40 => 'Galerie vidéo'
];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['catmenu'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['search'] = [
	30 => 'Personnes',
	40 => 'Galerie vidéo'
];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['result'] = [
	30 => 'Personnes',
	40 => 'Galerie vidéo'
];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['manage'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['defaultLayout']['edit'] = [];

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
	'eannuaires-wizicon',
	\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	['source' => 'EXT:e_annuaires/Resources/Public/Icons/wizicon.gif']
);
$iconRegistry->registerIcon(
	'eannuaires-module-icon',
	\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	['source' => 'EXT:e_annuaires/Resources/Public/Icons/picto_annuaire.png']
);
$iconRegistry->registerIcon(
	'eannuaires-offre-module-icon',
	\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	['source' => 'EXT:e_annuaires/Resources/Public/Icons/picto_offres_emploi.png']
);

