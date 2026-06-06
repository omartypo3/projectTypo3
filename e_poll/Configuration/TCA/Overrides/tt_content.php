<?php
defined('TYPO3') || die();


// Assign FlexForms
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_pollsingle'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_pollsingle'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_pollsingle',
    'FILE:EXT:e_poll/Configuration/FlexForms/Single.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_polllist'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_polllist'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_polllist',
    'FILE:EXT:e_poll/Configuration/FlexForms/List.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['epoll_pollresult'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['epoll_pollresult'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'epoll_pollresult',
    'FILE:EXT:e_poll/Configuration/FlexForms/Result.xml'
);

