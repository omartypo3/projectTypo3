<?php
defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'ns_revolution_slider';
if (TYPO3 === 'BE' && version_compare(TYPO3_branch, '7.0', '>')) {
    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $dispatcher->connect(
        'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
        'hasInstalledExtensions',
        'NITSAN\\NsRevolutionSlider\\Slots\\InstallUtility',
        'executeOnSignal'
    );
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsRevolutionSlider',
    'Slider',
    [
        \NITSAN\NsRevolutionSlider\Controller\SliderController::class => 'show'
    ],
    // non-cacheable actions
    [
        \NITSAN\NsRevolutionSlider\Controller\SliderController::class => 'show'
    ]
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

$iconRegistry->registerIcon(
    'ns_revolution_slider-plugin-slider',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_revolution_slider/Resources/Public/Icons/ns_revolution_slider.svg']
);



$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['ns_revolution_slider']
        = \NITSAN\NsRevolutionSlider\Hooks\PageLayoutView::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']['Slider'] = [
    'nodeName' => 'customSlider',
    'priority' => 40,
    'class' => \NITSAN\NsRevolutionSlider\Plugins\Slider::class,
];

// Register hook on successful BE user login
/*$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['backendUserLogin'][] =
    \NITSAN\NsRevolutionSlider\Hooks\BackendUserLogin::class . '->dispatch';*/


