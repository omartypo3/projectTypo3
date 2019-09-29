<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Silcoplastproduct.SilcoplastProduct',
            'Silcoplastproduct',
            [
                'Product' => 'list, show, new, create, edit, update, delete, slider',
                'Categoryproduct' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Product' => 'create, update, delete',
                'Categoryproduct' => 'create, update, delete'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    silcoplastproduct {
                        iconIdentifier = silcoplast_product-plugin-silcoplastproduct
                        title = LLL:EXT:silcoplast_product/Resources/Private/Language/locallang_db.xlf:tx_silcoplast_product_silcoplastproduct.name
                        description = LLL:EXT:silcoplast_product/Resources/Private/Language/locallang_db.xlf:tx_silcoplast_product_silcoplastproduct.description
                        tt_content_defValues {
                            CType = list
                            list_type = silcoplastproduct_silcoplastproduct
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'silcoplast_product-plugin-silcoplastproduct',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:silcoplast_product/Resources/Public/Icons/user_plugin_silcoplastproduct.svg']
			);
		
    }
);
