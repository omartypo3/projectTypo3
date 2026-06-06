<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ='dsl_autologout';
$extKey ='dsl_autologout';
call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslAutologout',
            'Felogincheck',
            [
                \DslFactory\DslAutologout\Controller\CheckerController::class => 'checkForLogin'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslAutologout\Controller\CheckerController::class => 'checkForLogin'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					felogincheck {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_felogincheck.svg
						title = LLL:EXT:dsl_autologout/Resources/Private/Language/locallang_db.xlf:tx_dsl_autologout_domain_model_felogincheck
						description = LLL:EXT:dsl_autologout/Resources/Private/Language/locallang_db.xlf:tx_dsl_autologout_domain_model_felogincheck.description
						tt_content_defValues {
							CType = list
							list_type = dslautologout_felogincheck
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