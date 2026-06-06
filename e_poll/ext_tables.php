<?php
defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'epoll',
    'E-Poll - Sondages'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EPoll',
    'PollSingle',
    'Poll Single',
    'EXT:e_poll/Resources/Public/Icons/ext_icon.gif',
    'epoll'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EPoll',
    'PollList',
    'Poll List',
    'EXT:e_poll/Resources/Public/Icons/ext_icon.gif',
    'epoll'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'EPoll',
    'PollResult',
    'Poll Result',
    'EXT:e_poll/Resources/Public/Icons/ext_icon.gif',
    'epoll'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_pollsingle'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_pollsingle'] = 'layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_pollsingle',
    'FILE:EXT:e_poll/Configuration/FlexForms/Single.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_polllist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_polllist'] = 'layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_polllist',
    'FILE:EXT:e_poll/Configuration/FlexForms/List.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_pollresult'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_pollresult'] = 'layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_pollresult',
    'FILE:EXT:e_poll/Configuration/FlexForms/Result.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('e_poll', 'Configuration/TypoScript', 'Poll TS-config [default]');