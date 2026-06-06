<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ='dsl_autologout';
$extKey ='dsl_autologout';

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslAutologout',
            'Felogincheck',
            'FrontendLoginCheck'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Logout Checker');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslautologout_domain_model_checker', 'EXT:dsl_autologout/Resources/Private/Language/locallang_csh_tx_dslautologout_domain_model_checker.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslautologout_domain_model_checker');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder