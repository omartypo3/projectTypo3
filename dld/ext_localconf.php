<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DLD.Dld',
            'Dldfront',
            [
                'Event' => 'list, events, pastEvents, show, mainSlider, new, create, edit, update, delete, eventsMightLike, invited, nextUpcomingEvent',
                'People' => 'list, show, new, create, edit, update, delete, allspeakers, speakerfilter, clearFilter',
                'Session' => 'list, program, show, new, create, edit, update, delete',
                'Venue' => 'list, show, new, create, edit, update, delete',
                'Partner' => 'list, show, new, create, edit, update, delete',
                'Setting' => 'list, show, new, create, edit, update, delete',
                'SessionPeople' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Event' => 'create, update, delete,nextUpcomingEvent',
                'People' => 'create, update, delete, allspeakers',
                'Session' => 'create, update, delete',
                'Venue' => 'create, update, delete',
                'Partner' => 'create, update, delete',
                'Setting' => 'create, update, delete',
                'SessionPeople' => 'create, update, delete'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DLD.Dld',
            'Dldflickr',
            [
                'Event' => 'flickrAllAlbums',
            ],
            // non-cacheable actions
            [
                'Event' => 'flickrAllAlbums',
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DLD.Dld',
            'Dldyoutube',
            [
                'Event' => 'youtubeAllVideos',
            ],
            // non-cacheable actions
            [
                'Event' => 'youtubeAllVideos',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DLD.Dld',
            'Dldevent',
            [
                'Event' => 'header, description, twitter, map, speakers, program, partners, eventsMightLike, gallery, buyTicket',
            ],
            // non-cacheable actions
            [
                'Event' => 'header, description, twitter, map, speakers, program, partners, eventsMightLike, gallery, buyTicket',
            ]
        );

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'tx-iconmaschine',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:theme/Resources/Public/logos/apple-touch.png']
        );
        // wizards
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('DLD\\Dld\\Property\\TypeConverter\\UploadedFileReferenceConverter');
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('DLD\\Dld\\Property\\TypeConverter\\ObjectStorageConverter');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					Dldyoutube {
						iconIdentifier = tx-iconmaschine
						title = DLD Youtube
						description = Youtube videos
						tt_content_defValues {
							CType = list
							list_type = dld_dldyoutube
						}
					}
					dldfront {
						iconIdentifier = tx-iconmaschine
						title = LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_dldfront
						description = LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_dldfront.description
						tt_content_defValues {
							CType = list
							list_type = dld_dldfront
						}
					}
					dldevent {
						iconIdentifier = tx-iconmaschine
						title = LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_dldevent
						description = LLL:EXT:dld/Resources/Private/Language/locallang_db.xlf:tx_dld_domain_model_dldevent.description
						tt_content_defValues {
							CType = list
							list_type = dld_dldevent
						}
					}
				}
				show = *
			}
	     }'
        );
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$extKey] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . 'Classes/Hooks/PageLayoutView.php:DLD\dld\Hooks\PageLayoutView';
    },
    $_EXTKEY
);
