<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'FRONTAL.FagBesichtigung',
            'Besichtigung',
            'besichtigung_fe'
        );

        $pluginSignature = str_replace('_', '', 'fag_besichtigung') . '_besichtigung';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:fag_besichtigung/Configuration/FlexForms/flexform_besichtigung.xml');


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fag_besichtigung', 'Configuration/TypoScript', 'besichtigung');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_event', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_event.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_event');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_datum', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_datum.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_datum');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_anfrage', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_anfrage.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_anfrage');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_gruppentyp', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_gruppentyp.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_gruppentyp');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_zahlung', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_zahlung.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_zahlung');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fagbesichtigung_domain_model_gruppenfuhrer', 'EXT:fag_besichtigung/Resources/Private/Language/locallang_csh_tx_fagbesichtigung_domain_model_gruppenfuhrer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fagbesichtigung_domain_model_gruppenfuhrer');

    }
);
