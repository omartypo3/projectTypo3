<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

$_EXTKEY = 'ns_revolution_slider';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Slider',
    'NS Revolution slider'
);

//Add Modules
if (TYPO3 === 'BE') {
    $isVersion9Up = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 9000000;

    if (!array_key_exists('nitsan', $GLOBALS['TBE_MODULES']) || $GLOBALS['TBE_MODULES']['nitsan'] =='') {
        $GLOBALS['TBE_MODULES'] = array_slice($GLOBALS['TBE_MODULES'], 0, 1, true) + ['nitsan' => ''] + array_slice($GLOBALS['TBE_MODULES'], 1, count($GLOBALS['TBE_MODULES']) - 1, true);
        if (version_compare(TYPO3_branch, '7.0', '>=')) {
            $GLOBALS['TBE_MODULES']['_configuration']['nitsan'] = [
                'iconIdentifier' => 'parent-module-nsrevolution',
                'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/BackendModule.xlf',
                'name' => 'nitsan'
            ];
        }
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'NsRevolutionSlider',
        'nitsan', // Make module a submodule of 'nitsan'
        'M1', // Submodule key
        '', // Position
        [
            \NITSAN\NsRevolutionSlider\Controller\BackendController::class => 'index'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:ns_revolution_slider/Resources/Public/Icons/ns_revolution_slider.svg',
            'labels' => 'LLL:EXT:ns_revolution_slider/Resources/Private/Language/locallang_ns.xlf:lang_labels_tablabel'
        ]
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $icon = [
            'parent-module-nsrevolution'
        ];
    foreach ($icon as $value) {
        $iconRegistry->registerIcon(
            $value,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/' . $value . '.svg']
        );
    }
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import \'EXT:ns_revolution_slider/Configuration/TSconfig/ContentElementWizard.tsconfig\''
);

