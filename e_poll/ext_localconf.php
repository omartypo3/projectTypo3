<?php
defined('TYPO3') || die('Access denied.');

// Poll Single Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'EPoll',
    'PollSingle',
    [
        \Emagineurs\EPoll\Controller\PollController::class => 'show,vote,result',
    ],
    [
        \Emagineurs\EPoll\Controller\PollController::class => 'vote,result',
    ]
);

// Poll List Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'EPoll',
    'PollList',
    [
        \Emagineurs\EPoll\Controller\PollController::class => 'list,vote,result',
    ],
    [
        \Emagineurs\EPoll\Controller\PollController::class => 'vote,result',
    ]
);

// Poll Result Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'EPoll',
    'PollResult',
    [
        \Emagineurs\EPoll\Controller\PollController::class => 'result',
    ],
    [
        \Emagineurs\EPoll\Controller\PollController::class => '',
    ]
);