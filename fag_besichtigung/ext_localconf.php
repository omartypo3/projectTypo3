<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FRONTAL.FagBesichtigung',
            'Besichtigung',
            [
                'Event' => 'list, show, new, create, edit, update, delete , anfrage, button ,export',
                'Datum' => 'list, show, new, create, edit, update, delete',
                'Anfrage' => 'list, show, new, create, edit, update, delete',
                'Gruppentyp' => 'list, show, new, create, edit, update, delete',
                'Zahlung' => 'list, show, new, create, edit, update, delete',
                'GruppenFuhrer' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Event' => 'create, update, delete , anfrage, button ,export',
                'Datum' => 'create, update, delete',
                'Anfrage' => 'create, update, delete',
                'Gruppentyp' => 'create, update, delete',
                'Zahlung' => 'create, update, delete',
                'GruppenFuhrer' => 'create, update, delete'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    besichtigung {
                        iconIdentifier = fag_besichtigung-plugin-besichtigung
                        title = LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fag_besichtigung_besichtigung.name
                        description = LLL:EXT:fag_besichtigung/Resources/Private/Language/locallang_db.xlf:tx_fag_besichtigung_besichtigung.description
                        tt_content_defValues {
                            CType = list
                            list_type = fagbesichtigung_besichtigung
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'fag_besichtigung-plugin-besichtigung',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:fag_besichtigung/Resources/Public/Icons/user_plugin_besichtigung.svg']
			);
		
    }
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'phpexcel',
    'tx_phpexcel_service',
    array (
        'title' => 'PHPExcel for TYPO3',
        'description' => '',
        'subtype' => '',
        'available' => TRUE,
        'priority' => 50,
        'quality' => 50,
        'os' => '',
        'exec' => '',
        'classFile' =>  'typo3conf/ext/fag_besichtigung/Classes/Service/Phpexcel.php',
        'className' => 'FRONTAL\FagBesichtigung\Service\Phpexcel',
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'FRONTAL\\FagBesichtigung\\Command\\sendCommandController';
