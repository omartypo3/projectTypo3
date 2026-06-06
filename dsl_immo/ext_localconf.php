<?php
defined('TYPO3') || die('Access denied.');
$extKey = "dsl_immo";
$_EXTKEY = "dsl_immo";
call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immoout',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'list, show, ajax'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'list, ajax'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immosearch',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'search'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'search'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immobookmark',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'bookmarks, bookmarksfull'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'bookmarks, bookmarksfull'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immohighlights',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listhighlights'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listhighlights'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immolatest',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listlatest'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listlatest'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immobrowselinks',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'browselinks'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'browselinks'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immodetail',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'detail'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'create, update, delete, ',
                \DslFactory\DslImmo\Controller\ImportController::class => 'delete, '
            ]
        );
		
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslImmo',
            'Immoselected',
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listselected'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslImmo\Controller\ImmobilieController::class => 'listselected'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					immoout {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immoout.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immoout
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immoout.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immoout
						}
					}
					immosearch {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immosearch.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immosearch
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immosearch.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immosearch
						}
					}
					immobookmark {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immobookmark.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immobookmark
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immobookmark.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immobookmark
						}
					}
					immohighlights {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immohighlights.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immohighlights
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immohighlights.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immohighlights
						}
					}
					immolatest {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immolatest.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immolatest
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immolatest.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immolatest
						}
					}
					immobrowselinks {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immobrowselinks.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immobrowselinks
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immobrowselinks.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immobrowselinks
						}
					}
					immodetail {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immodetail.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immodetail
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immodetail.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immodetail
						}
					}
					immoselected {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_immohighlights.svg
						title = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immoselected
						description = LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dsl_immo_domain_model_immoselected.description
						tt_content_defValues {
							CType = list
							list_type = dslimmo_immoselected
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    $_EXTKEY
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DslFactory\\DslImmo\\Task\\WartungTask'] = array(
   'extension' => $_EXTKEY,
   'title' => 'Immobilien WartungTask',
   'description' => 'Ausführen evtl. anstehender Wartungsarbeiten an den Immobilien.',
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/TypoScript/pageTSConfig.ts">');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/TypoScript/sitemap.ts">');
if (TYPO3 === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$_EXTKEY."_OpenImmo"] =
        \DslFactory\DslImmo\Command\ImportCommandController::class;
	
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$_EXTKEY."_Ivm"] =
        \DslFactory\DslImmo\Command\ImportIvmCommandController::class;
	/*$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$_EXTKEY] =
        \DslFactory\DslImmo\Command\ImportCommandController::class;*/
}



$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DslFactory\\DslImmo\\Task\\GenerateLinksTask'] = array(
   'extension' => $_EXTKEY,
   'title' => 'Dsl Immo Link Generierung Task',
   'description' => 'Erstellen von Links den Immobilienangeboten',
);