<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Mitarbeiterliste',
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'list, show, new, create, edit, update, delete, avatar'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'list, show, new, create, edit, update, delete, avatar'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenliste',
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'list, show, new, create, edit, update, delete, ajax, import, access',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'agenturauftraegelist'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'list, show, new, create, edit, update, delete, ajax, import, access',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'agenturauftraegelist'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Auftragsliste',
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'list, show, new, create, edit, update, delete, ajax, import, upload, editStatusChange',
            \DslFactory\DslIntranet\Controller\ZeiteintraegeController::class => 'create, new, ajax, edit, update',
            \DslFactory\DslIntranet\Controller\ProtokolleController::class => 'create, new, ajax, edit, update',
            \DslFactory\DslIntranet\Controller\WartungsvertraegeController::class => 'delete, editZeiteintrag, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => '\'list, show, new, create, edit, update, delete, ajax, import, upload, editStatusChange',
            \DslFactory\DslIntranet\Controller\ZeiteintraegeController::class => 'create, new, ajax, edit, update',
            \DslFactory\DslIntranet\Controller\ProtokolleController::class => 'create, new, ajax, edit, update',
            \DslFactory\DslIntranet\Controller\WartungsvertraegeController::class => 'delete, editZeiteintrag, ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Statistik',
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'statistik, ajax',
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'statistik, ajax',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Wochenlisteaufgabenplatzierung',
        [
            \DslFactory\DslIntranet\Controller\AufgabenController::class => 'list, show, new, create, edit, update, delete, ajax, listjson, ical',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'show'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AufgabenController::class => 'list, show, new, create, edit, update, delete, ajax, listjson, ical',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'show'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Urlaubsliste',
        [
            \DslFactory\DslIntranet\Controller\UrlaubController::class => 'list, show, new, create, edit, update, delete, ajax, listjson, refuse, accept, import'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\UrlaubController::class => 'list, show, new, create, edit, update, delete, ajax, listjson, refuse, accept, import'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Hostingliste',
        [
            \DslFactory\DslIntranet\Controller\HostingController::class => 'list, new, create, edit, update, ajax, import, delete, editDomain, show'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\HostingController::class => 'list, new, create, edit, update, ajax, import, delete, editDomain, show'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenlogin',
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'kundenlist, kundenshow, kundenajax, kundenupload',
            \DslFactory\DslIntranet\Controller\ProtokolleController::class => 'kundennew, kundenajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'kundenlist, kundenshow, kundenajax, kundenupload',
            \DslFactory\DslIntranet\Controller\ProtokolleController::class => 'kundennew, kundenajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Maintenance',
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'maintenance'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'maintenance'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Wartungsliste',
        [
            \DslFactory\DslIntranet\Controller\WartungsvertraegeController::class => 'list, new, create, edit, update, ajax, import, delete, show, newZeiteintrag, editZeiteintrag'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\WartungsvertraegeController::class => 'list, new, create, edit, update, ajax, import, delete, show, newZeiteintrag, editZeiteintrag'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Avatar',
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'avatar'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'avatar'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenhome',
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'kundenhome'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'kundenhome'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Downloadcenter',
        [
            \DslFactory\DslIntranet\Controller\DateienController::class => 'list, new, create, edit, update, ajax, checkFile',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\DateienController::class => 'list, new, create, edit, update, ajax, checkFile',
            \DslFactory\DslIntranet\Controller\AuftraegeController::class => 'ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Notificationcenter',
        [
            \DslFactory\DslIntranet\Controller\NotificationController::class => 'list, delete, show, readall'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\NotificationController::class => 'list, delete, show, readall'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Agenturvertragsliste',
        [
            \DslFactory\DslIntranet\Controller\AgenturvertraegeController::class => 'list, show, new, create, edit, update, delete, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AgenturvertraegeController::class => 'list, show, new, create, edit, update, delete, ajax'
        ]
    );
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Projektliste',
        [
           \DslFactory\DslIntranet\Controller\ProjekteController::class => 'list, show, new, create, edit, update, delete, ajax'
        ],
        // non-cacheable actions
        [
           \DslFactory\DslIntranet\Controller\ProjekteController::class => 'list, show, new, create, edit, update, delete, ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Icalaufgaben',
        [
            \DslFactory\DslIntranet\Controller\AufgabenController::class => 'ical'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AufgabenController::class => 'ical'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenagenturvertraege',
        [
            \DslFactory\DslIntranet\Controller\KundenAgenturvertraegeController::class => 'list, show, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenAgenturvertraegeController::class => 'list, show, ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Benutzeravatar',
        [
            \DslFactory\DslIntranet\Controller\BenutzerController::class => 'avatar'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\BenutzerController::class => 'avatar'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundendateien',
        [
            \DslFactory\DslIntranet\Controller\KundenDateienController::class => 'list, listrechnungen, ajax, listAuftragRechnungen, listAuftragAngebote'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenDateienController::class => 'list, listrechnungen, ajax, listAuftragRechnungen, listAuftragAngebote'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenenvironment',
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'environment'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'environment'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Ablage',
        [
            \DslFactory\DslIntranet\Controller\AblageController::class => 'list, new, create, edit, update, delete, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\AblageController::class => 'list, new, create, edit, update, delete, ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Autologin',
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'autologin'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenController::class => 'autologin'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kanban',
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'kanban,ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'kanban,ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'News',
        [
            \DslFactory\DslIntranet\Controller\NewsController::class => 'list, new, create, edit, update, show, delete, toggleSichtbarkeit, toggleCountdown'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\NewsController::class => 'list, new, create, edit, update, show, delete, toggleSichtbarkeit, toggleCountdown'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundennews',
        [
            \DslFactory\DslIntranet\Controller\KundenNewsController::class => 'list, show'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenNewsController::class => 'list, show'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Mitarbeiter',
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'settings'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\MitarbeiterController::class => 'settings'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Splitpaneprojekte',
        [
            \DslFactory\DslIntranet\Controller\SplitpaneController::class => 'projekte,ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\SplitpaneController::class => 'projekte,ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Kundenstammdaten',
        [
            \DslFactory\DslIntranet\Controller\KundenStammdatenController::class => 'list, settings, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\KundenStammdatenController::class => 'list, settings, ajax'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DslIntranet',
        'Protokollependingmailer',
        [
            \DslFactory\DslIntranet\Controller\ProtokollePendingController::class => 'list, edit, update, delete, ajax'
        ],
        // non-cacheable actions
        [
            \DslFactory\DslIntranet\Controller\ProtokollePendingController::class => 'list, edit, update, delete, ajax'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    mitarbeiterliste {
                        iconIdentifier = dsl_intranet-plugin-mitarbeiterliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_mitarbeiterliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_mitarbeiterliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_mitarbeiterliste
                        }
                    }
                    kundenliste {
                        iconIdentifier = dsl_intranet-plugin-kundenliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenliste
                        }
                    }
                    auftragsliste {
                        iconIdentifier = dsl_intranet-plugin-auftragsliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_auftragsliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_auftragsliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_auftragsliste
                        }
                    }
                    statistik {
                        iconIdentifier = dsl_intranet-plugin-statistik
						title = Statistik
						description = Effektivitäts Diagramm der Mitarbeiter
						tt_content_defValues {
							CType = list
							list_type = dslintranet_statistik
						}
					}
                    wochenlisteaufgabenplatzierung {
                        iconIdentifier = dsl_intranet-plugin-wochenlisteaufgabenplatzierung
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_wochenlisteaufgabenplatzierung.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_wochenlisteaufgabenplatzierung.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_wochenlisteaufgabenplatzierung
                        }
                    }
                    urlaubsliste {
                        iconIdentifier = dsl_intranet-plugin-urlaubsliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_urlaubsliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_urlaubsliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_urlaubsliste
                        }
                    }
                    hostingliste {
                        iconIdentifier = dsl_intranet-plugin-hostingliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_hostingliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_hostingliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_hostingliste
                        }
                    }
                    kundenlogin {
                        iconIdentifier = dsl_intranet-plugin-kundenlogin
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenlogin.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenlogin.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenlogin
                        }
                    }
                    maintenance {
                        iconIdentifier = dsl_intranet-plugin-maintenance
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_maintenance.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_maintenance.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_maintenance
                        }
                    }
                    wartungsliste {
                        iconIdentifier = dsl_intranet-plugin-wartungsliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_wartungsliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_wartungsliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_wartungsliste
                        }
                    }
                    avatar {
                        iconIdentifier = dsl_intranet-plugin-avatar
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_avatar.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_avatar.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_avatar
                        }
                    }
                    kundenhome {
                        iconIdentifier = dsl_intranet-plugin-kundenhome
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenhome.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenhome.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenhome
                        }
                    }
                    downloadcenter {
                        iconIdentifier = dsl_intranet-plugin-downloadcenter
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_downloadcenter.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_downloadcenter.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_downloadcenter
                        }
                    }
                    notificationcenter {
                        iconIdentifier = dsl_intranet-plugin-notificationcenter
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_notificationcenter.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_notificationcenter.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_notificationcenter
                        }
                    }
                    agenturvertragsliste {
                        iconIdentifier = dsl_intranet-plugin-agenturvertragsliste
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_agenturvertragsliste.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_agenturvertragsliste.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_agenturvertragsliste
                        }
                    }
					projektliste {
						iconIdentifier = dsl_intranet-plugin-projektliste
						title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_domain_model_projektliste
						description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_domain_model_projektliste.description
						tt_content_defValues {
							CType = list
							list_type = dslintranet_agenturvertragsliste
						}
					}
                    icalaufgaben {
                        iconIdentifier = dsl_intranet-plugin-icalaufgaben
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_icalaufgaben.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_icalaufgaben.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_icalaufgaben
                        }
                    }
                    kundenagenturvertraege {
                        iconIdentifier = dsl_intranet-plugin-kundenagenturvertraege
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenagenturvertraege.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenagenturvertraege.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenagenturvertraege
                        }
                    }
                    benutzeravatar {
                        iconIdentifier = dsl_intranet-plugin-benutzeravatar
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_benutzeravatar.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_benutzeravatar.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_benutzeravatar
                        }
                    }
                    kundendateien {
                        iconIdentifier = dsl_intranet-plugin-kundendateien
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundendateien.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundendateien.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundendateien
                        }
                    }
                    kundenenvironment {
                        iconIdentifier = dsl_intranet-plugin-kundenenvironment
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenenvironment.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenenvironment.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenenvironment
                        }
                    }
                    ablage {
                        iconIdentifier = dsl_intranet-plugin-ablage
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_ablage.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_ablage.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_ablage
                        }
                    }
                    autologin {
                        iconIdentifier = dsl_intranet-plugin-autologin
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_autologin.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_autologin.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_autologin
                        }
                    }
                    news {
                        iconIdentifier = dsl_intranet-plugin-news
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_news.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_news.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_news
                        }
                    }
                    kundennews {
                        iconIdentifier = dsl_intranet-plugin-kundennews
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundennews.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundennews.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundennews
                        }
                    }
                    mitarbeiter {
                        iconIdentifier = dsl_intranet-plugin-mitarbeiter
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_mitarbeiter.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_mitarbeiter.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_mitarbeiter
                        }
                    }
                    splitpaneprojekte {
                        iconIdentifier = dsl_intranet-plugin-splitpaneprojekte
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_splitpaneprojekte.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_splitpaneprojekte.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_splitpaneprojekte
                        }
                    }
                    kundenstammdaten {
                        iconIdentifier = dsl_intranet-plugin-kundenstammdaten
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenstammdaten.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_kundenstammdaten.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_kundenstammdaten
                        }
                    }
                    protokollependingmailer {
                        iconIdentifier = dsl_intranet-plugin-protokollependingmailer
                        title = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_protokollependingmailer.name
                        description = LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dsl_intranet_protokollependingmailer.description
                        tt_content_defValues {
                            CType = list
                            list_type = dslintranet_protokollependingmailer
                        }
                    }
                    kanban {
						iconIdentifier = dsl_intranet-plugin-kanban
						title = Kanban
						description = Kanban Board Aufgabenplanung
						tt_content_defValues {
							CType = list
							list_type = dslintranet_kanban
						}
					}
                }
                show = *
            }
       }'
    );
})();

