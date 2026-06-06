<?php
defined('TYPO3') || die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$extensionKey = 'e_comment';
$extensionName = 'EComment';
$pluginGroup = 'ecomment';
$icon = 'EXT:e_comment/Resources/Public/Icons/ext_icon.gif';

ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript',
    'Comment TS-config [default]'
);

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    $pluginGroup,
    'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.group.comment'
);

$plugins = [
    'Comment' => [
        'title' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.comment',
        'flexform' => 'FILE:EXT:e_comment/Configuration/FlexForms/flexform_comment.xml',
    ],
    'List' => [
        'title' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.list',
        'flexform' => 'FILE:EXT:e_comment/Configuration/FlexForms/flexform_list.xml',
    ],
    'Search' => [
        'title' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.search',
        'flexform' => 'FILE:EXT:e_comment/Configuration/FlexForms/flexform_search.xml',
    ],
    'Add' => [
        'title' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.add',
        'flexform' => 'FILE:EXT:e_comment/Configuration/FlexForms/flexform_add.xml',
    ],
    'Validate' => [
        'title' => 'LLL:EXT:e_comment/Resources/Private/Language/locallang_db.xlf:plugin.validate',
        'flexform' => 'FILE:EXT:e_comment/Configuration/FlexForms/flexform_validate.xml',
    ],
];

foreach ($plugins as $pluginName => $configuration) {
    ExtensionUtility::registerPlugin(
        $extensionName,
        $pluginName,
        $configuration['title'],
        $icon,
        $pluginGroup
    );

    $pluginSignature = strtolower($extensionName . '_' . $pluginName);

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        $configuration['flexform']
    );
}