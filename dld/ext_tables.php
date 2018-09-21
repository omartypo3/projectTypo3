<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DLD.Dld',
            'Dldfront',
            'DLDfront'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DLD.Dld',
            'Dldflickr',
            'Dldflickr'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DLD.Dld',
            'Dldyoutube',
            'Dldyoutube'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DLD.Dld',
            'Dldevent',
            'Dldevent'
        );

        $pluginSignature = str_replace('_', '', $extKey) . '_dldfront';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_dldfront.xml');

        $pluginSignature2 = str_replace('_', '', $extKey) . '_dldevent';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature2] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature2, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_dldEvent.xml');

        $pluginSignature3 = str_replace('_', '', $extKey) . '_dldyoutube';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature3] = 'pi_flexform';
//        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature3, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_dldyoutube.xml');
        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'DLD.Dld',
                'web', // Make module a submodule of 'web'
                'dldback', // Submodule key
                '', // Position
                [
                    'Dashboard' => 'home','Event' => 'list, show, new, create, edit, update, delete','People' => 'list, show, new, create, edit, update, delete','Session' => 'list, show, new, create, edit, update, delete','Venue' => 'list, show, new, create, edit, update, delete','Partner' => 'list, show, new, create, edit, update, delete','Setting' => 'list, show, new, create, edit, update, delete','SessionPeople' => 'list, show, new, create, edit, update, delete',
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/logo.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_dldback.xlf',
                    'navigationComponentId' => '',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'DLD Conference');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_event', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_event.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_event');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_session', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_session.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_session');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_venue', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_venue.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_venue');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_partner', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_partner.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_partner');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_setting', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_setting.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_setting');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_sessionpeople', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_sessionpeople.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_sessionpeople');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_eventpartner', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_eventpartner.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_eventpartner');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dld_domain_model_eventticket', 'EXT:dld/Resources/Private/Language/locallang_csh_tx_dld_domain_model_eventticket.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dld_domain_model_eventticket');

    },
    $_EXTKEY
);
