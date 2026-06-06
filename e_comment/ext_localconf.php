<?php
defined('TYPO3') || die('Access denied.');

use Emagineurs\EComment\Controller\CommentController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$boot = static function (string $packageKey): void {
    $plugins = [
        'Comment' => [
            'cacheable' => ['comment', 'list', 'add', 'search', 'validate'],
            'nonCacheable' => ['comment', 'list', 'add', 'search', 'validate'],
        ],
        'List' => [
            'cacheable' => ['list', 'comment', 'add', 'search', 'validate'],
            'nonCacheable' => ['list', 'comment', 'add', 'search', 'validate'],
        ],
        'Search' => [
            'cacheable' => ['search', 'list', 'comment', 'add', 'validate'],
            'nonCacheable' => ['search', 'list', 'comment', 'add', 'validate'],
        ],
        'Add' => [
            'cacheable' => ['add', 'comment', 'list', 'search', 'validate'],
            'nonCacheable' => ['add', 'comment', 'list', 'search', 'validate'],
        ],
        'Validate' => [
            'cacheable' => ['validate', 'comment', 'list', 'add', 'search'],
            'nonCacheable' => ['validate', 'comment', 'list', 'add', 'search'],
        ],
    ];

    foreach ($plugins as $pluginName => $actions) {
        ExtensionUtility::configurePlugin(
            $packageKey,
            $pluginName,
            [
                CommentController::class => implode(',', $actions['cacheable']),
            ],
            [
                CommentController::class => implode(',', $actions['nonCacheable']),
            ]
        );
    }
};

$boot('EComment');
unset($boot);