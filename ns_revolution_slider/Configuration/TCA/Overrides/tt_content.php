<?php
defined('TYPO3') or die();

$_EXTKEY = 'ns_revolution_slider';

/***************
 * Plugin
 */
$nsRevolutionSlider = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsRevolutionSlider',
    'Slider',
    'NS Revolution slider'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsrevolutionslider_domain_model_slideitem', 'EXT:ns_revolution_slider/Resources/Private/Language/locallang_csh_tx_nsrevolutionslider_domain_model_slideitem.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsrevolutionslider_domain_model_slideitem');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsrevolutionslider_domain_model_slider', 'EXT:ns_revolution_slider/Resources/Private/Language/locallang_csh_tx_nsrevolutionslider_domain_model_slider.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsrevolutionslider_domain_model_slider');

/* Flexform setting  */
/*$pluginSignature = str_replace('_', '', $_EXTKEY) . '_' . 'slider';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForm/FlexForm.xml');*/

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$nsRevolutionSlider] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$nsRevolutionSlider] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($nsRevolutionSlider, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForm/FlexForm.xml');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][] = [
    'nodeName' => 'customSlider',
    'priority' => 40,
    'class' => \NITSAN\NsRevolutionSlider\Plugins\Slider::class,
];
