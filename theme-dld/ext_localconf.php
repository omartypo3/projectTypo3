<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}



\FluidTYPO3\Flux\Core::registerProviderExtensionKey('theme', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('theme', 'Content');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Theme\\Command\\ImportCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] ='DLD\\Dld\\Command\\highriseCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] ='DLD\\Dld\\Command\\xingCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] ='DLD\\Dld\\Command\\mailchimpCommandController';

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'default-not-found',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:theme/Resources/Public/logos/apple-touch.png']
        );