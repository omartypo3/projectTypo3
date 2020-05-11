<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('custom_rest', 'Configuration/TypoScript', 'Custom REST extensions');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_customrest_domain_model_person', 'EXT:custom_rest/Resources/Private/Language/locallang_csh_tx_customrest_domain_model_person.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_customrest_domain_model_person');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_customrest_domain_model_email', 'EXT:custom_rest/Resources/Private/Language/locallang_csh_tx_customrest_domain_model_email.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_customrest_domain_model_email');

    }
);
