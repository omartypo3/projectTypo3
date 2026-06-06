<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['plaine-commune'] = 'EXT:e_magineurs/plaine-commune/Configuration/RTE/rte.yaml';
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['sitefactory'] = 'EXT:e_magineurs/site-factory/Configuration/RTE/rte.yaml';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Fiche'][] = 'EXT:e_magineurs/Classes/Domain/Model/Traits/FicheExtended.php';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['export']['xml'] = \Emagineurs\EImportExport\Handlers\Export\XmlHandlers::class;
// Ajouter des couleurs dans l'arborescence backend.
/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
        options.pageTree.backgroundColor.uidPage = rgba(255,109,0,0.2)
');
*/

//FalSecureDownload Redirection vers la page de connexion pour éviter le message Authentification required !
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fal_securedownload']['login_redirect_url'] = '/login/?redirect_url=###REQUEST_URI###';
//FalSecureDownlad Redirection vers une page d'information au lieu du message Access denied
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fal_securedownload']['no_access_redirect_url'] = '/no-access/?redirect_url=###REQUEST_URI###';

// // On utilise un hook de e_annuaires pour gérer le champ document (à la base géré par un inline, mais pas voulu ici + pas de fe_user fait que c'est la meileur solution trouvé)
// $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
// $signalSlotDispatcher->connect(
//     Emagineurs\EAnnuaires\Controller\EditfeController::class,
//     'createActionBeforeAdd',
//     Emagineurs\EMagineurs\Hooks\Eannuaires::class,
//     'addDocumentToCandidature'
// );

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['e_annuaires']['createActionBeforeAdd'][] = Emagineurs\EMagineurs\Hooks\Eannuaires::class . '->addDocumentToCandidature';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['EAnnuaires']['plugins']['Pi1']['controllers']['Fiche']['nonCacheableActions'][] = 'list';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['e_news']['validateActionAfterValidate'][] = Emagineurs\EMagineurs\Hooks\Enews::class . '->sendUserMailAfterValidation';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['femanager']['createAdminConfirmationRequestManualConfirmation'][] = Emagineurs\EMagineurs\Hooks\Femanager::class . '->sendUserMailAfterSubscription';
// $signalSlotDispatcher->connect(
//     Emagineurs\ENews\Controller\EnewsController::class,
//     'validateActionAfterValidate',
//     Emagineurs\EMagineurs\Hooks\Enews::class,
//     'sendUserMailAfterValidation'
// );
// //Hook pour envoi de mail lors de l'inscription d'un utilisateur
// $signalSlotDispatcher->connect(
//     In2code\Femanager\Controller\NewController::class,
//     'createAdminConfirmationRequestManualConfirmation',
//     Emagineurs\EMagineurs\Hooks\Femanager::class,
//     'sendUserMailAfterSubscription'
// );


// // Fix for select
// $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Fluid\\ViewHelpers\\Form\\SelectViewHelper']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\SelectViewHelper';

// Fix for workspace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Utility\\RootlineUtility']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\RootlineUtility';

// Prevent crash if resource was deleted
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Resource\\FileRepository']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\FileRepository';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\Resource\\FileCollector']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\FileCollector';

// This prevents the "invalid query parser 'typo3access'" error
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['ApacheSolrForTypo3\\Solr\\Domain\\Search\\Query\\QueryBuilder']['className'] = 'Emagineurs\\EMagineurs\\Xclass\\SolrQueryBuilder';

