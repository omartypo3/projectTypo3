<?php
defined('TYPO3_MODE') || die('Access denied.');
$extKey = "dsl_immo";
$_EXTKEY = "dsl_immo";
call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immoout',
            'Immobilien Ausgabe'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immosearch',
            'Immobilien Suche'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immobookmark',
            'Immobilien Merkliste'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immohighlights',
            'Immobilien Highlights'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immolatest',
            'Immobilien Latest'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immobrowselinks',
            'Immobilien Browselinks'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immodetail',
            'Immobilien Detail'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DslFactory.DslImmo',
            'Immoselected',
            'Immobilien Selektion'
        );

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'DslFactory.DslImmo',
                'web', // Make module a submodule of 'web'
                'immobe', // Submodule key
                '', // Position
                [
                    \DslFactory\DslImmo\Controller\ImmobilieController::class => 'belist, edit, update, create, new, delete, togglehighlight, beshow',
                    \DslFactory\DslImmo\Controller\ImportController::class => 'list, import, delete'
                ],
                [
                    'access' => 'user,group',
					'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_immobe.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_immobe.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'immo');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslimmo_domain_model_immobilie', 'EXT:dsl_immo/Resources/Private/Language/locallang_csh_tx_dslimmo_domain_model_immobilie.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslimmo_domain_model_immobilie');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslimmo_domain_model_import', 'EXT:dsl_immo/Resources/Private/Language/locallang_csh_tx_dslimmo_domain_model_import.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslimmo_domain_model_import');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslimmo_domain_model_anhang', 'EXT:dsl_immo/Resources/Private/Language/locallang_csh_tx_dslimmo_domain_model_anhang.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslimmo_domain_model_anhang');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dslimmo_domain_model_kontaktperson', 'EXT:dsl_immo/Resources/Private/Language/locallang_csh_tx_dslimmo_domain_model_kontaktperson.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dslimmo_domain_model_kontaktperson');

    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(['Immobiliensuche', 'dslimmo_immosearch'], 'CType');


$GLOBALS['TBE_STYLES']['skins'][$_EXTKEY] = array (
  'name' => $_EXTKEY,
  'stylesheetDirectories' => array(
    'css' => 'EXT:' . $_EXTKEY . '/Resources/Public/css/typo3_backend/'
  )
);