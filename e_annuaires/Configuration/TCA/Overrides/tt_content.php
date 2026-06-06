<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Define your plugins in one array
$plugins = [
    'Pi1' => [
        'title' => 'Annuaires',
        'flexform' => 'Configuration/FlexForms/flexform_fiche.xml'
    ],
    'Show' => [
        'title' => 'Annuaires Show',
        'flexform' => 'Configuration/FlexForms/flexform_show.xml'
    ],
    'Catmenu' => [
        'title' => 'Annuaires Catmenu',
        'flexform' => 'Configuration/FlexForms/flexform_catmenu.xml'
	],
	'Search' => [
        'title' => 'Annuaires Search',
        'flexform' => 'Configuration/FlexForms/flexform_search.xml'
    ],
	'Resultat' => [
        'title' => 'Annuaires Resultat',
        'flexform' => 'Configuration/FlexForms/flexform_resultat.xml'
    ],
	'Gestion' => [
        'title' => 'Annuaires Gestion',
        'flexform' => 'Configuration/FlexForms/flexform_gestion.xml'
    ],
	'sendMail' => [
        'title' => 'Annuaires sendMail',
        'flexform' => 'Configuration/FlexForms/flexform_sendMail.xml'
    ]
];

foreach ($plugins as $pluginName => $pluginConfig) {

    // Register plugin
    ExtensionUtility::registerPlugin(
        'EAnnuaires',
        $pluginName,
        $pluginConfig['title'],
        'eannuaires-wizicon',
        'annuaires'
    );

    // Plugin signature (lowercase, underscores)
    $pluginSignature = strtolower('eannuaires_' . $pluginName);

    // TCA tweaks
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

    // Attach FlexForm if defined
    if (!empty($pluginConfig['flexform'])) {
        ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:e_annuaires/' . $pluginConfig['flexform']
        );
    }
}
