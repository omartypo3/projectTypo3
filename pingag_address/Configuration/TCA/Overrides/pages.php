<?php
defined('TYPO3') || die();

$desc = [
    'fieldshidden' => [
        'label' => 'hidden fields of product ',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $desc);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    'fieldshidden',
    '',
    'after:subtitle'
);