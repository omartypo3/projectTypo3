<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['goldlandconfig'] = 'EXT:logifact/Configuration/RTE/CustomConfig.yaml';
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
        ['source' => 'EXT:waeschereien_frontend/Resources/Public/Icons/' . $file . '.png']
    );
}
call_user_func(function () {
    if (TYPO3_MODE === 'BE') {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
            module.tx_form {
                settings {
                    yamlConfigurations {
                        1505042806 = EXT:logifact/Configuration/Yaml/FormSetup.yaml
                    }
                }
            }
        '));
    }
});
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\\News\\ViewHelpers\\Widget\\Controller\\PaginateController'] = array(
    'className' => 'Logifacttheme\\Logifact\\ViewHelpers\\Widget\\Controller\\PaginateController'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:news/Resources/Private/Language/locallang.xlf'][] = 'EXT:logifact/Resources/Ext/News/Private/Language/locallang.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['en']['EXT:news/Resources/Private/Language/locallang.xlf'][] = 'EXT:logifact/Resources/Ext/News/Private/Language/en.locallang.xlf';