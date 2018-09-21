<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'EventMaps.PkEventmaps',
            'Pkeventmap',
            [
                'Event' => 'list'
            ],
            // non-cacheable actions
            [
                'Event' => 'list'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					pkeventmap {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_pkeventmap.svg
						title = LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pk_eventmaps_domain_model_pkeventmap
						description = LLL:EXT:pk_eventmaps/Resources/Private/Language/locallang_db.xlf:tx_pk_eventmaps_domain_model_pkeventmap.description
						tt_content_defValues {
							CType = list
							list_type = pkeventmaps_pkeventmap
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
