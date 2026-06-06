<?php
defined('TYPO3_MODE') || die('Access denied.');
$_EXTKEY ="dsl_jobs";
$extKey ="dsl_jobs";
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['AOE\\Crawler\\Controller\\CrawlerController'] = array(
    'className' => 'DslFactory\\DslJobs\\Controller\\CrawlerController'
);
call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslJobs',
            'Jobs',
            [
                \DslFactory\DslJobs\Controller\JobsController::class => 'list'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslJobs\Controller\JobsController::class => ''
            ]
        );

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslJobs',
            'JobsBrumby',
            [
                \DslFactory\DslJobs\Controller\JobsController::class => 'listBrumby'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslJobs\Controller\JobsController::class => ''
            ]
        );

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DslFactory.DslJobs',
            'JobsCrimmitschau',
            [
                \DslFactory\DslJobs\Controller\JobsController::class => 'listCrimmitschau'
            ],
            // non-cacheable actions
            [
                \DslFactory\DslJobs\Controller\JobsController::class => ''
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					jobs {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Resources/Public/Icons/user_plugin_jobs.svg
						title = LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsl_jobs_domain_model_jobs
						description = LLL:EXT:dsl_jobs/Resources/Private/Language/locallang_db.xlf:tx_dsl_jobs_domain_model_jobs.description
						tt_content_defValues {
							CType = list
							list_type = dsljobs_jobs
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



$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DslFactory\\DslJobs\\Task\\ImportTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'Dsl Jobs ImportTask',
	'description' => 'Ausführen evtl. anstehender Importe',
 );