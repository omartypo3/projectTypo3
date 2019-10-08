<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DentNetSearch.Dentnetsearch',
            'Dentnetsearch',
            [
                'Dentist' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Dentist' => 'create, update, delete'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    dentnetsearch {
                        iconIdentifier = dentnetsearch-plugin-dentnetsearch
                        title = LLL:EXT:dentnetsearch/Resources/Private/Language/locallang_db.xlf:tx_dentnetsearch_dentnetsearch.name
                        description = LLL:EXT:dentnetsearch/Resources/Private/Language/locallang_db.xlf:tx_dentnetsearch_dentnetsearch.description
                        tt_content_defValues {
                            CType = list
                            list_type = dentnetsearch_dentnetsearch
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'dentnetsearch-plugin-dentnetsearch',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:dentnetsearch/Resources/Public/Icons/user_plugin_dentnetsearch.svg']
			);
		
    }
);
