<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie',
        'label' => 'objekttitel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'objekttitel,dreizeiler,lage,ausstattbeschr,objektbeschreibung,sonstigeangaben,objekt_nrintern,objekt_nrextern,openimmoobid,stand_vom,nutzungs_art,vermarktungs_art,objekt_art_wohnung_typ,geo_plz,geo_ort,geo_strasse,geo_hausnummer,geo_etage,geo_anzahl_etagen,geo_lage_im_bau,geo_lage_gebiet,geo_land,geo_koordinaten_breitengrad,geo_koordinaten_laengengrad,geo_regionaler_zusatz,preise_kaltmiete,preise_warmmiete,preise_nebenkosten,preise_kaution,flaechen_wohnflaeche,flaechen_anzahl_zimmer,flaechen_anzahl_balkone,flaechen_anzahl_terassen,flaechen_anzahl_logia,zustand_baujahr,zustand_art,energiepass_epart,energiepass_energieverbrauchkennwert,energiepass_endenergiebedarf,energiepass_gebaeudeart,objektadresse_freigeben,verfuegbar_ab,vermietet,denkmalgeschuetzt,ausstattung_wggeeignet,ausstattung_raeumeveraenderbar,ausstattung_kamin,ausstattung_klimatisiert,ausstattung_gartennutzung,ausstattung_rollstuhlgerecht,ausstattung_kabelsattv,ausstattung_dvbt,ausstattung_barrierefrei,ausstattung_sauna,ausstattung_swimmingpool,ausstattung_wasch_trockenraum,ausstattung_wintergarten,ausstattung_dvverkabelung,ausstattung_rampe,ausstattung_hebebuehne,ausstattung_kran,ausstattung_gastterrasse,ausstattung_kantinecafeteria,ausstattung_teekueche,ausstattung_brauereibindung,ausstattung_sporteinrichtungen,ausstattung_wellnessbereich,ausstattung_telefonferienimmobilie,ausstattung_umtsempfang,ausstattung_abstellraum,ausstattung_bibliothek,ausstattung_dachboden,ausstattung_gaestewc,ausstattung_kabelkanaele,ausstattung_seniorengerecht,ausstattung_fahrradraum,ausstattung_rolladen,ausstattung_bad,ausstattung_kueche,ausstattung_boden,ausstattung_heizungsart,ausstattung_befeuerung,ausstattung_fahrstuhl,ausstattung_stellplatzart,ausstattung_ausricht_balkon_terasse,ausstattung_angeschl_gastronomie,ausstattung_serviceleistungen,ausstattung_sicherheitstechnik,ausstattung_moebliert,ausstattung_kategorie,ausstattung_dachform,ausstattung_bauweise,ausstattung_ausbaustufe,ausstattung_energietyp,ausstattung_unterkellert,ausstattung_hallenhoehe,ausstattung_stromanschlusswert,energiepass_gueltig_bis,energiepass_mitwarmwasser,energiepass_primaerenergietraeger,energiepass_stromwert,energiepass_waermewert,energiepass_wertklasse,energiepass_ausstelldatum,energiepass_jahrgang,highlight,objekt_art_zimmer_typ,objekt_art_haus_typ,objekt_art_grundstueck_typ,objekt_art_buero_praxen_typ,objekt_art_einzelhandel_typ,objekt_art_gastgewerbe_typ,objekt_art_hallen_lager_produktion_typ,objekt_art_land_forstwirtschaft_typ,objekt_art_parken_typ,objekt_art_sonstige_typ,objekt_art_freizeitimmobilie_gewerblich_typ,objekt_art_zinshaus_renditeobjekt_typ,flaechen_sonstflaeche,flaechen_vermietbare_flaeche,flaechen_anzahl_gewerbeeinheiten,flaechen_nutzflaeche,flaechen_gesamtflaeche,flaechen_bueroflaeche,flaechen_grundstuecksflaeche,flaechen_anzahl_badezimmer,flaechen_anzahl_schlafzimmer,preise_kaufpreis,preise_provisionspflichtig,preise_aussen_courtage,preise_aussen_courtage_mit_mwst,preise_waehrung_iso_waehrung,preise_mwst_satz,preise_mieteinnahmen_ist,preise_stp_freiplatz_anzahl,preise_stp_sonstige_anzahl,preise_stp_sonstige_platzart,search_vermarktung,search_objekt_typ,search_zimmer,search_flaeche,search_preis,search_wohngebiet,geo_adresse_gesperrt_koordinaten_breitengrad,geo_adresse_gesperrt_koordinaten_laengengrad,haustiere,additional_html_field,moderner_grundriss,energie_ausweis_link_extern,anhaenge,importe,kontaktperson,titel_bild',
        'iconfile' => 'EXT:dsl_immo/Resources/Public/Icons/tx_dslimmo_domain_model_immobilie.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, objekttitel, dreizeiler, lage, ausstattbeschr, objektbeschreibung, sonstigeangaben, objekt_nrintern, objekt_nrextern, openimmoobid, stand_vom, nutzungs_art, vermarktungs_art, objekt_art_wohnung_typ, geo_plz, geo_ort, geo_strasse, geo_hausnummer, geo_etage, geo_anzahl_etagen, geo_lage_im_bau, geo_lage_gebiet, geo_land, geo_koordinaten_breitengrad, geo_koordinaten_laengengrad, geo_regionaler_zusatz, preise_kaltmiete, preise_warmmiete, preise_nebenkosten, preise_kaution, flaechen_wohnflaeche, flaechen_anzahl_zimmer, flaechen_anzahl_balkone, flaechen_anzahl_terassen, flaechen_anzahl_logia, zustand_baujahr, zustand_art, energiepass_epart, energiepass_energieverbrauchkennwert, energiepass_endenergiebedarf, energiepass_gebaeudeart, objektadresse_freigeben, verfuegbar_ab, vermietet, denkmalgeschuetzt, ausstattung_wggeeignet, ausstattung_raeumeveraenderbar, ausstattung_kamin, ausstattung_klimatisiert, ausstattung_gartennutzung, ausstattung_rollstuhlgerecht, ausstattung_kabelsattv, ausstattung_dvbt, ausstattung_barrierefrei, ausstattung_sauna, ausstattung_swimmingpool, ausstattung_wasch_trockenraum, ausstattung_wintergarten, ausstattung_dvverkabelung, ausstattung_rampe, ausstattung_hebebuehne, ausstattung_kran, ausstattung_gastterrasse, ausstattung_kantinecafeteria, ausstattung_teekueche, ausstattung_brauereibindung, ausstattung_sporteinrichtungen, ausstattung_wellnessbereich, ausstattung_telefonferienimmobilie, ausstattung_umtsempfang, ausstattung_abstellraum, ausstattung_bibliothek, ausstattung_dachboden, ausstattung_gaestewc, ausstattung_kabelkanaele, ausstattung_seniorengerecht, ausstattung_fahrradraum, ausstattung_rolladen, ausstattung_bad, ausstattung_kueche, ausstattung_boden, ausstattung_heizungsart, ausstattung_befeuerung, ausstattung_fahrstuhl, ausstattung_stellplatzart, ausstattung_ausricht_balkon_terasse, ausstattung_angeschl_gastronomie, ausstattung_serviceleistungen, ausstattung_sicherheitstechnik, ausstattung_moebliert, ausstattung_kategorie, ausstattung_dachform, ausstattung_bauweise, ausstattung_ausbaustufe, ausstattung_energietyp, ausstattung_unterkellert, ausstattung_hallenhoehe, ausstattung_stromanschlusswert, energiepass_gueltig_bis, energiepass_mitwarmwasser, energiepass_primaerenergietraeger, energiepass_stromwert, energiepass_waermewert, energiepass_wertklasse, energiepass_ausstelldatum, energiepass_jahrgang, highlight, objekt_art_zimmer_typ, objekt_art_haus_typ, objekt_art_grundstueck_typ, objekt_art_buero_praxen_typ, objekt_art_einzelhandel_typ, objekt_art_gastgewerbe_typ, objekt_art_hallen_lager_produktion_typ, objekt_art_land_forstwirtschaft_typ, objekt_art_parken_typ, objekt_art_sonstige_typ, objekt_art_freizeitimmobilie_gewerblich_typ, objekt_art_zinshaus_renditeobjekt_typ, flaechen_sonstflaeche, flaechen_vermietbare_flaeche, flaechen_anzahl_gewerbeeinheiten, flaechen_nutzflaeche, flaechen_gesamtflaeche, flaechen_bueroflaeche, flaechen_grundstuecksflaeche, flaechen_anzahl_badezimmer, flaechen_anzahl_schlafzimmer, preise_kaufpreis, preise_provisionspflichtig, preise_aussen_courtage, preise_aussen_courtage_mit_mwst, preise_waehrung_iso_waehrung, preise_mwst_satz, preise_mieteinnahmen_ist, preise_stp_freiplatz_anzahl, preise_stp_sonstige_anzahl, preise_stp_sonstige_platzart, search_vermarktung, search_objekt_typ, search_zimmer, search_flaeche, search_preis, search_wohngebiet, geo_adresse_gesperrt_koordinaten_breitengrad, geo_adresse_gesperrt_koordinaten_laengengrad, haustiere, additional_html_field, moderner_grundriss, energie_ausweis_link_extern, anhaenge, importe, kontaktperson, titel_bild',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, objekttitel, dreizeiler, lage, ausstattbeschr, objektbeschreibung, sonstigeangaben, objekt_nrintern, objekt_nrextern, openimmoobid, stand_vom, nutzungs_art, vermarktungs_art, objekt_art_wohnung_typ, geo_plz, geo_ort, geo_strasse, geo_hausnummer, geo_etage, geo_anzahl_etagen, geo_lage_im_bau, geo_lage_gebiet, geo_land, geo_koordinaten_breitengrad, geo_koordinaten_laengengrad, geo_regionaler_zusatz, preise_kaltmiete, preise_warmmiete, preise_nebenkosten, preise_kaution, flaechen_wohnflaeche, flaechen_anzahl_zimmer, flaechen_anzahl_balkone, flaechen_anzahl_terassen, flaechen_anzahl_logia, zustand_baujahr, zustand_art, energiepass_epart, energiepass_energieverbrauchkennwert, energiepass_endenergiebedarf, energiepass_gebaeudeart, objektadresse_freigeben, verfuegbar_ab, vermietet, denkmalgeschuetzt, ausstattung_wggeeignet, ausstattung_raeumeveraenderbar, ausstattung_kamin, ausstattung_klimatisiert, ausstattung_gartennutzung, ausstattung_rollstuhlgerecht, ausstattung_kabelsattv, ausstattung_dvbt, ausstattung_barrierefrei, ausstattung_sauna, ausstattung_swimmingpool, ausstattung_wasch_trockenraum, ausstattung_wintergarten, ausstattung_dvverkabelung, ausstattung_rampe, ausstattung_hebebuehne, ausstattung_kran, ausstattung_gastterrasse, ausstattung_kantinecafeteria, ausstattung_teekueche, ausstattung_brauereibindung, ausstattung_sporteinrichtungen, ausstattung_wellnessbereich, ausstattung_telefonferienimmobilie, ausstattung_umtsempfang, ausstattung_abstellraum, ausstattung_bibliothek, ausstattung_dachboden, ausstattung_gaestewc, ausstattung_kabelkanaele, ausstattung_seniorengerecht, ausstattung_fahrradraum, ausstattung_rolladen, ausstattung_bad, ausstattung_kueche, ausstattung_boden, ausstattung_heizungsart, ausstattung_befeuerung, ausstattung_fahrstuhl, ausstattung_stellplatzart, ausstattung_ausricht_balkon_terasse, ausstattung_angeschl_gastronomie, ausstattung_serviceleistungen, ausstattung_sicherheitstechnik, ausstattung_moebliert, ausstattung_kategorie, ausstattung_dachform, ausstattung_bauweise, ausstattung_ausbaustufe, ausstattung_energietyp, ausstattung_unterkellert, ausstattung_hallenhoehe, ausstattung_stromanschlusswert, energiepass_gueltig_bis, energiepass_mitwarmwasser, energiepass_primaerenergietraeger, energiepass_stromwert, energiepass_waermewert, energiepass_wertklasse, energiepass_ausstelldatum, energiepass_jahrgang, highlight, objekt_art_zimmer_typ, objekt_art_haus_typ, objekt_art_grundstueck_typ, objekt_art_buero_praxen_typ, objekt_art_einzelhandel_typ, objekt_art_gastgewerbe_typ, objekt_art_hallen_lager_produktion_typ, objekt_art_land_forstwirtschaft_typ, objekt_art_parken_typ, objekt_art_sonstige_typ, objekt_art_freizeitimmobilie_gewerblich_typ, objekt_art_zinshaus_renditeobjekt_typ, flaechen_sonstflaeche, flaechen_vermietbare_flaeche, flaechen_anzahl_gewerbeeinheiten, flaechen_nutzflaeche, flaechen_gesamtflaeche, flaechen_bueroflaeche, flaechen_grundstuecksflaeche, flaechen_anzahl_badezimmer, flaechen_anzahl_schlafzimmer, preise_kaufpreis, preise_provisionspflichtig, preise_aussen_courtage, preise_aussen_courtage_mit_mwst, preise_waehrung_iso_waehrung, preise_mwst_satz, preise_mieteinnahmen_ist, preise_stp_freiplatz_anzahl, preise_stp_sonstige_anzahl, preise_stp_sonstige_platzart, search_vermarktung, search_objekt_typ, search_zimmer, search_flaeche, search_preis, search_wohngebiet, geo_adresse_gesperrt_koordinaten_breitengrad, geo_adresse_gesperrt_koordinaten_laengengrad, haustiere, additional_html_field, moderner_grundriss, energie_ausweis_link_extern, anhaenge, importe, kontaktperson, titel_bild, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_dslimmo_domain_model_immobilie',
                'foreign_table_where' => 'AND tx_dslimmo_domain_model_immobilie.pid=###CURRENT_PID### AND tx_dslimmo_domain_model_immobilie.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
		'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'objekttitel' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekttitel',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'dreizeiler' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.dreizeiler',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'lage' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.lage',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'ausstattbeschr' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattbeschr',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'objektbeschreibung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objektbeschreibung',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'sonstigeangaben' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.sonstigeangaben',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'objekt_nrintern' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_nrintern',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'objekt_nrextern' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_nrextern',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'openimmoobid' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.openimmoobid',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'stand_vom' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.stand_vom',
	        'config' => [
			    'dbType' => 'date',
			    'type' => 'input',
			    'size' => 7,
			    'eval' => 'date',
			    'default' => '0000-00-00'
			],
	    ],
	    'nutzungs_art' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.nutzungs_art',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'vermarktungs_art' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.vermarktungs_art',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_wohnung_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_wohnung_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'geo_plz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_plz',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_ort' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_ort',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_strasse' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_strasse',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_hausnummer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_hausnummer',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_etage' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_etage',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_anzahl_etagen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_anzahl_etagen',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_lage_im_bau' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_lage_im_bau',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_lage_gebiet' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_lage_gebiet',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_land' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_land',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_koordinaten_breitengrad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_koordinaten_breitengrad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'geo_koordinaten_laengengrad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_koordinaten_laengengrad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'geo_regionaler_zusatz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_regionaler_zusatz',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'preise_kaltmiete' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_kaltmiete',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_warmmiete' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_warmmiete',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_nebenkosten' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_nebenkosten',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_kaution' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_kaution',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_wohnflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_wohnflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_zimmer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_zimmer',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_balkone' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_balkone',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_terassen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_terassen',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_logia' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_logia',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'zustand_baujahr' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.zustand_baujahr',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'zustand_art' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.zustand_art',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'energiepass_epart' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_epart',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_energieverbrauchkennwert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_energieverbrauchkennwert',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_endenergiebedarf' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_endenergiebedarf',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_gebaeudeart' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_gebaeudeart',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'objektadresse_freigeben' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objektadresse_freigeben',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'verfuegbar_ab' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.verfuegbar_ab',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'vermietet' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.vermietet',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'denkmalgeschuetzt' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.denkmalgeschuetzt',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_wggeeignet' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_wggeeignet',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_raeumeveraenderbar' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_raeumeveraenderbar',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_kamin' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kamin',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_klimatisiert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_klimatisiert',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_gartennutzung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_gartennutzung',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_rollstuhlgerecht' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_rollstuhlgerecht',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_kabelsattv' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kabelsattv',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_dvbt' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_dvbt',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_barrierefrei' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_barrierefrei',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_sauna' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_sauna',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_swimmingpool' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_swimmingpool',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_wasch_trockenraum' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_wasch_trockenraum',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_wintergarten' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_wintergarten',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_dvverkabelung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_dvverkabelung',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_rampe' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_rampe',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_hebebuehne' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_hebebuehne',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_kran' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kran',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_gastterrasse' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_gastterrasse',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_kantinecafeteria' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kantinecafeteria',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_teekueche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_teekueche',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_brauereibindung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_brauereibindung',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_sporteinrichtungen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_sporteinrichtungen',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_wellnessbereich' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_wellnessbereich',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_telefonferienimmobilie' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_telefonferienimmobilie',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_umtsempfang' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_umtsempfang',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_abstellraum' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_abstellraum',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_bibliothek' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_bibliothek',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_dachboden' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_dachboden',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_gaestewc' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_gaestewc',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_kabelkanaele' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kabelkanaele',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_seniorengerecht' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_seniorengerecht',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_fahrradraum' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_fahrradraum',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_rolladen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_rolladen',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'ausstattung_bad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_bad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_kueche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kueche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_boden' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_boden',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_heizungsart' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_heizungsart',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_befeuerung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_befeuerung',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_fahrstuhl' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_fahrstuhl',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_stellplatzart' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_stellplatzart',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_ausricht_balkon_terasse' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_ausricht_balkon_terasse',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_angeschl_gastronomie' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_angeschl_gastronomie',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_serviceleistungen' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_serviceleistungen',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_sicherheitstechnik' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_sicherheitstechnik',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_moebliert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_moebliert',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'ausstattung_kategorie' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_kategorie',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'ausstattung_dachform' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_dachform',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_bauweise' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_bauweise',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_ausbaustufe' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_ausbaustufe',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_energietyp' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_energietyp',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_unterkellert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_unterkellert',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'ausstattung_hallenhoehe' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_hallenhoehe',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ausstattung_stromanschlusswert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.ausstattung_stromanschlusswert',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_gueltig_bis' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_gueltig_bis',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_mitwarmwasser' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_mitwarmwasser',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_primaerenergietraeger' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_primaerenergietraeger',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_stromwert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_stromwert',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_waermewert' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_waermewert',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_wertklasse' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_wertklasse',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_ausstelldatum' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_ausstelldatum',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'energiepass_jahrgang' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energiepass_jahrgang',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'highlight' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.highlight',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'objekt_art_zimmer_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_zimmer_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_haus_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_haus_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_grundstueck_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_grundstueck_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_buero_praxen_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_buero_praxen_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_einzelhandel_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_einzelhandel_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_gastgewerbe_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_gastgewerbe_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_hallen_lager_produktion_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_hallen_lager_produktion_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_land_forstwirtschaft_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_land_forstwirtschaft_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_parken_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_parken_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_sonstige_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_sonstige_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_freizeitimmobilie_gewerblich_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_freizeitimmobilie_gewerblich_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'objekt_art_zinshaus_renditeobjekt_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.objekt_art_zinshaus_renditeobjekt_typ',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => ''
			],
	    ],
	    'flaechen_sonstflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_sonstflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_vermietbare_flaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_vermietbare_flaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_gewerbeeinheiten' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_gewerbeeinheiten',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'flaechen_nutzflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_nutzflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_gesamtflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_gesamtflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_bueroflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_bueroflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_grundstuecksflaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_grundstuecksflaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'flaechen_anzahl_badezimmer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_badezimmer',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'flaechen_anzahl_schlafzimmer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.flaechen_anzahl_schlafzimmer',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'preise_kaufpreis' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_kaufpreis',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_provisionspflichtig' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_provisionspflichtig',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'preise_aussen_courtage' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_aussen_courtage',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'preise_aussen_courtage_mit_mwst' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_aussen_courtage_mit_mwst',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'preise_waehrung_iso_waehrung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_waehrung_iso_waehrung',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'preise_mwst_satz' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_mwst_satz',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_mieteinnahmen_ist' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_mieteinnahmen_ist',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'preise_stp_freiplatz_anzahl' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_stp_freiplatz_anzahl',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'preise_stp_sonstige_anzahl' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_stp_sonstige_anzahl',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'preise_stp_sonstige_platzart' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.preise_stp_sonstige_platzart',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'search_vermarktung' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_vermarktung',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'search_objekt_typ' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_objekt_typ',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'search_zimmer' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_zimmer',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'search_flaeche' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_flaeche',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'search_preis' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_preis',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'search_wohngebiet' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.search_wohngebiet',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'geo_adresse_gesperrt_koordinaten_breitengrad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_adresse_gesperrt_koordinaten_breitengrad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'geo_adresse_gesperrt_koordinaten_laengengrad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.geo_adresse_gesperrt_koordinaten_laengengrad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
	    'haustiere' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.haustiere',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'additional_html_field' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.additional_html_field',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'moderner_grundriss' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.moderner_grundriss',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'energie_ausweis_link_extern' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.energie_ausweis_link_extern',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'anhaenge' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.anhaenge',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslimmo_domain_model_anhang',
			    'foreign_field' => 'immobilie',
			    'maxitems' => 9999,
			    'appearance' => [
			        'collapseAll' => 0,
			        'levelLinksPosition' => 'top',
			        'showSynchronizationLink' => 1,
			        'showPossibleLocalizationRecords' => 1,
			        'showAllLocalizationLink' => 1
			    ],
			],
	    ],
	    'importe' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.importe',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectMultipleSideBySide',
			    'foreign_table' => 'tx_dslimmo_domain_model_import',
			    'MM' => 'tx_dslimmo_immobilie_import_mm',
			    'size' => 10,
			    'autoSizeMax' => 30,
			    'maxitems' => 9999,
			    'multiple' => 0,
			    'wizards' => [
			        '_PADDING' => 1,
			        '_VERTICAL' => 1,
			        'edit' => [
			            'module' => [
			                'name' => 'wizard_edit',
			            ],
			            'type' => 'popup',
			            'title' => 'Edit', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.edit
			            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
			            'popup_onlyOpenIfSelected' => 1,
			            'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
			        ],
			        'add' => [
			            'module' => [
			                'name' => 'wizard_add',
			            ],
			            'type' => 'script',
			            'title' => 'Create new', // todo define label: LLL:EXT:.../Resources/Private/Language/locallang_tca.xlf:wizard.add
			            'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
			            'params' => [
			                'table' => 'tx_dslimmo_domain_model_import',
			                'pid' => '###CURRENT_PID###',
			                'setValue' => 'prepend'
			            ],
			        ],
			    ],
			],
	    ],
	    'kontaktperson' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.kontaktperson',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslimmo_domain_model_kontaktperson',
			    'minitems' => 0,
			    'maxitems' => 1,
			    'appearance' => [
			        'collapseAll' => 0,
			        'levelLinksPosition' => 'top',
			        'showSynchronizationLink' => 1,
			        'showPossibleLocalizationRecords' => 1,
			        'showAllLocalizationLink' => 1
			    ],
			],
	    ],
	    'titel_bild' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:dsl_immo/Resources/Private/Language/locallang_db.xlf:tx_dslimmo_domain_model_immobilie.titel_bild',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_dslimmo_domain_model_anhang',
			    'minitems' => 0,
			    'maxitems' => 1,
			    'appearance' => [
			        'collapseAll' => 0,
			        'levelLinksPosition' => 'top',
			        'showSynchronizationLink' => 1,
			        'showPossibleLocalizationRecords' => 1,
			        'showAllLocalizationLink' => 1
			    ],
			],
	    ],
    ],
];
