<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ='dsl_iconfont';
$extKey ='dsl_iconfont';
call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'dsl Iconfont');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder