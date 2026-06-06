<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'Configuration de base du package E-magineurs'
);

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Agenda',
    1 => 'emagineurs_agenda',
    2 => 'apps-pagetree-folder-contains-emagineurs_agenda'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Annuaire',
    1 => 'emagineurs_annuaire',
    2 => 'apps-pagetree-folder-contains-emagineurs_annuaire'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Cartographie',
    1 => 'emagineurs_carto',
    2 => 'apps-pagetree-folder-contains-emagineurs_carto'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Catégories',
    1 => 'emagineurs_categories',
    2 => 'apps-pagetree-folder-contains-emagineurs_categories'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Faq',
    1 => 'emagineurs_faq',
    2 => 'apps-pagetree-folder-contains-emagineurs_faq'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Formulaires',
    1 => 'emagineurs_formulaire',
    2 => 'apps-pagetree-folder-contains-emagineurs_formulaire'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Glossaire',
    1 => 'emagineurs_glossaire',
    2 => 'apps-pagetree-folder-contains-emagineurs_glossaire'
];
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Vidéos',
    1 => 'emagineurs_video',
    2 => 'apps-pagetree-folder-contains-emagineurs_video'
];

$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_agenda'] = 'apps-pagetree-folder-contains-emagineurs_agenda';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_annuaire'] = 'apps-pagetree-folder-contains-emagineurs_annuaire';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_carto'] = 'apps-pagetree-folder-contains-emagineurs_carto';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_categories'] = 'apps-pagetree-folder-contains-emagineurs_categories';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_faq'] = 'apps-pagetree-folder-contains-emagineurs_faq';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_formulaire'] = 'apps-pagetree-folder-contains-emagineurs_formulaire';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_glossaire'] = 'apps-pagetree-folder-contains-emagineurs_glossaire';
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-emagineurs_video'] = 'apps-pagetree-folder-contains-emagineurs_video';