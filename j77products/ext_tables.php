<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'J77.J77products',
            'Maschine',
            'Maschine',
            'EXT:j77products/Resources/Public/Icons/user_plugin_maschine.svg'
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'J77.J77products',
            'Prozessanlage',
            'Prozessanlage',
            'EXT:j77products/Resources/Public/Icons/user_plugin_prozessanlage.svg'
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'J77.J77products',
            'Slider',
            'Slider',
            'EXT:j77products/Resources/Public/Icons/slider.svg'
        );
     
        
        

        $pluginSignature = str_replace('_', '', 'j77products') . '_maschine';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:j77products/Configuration/FlexForms/flexform_maschine.xml');

        $pluginSignature = str_replace('_', '', 'j77products') . '_prozessanlage';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:j77products/Configuration/FlexForms/flexform_prozessanlage.xml');

        $pluginSignature = str_replace('_', '', 'j77products') . '_slider';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:j77products/Configuration/FlexForms/flexform_slider.xml');
       
        

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('j77products', 'Configuration/TypoScript', 'Produkte');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_maschine', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_maschine.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_maschine');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_maschinenelemente', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_maschinenelemente.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_maschinenelemente');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_download', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_download.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_download');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_icon', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_icon.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_icon');
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_category', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_icon.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_category');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_weitereanforderungen', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_weitereanforderungen.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_weitereanforderungen');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_prozessanlage', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_prozessanlage.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_prozessanlage');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_j77products_domain_model_anlagenelemente', 'EXT:j77products/Resources/Private/Language/locallang_csh_tx_j77products_domain_model_anlagenelemente.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_j77products_domain_model_anlagenelemente');

 
    }
);
