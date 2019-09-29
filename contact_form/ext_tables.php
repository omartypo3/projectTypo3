<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'LeadGeneration.ContactForm',
            'Fecontactform',
            'Lead Generation contact form'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'LeadGeneration.ContactForm',
            'Feevents',
            'Lead Generation Backend manager'
        );

        $pluginSignature = str_replace('_', '', 'contactform') . '_fecontactform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:contact_form/Configuration/FlexForms/flexform_fecontactform.xml');

        $pluginSignature = str_replace('_', '', 'contactform') . '_feevents';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:contact_form/Configuration/FlexForms/flexform_feevents.xml');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('contact_form', 'Configuration/TypoScript', 'Lead Generation contact form');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_contactform_domain_model_event', 'EXT:contact_form/Resources/Private/Language/locallang_csh_tx_contactform_domain_model_event.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_contactform_domain_model_event');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_contactform_domain_model_participant', 'EXT:contact_form/Resources/Private/Language/locallang_csh_tx_contactform_domain_model_participant.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_contactform_domain_model_participant');

    }
);
