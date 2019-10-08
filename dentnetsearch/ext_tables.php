<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DentNetSearch.Dentnetsearch',
            'Dentnetsearch',
            'DentNetSearch'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('dentnetsearch', 'Configuration/TypoScript', 'DentNetSearch');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dentnetsearch_domain_model_dentist', 'EXT:dentnetsearch/Resources/Private/Language/locallang_csh_tx_dentnetsearch_domain_model_dentist.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dentnetsearch_domain_model_dentist');

    }
);
