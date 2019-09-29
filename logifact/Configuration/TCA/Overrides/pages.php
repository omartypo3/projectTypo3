<?php

defined('TYPO3_MODE') or die();

$extKey = 'logifact';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extKey,
    'Configuration/TSConfig/Page.txt',
    'Logifact'
);


$tmpFeUsersColumns = [
    'show_subnavigation' => [
        'exclude' => 1,
        'label' => 'Show Subnavigation on this page (if exist)',
        'config' => [
            'type' => 'radio',
            'items' => [
                ['Show', '1'],
                ['hide', '0'],
            ],
            'default' => '0',
        ]
    ],
];

$tmpClassColumns = [
    'class_subnavigation' => [
        'exclude' => false,
        'label' => 'Class Subnavigation on this page ',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tmpFeUsersColumns, true);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tmpClassColumns, true);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--div--; page settings, show_subnavigation , class_subnavigation', '');