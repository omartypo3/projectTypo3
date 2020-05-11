<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
call_user_func(
    function () {
        // My Plugin
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Cundd.CustomRest',
            'customRest',
            [
                'Person' => 'create',
                'Content' => 'content,show',
                'Menu' => 'menu',
                'News' => 'show,voteslike,send',
                'Dce' => 'dce,likes,dislikes',
                'Reporter' => 'create',
                'Email' => 'create',
            ],
            [
                'Person' => '',
                'Reporter' => ''
            ]
        );
    }
);