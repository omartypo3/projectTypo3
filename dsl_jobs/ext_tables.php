<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ="dsl_jobs";
$extKey ="dsl_jobs";
call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslJobs',
            'Jobs',
            'Jobs'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Jobs');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dsljobs_domain_model_jobs', 'EXT:dsl_jobs/Resources/Private/Language/locallang_csh_tx_dsljobs_domain_model_jobs.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dsljobs_domain_model_jobs');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dsljobs_domain_model_jobsite', 'EXT:dsl_jobs/Resources/Private/Language/locallang_csh_tx_dsljobs_domain_model_jobsite.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dsljobs_domain_model_jobsite');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dsljobs_domain_model_joblevel', 'EXT:dsl_jobs/Resources/Private/Language/locallang_csh_tx_dsljobs_domain_model_joblevel.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dsljobs_domain_model_joblevel');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder