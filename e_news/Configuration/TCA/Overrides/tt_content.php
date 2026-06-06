<?php
defined('TYPO3') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'enews_advanced',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.group.advancedviews'
);

// Plugin: Filter Today
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'FilterToday',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.filtertoday.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Filter Weekend
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'FilterWeekend',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.filterweekend.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Filter Week
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'FilterWeek',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.filterweek.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Filter Month
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'FilterMonth',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.filtermonth.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Create News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'CreateNews',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.createnews.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Delete News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'DeleteNews',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.deletenews.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Plugin: Validate News
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ENews',
    'ValidateNews',
    'LLL:EXT:e_news/Resources/Private/Language/locallang_be.xlf:plugin.validatenews.title',
    'EXT:news/Resources/Public/Icons/Extension.svg',
    'enews_advanced'
);

// Assign FlexForms to plugins
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_filtertoday'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_filtertoday'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_filtertoday',
    'FILE:EXT:e_news/Configuration/FlexForms/FilterToday.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_filterweekend'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_filterweekend'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_filterweekend',
    'FILE:EXT:e_news/Configuration/FlexForms/FilterWeekend.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_filterweek'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_filterweek'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_filterweek',
    'FILE:EXT:e_news/Configuration/FlexForms/FilterWeek.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_filtermonth'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_filtermonth'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_filtermonth',
    'FILE:EXT:e_news/Configuration/FlexForms/FilterMonth.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_createnews'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_createnews'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_createnews',
    'FILE:EXT:e_news/Configuration/FlexForms/CreateNews.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_deletenews'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_deletenews'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_deletenews',
    'FILE:EXT:e_news/Configuration/FlexForms/DeleteNews.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['enews_validatenews'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['enews_validatenews'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'enews_validatenews',
    'FILE:EXT:e_news/Configuration/FlexForms/ValidateNews.xml'
);

