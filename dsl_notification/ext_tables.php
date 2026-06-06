<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ='dsl_notification';
$extKey ='dsl_notification';
call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'JavaScript Notifications');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder