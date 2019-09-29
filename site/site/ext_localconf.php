<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['siteconfig'] = 'EXT:site/Configuration/RTE/CustomConfig.yaml';


//------------------------------------------
// register icons for custom elements
//------------------------------------------
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

$identifiers = array(
);

foreach ($identifiers as $identifier) {
    $file = 'icon_default';

    switch ($identifier) {
        case 'xyz':
            $file = 'xyz';
            break;
    }

    $iconRegistry->registerIcon(
        $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:site/Resources/Public/Icons/' . $file . '.png']
    );
}

#$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:news/Resources/Private/Language/locallang.xlf'][] = 'EXT:site/Resources/Ext/News/Private/Language/locallang.xlf';
