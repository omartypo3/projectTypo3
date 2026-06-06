<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ='dsl_kanban';
$extKey ='dsl_kanban';
call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Kanban');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslkanban_domain_model_kanban', 'EXT:dsl_kanban/Resources/Private/Language/locallang_csh_tx_dslkanban_domain_model_kanban.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslkanban_domain_model_kanban');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslkanban_domain_model_item', 'EXT:dsl_kanban/Resources/Private/Language/locallang_csh_tx_dslkanban_domain_model_item.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslkanban_domain_model_item');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslkanban_domain_model_board', 'EXT:dsl_kanban/Resources/Private/Language/locallang_csh_tx_dslkanban_domain_model_board.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslkanban_domain_model_board');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder