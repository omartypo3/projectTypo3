<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'EventMaps.PkEventmaps',
            'Pkeventmap',
            'Event Map'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'EventMaps');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pkeventmaps_domain_model_event', 'EXT:pk_eventmaps/Resources/Private/Language/locallang_csh_tx_pkeventmaps_domain_model_event.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pkeventmaps_domain_model_event');

    },
    $_EXTKEY
);
