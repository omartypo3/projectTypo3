<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'LeadGeneration.ContactForm',
            'Fecontactform',
            [
                'Participant' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Participant' => 'create'
            ]
        );
        \FluidTYPO3\Flux\Core::registerProviderExtensionKey('contact_form', 'Page');

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'LeadGeneration.ContactForm',
            'Feevents',
            [
                'Event' => 'list, show, new, create, edit, update, delete, export',
                'Participant' => 'list, show, new, create, edit, update, delete',
                 'User' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Event' => 'create, update, delete',
                'Participant' => 'create, update, delete'
            ]
        );


    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    fecontactform {
                        iconIdentifier = contact_form-plugin-fecontactform
                        title = LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contact_form_fecontactform.name
                        description = LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contact_form_fecontactform.description
                        tt_content_defValues {
                            CType = list
                            list_type = contactform_fecontactform
                        }
                    }
                    feevents {
                        iconIdentifier = contact_form-plugin-feevents
                        title = LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contact_form_feevents.name
                        description = LLL:EXT:contact_form/Resources/Private/Language/locallang_db.xlf:tx_contact_form_feevents.description
                        tt_content_defValues {
                            CType = list
                            list_type = contactform_feevents
                        }
                    } 
                }
                show = *
            }
       }'
    );

		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

			$iconRegistry->registerIcon(
				'contact_form-plugin-fecontactform',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:contact_form/Resources/Public/Icons/user_plugin_fecontactform.svg']
			);

			$iconRegistry->registerIcon(
				'contact_form-plugin-feevents',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:contact_form/Resources/Public/Icons/user_plugin_feevents.svg']
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
        'classFile' =>  'typo3conf/ext/contact_form/Classes/Service/Phpexcel.php',
        'className' => 'LeadGeneration\ContactForm\Service\Phpexcel',
    )
);