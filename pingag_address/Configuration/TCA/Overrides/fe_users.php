<?php


$tempColumns = [
    'addressid' => [
        'exclude' => true,
        'label' => 'tt_address ID',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
            'readOnly' => true,
        ],
        //'disabled' => true // This will disable the field
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'addressid', '', 'after:lastlogin');


