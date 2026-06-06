<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}
// Hook pour modifier le rendu BE des contenus de type menus
/*
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['menu'] =  'EXT:e_package/Classes/Hooks/CmsLayoutDrawitem.php:Emagineurs\\Hooks\\CmsLayoutDrawitem';
*/
// Hook pour aligner les boutons d'enregistrement des contenus
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton::class] = [
    'className' => \Emagineurs\EPackage\Hooks\UnrolledSplitButton::class
];
if (TYPO3 === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extensionmanager']['hasInstalledExtensions'][] = \Emagineurs\EPackage\Service\InstallService::class . '->generateDefaultFiles';
    
    //Picto des dossiers du BackEnd
    $icons = [
        'apps-pagetree-folder-contains-emagineurs_agenda' => 'agenda.png',
        'apps-pagetree-folder-contains-emagineurs_annuaire' => 'annuaire.png',
        'apps-pagetree-folder-contains-emagineurs_carto' => 'carto.png',
        'apps-pagetree-folder-contains-emagineurs_categories' => 'categories.png',
        'apps-pagetree-folder-contains-emagineurs_faq' => 'faq.png',
        'apps-pagetree-folder-contains-emagineurs_formulaire' => 'formulaire.png',
        'apps-pagetree-folder-contains-emagineurs_glossaire' => 'glossaire.png',
        'apps-pagetree-folder-contains-emagineurs_video' => 'video.png',
        'e_magineurs_icon' => 'menu.png',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:e_package/Resources/Public/Icons/' . $path]
        );
    }
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:e_package/Configuration/TSConfig/tsconfig.txt">'
);