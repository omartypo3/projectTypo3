#
# Table structure for table 'tx_dslimmo_domain_model_immobilie'
#
CREATE TABLE tx_dslimmo_domain_model_immobilie (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	objekttitel varchar(255) DEFAULT '' NOT NULL,
	dreizeiler text NOT NULL,
	lage text NOT NULL,
	ausstattbeschr text NOT NULL,
	objektbeschreibung text NOT NULL,
	sonstigeangaben text NOT NULL,
	objekt_nrintern varchar(255) DEFAULT '' NOT NULL,
	objekt_nrextern varchar(255) DEFAULT '' NOT NULL,
	openimmoobid varchar(255) DEFAULT '' NOT NULL,
	stand_vom date DEFAULT '0000-00-00',
	nutzungs_art int(11) DEFAULT '0' NOT NULL,
	vermarktungs_art int(11) DEFAULT '0' NOT NULL,
	objekt_art_wohnung_typ int(11) DEFAULT '0' NOT NULL,
	geo_plz varchar(255) DEFAULT '' NOT NULL,
	geo_ort varchar(255) DEFAULT '' NOT NULL,
	geo_strasse varchar(255) DEFAULT '' NOT NULL,
	geo_hausnummer varchar(255) DEFAULT '' NOT NULL,
	geo_etage varchar(255) DEFAULT '' NOT NULL,
	geo_anzahl_etagen varchar(255) DEFAULT '' NOT NULL,
	geo_lage_im_bau varchar(255) DEFAULT '' NOT NULL,
	geo_lage_gebiet varchar(255) DEFAULT '' NOT NULL,
	geo_land varchar(255) DEFAULT '' NOT NULL,
	geo_koordinaten_breitengrad double(11,2) DEFAULT '0.00' NOT NULL,
	geo_koordinaten_laengengrad double(11,2) DEFAULT '0.00' NOT NULL,
	geo_regionaler_zusatz varchar(255) DEFAULT '' NOT NULL,
	preise_kaltmiete double(11,2) DEFAULT '0.00' NOT NULL,
	preise_warmmiete double(11,2) DEFAULT '0.00' NOT NULL,
	preise_nebenkosten double(11,2) DEFAULT '0.00' NOT NULL,
	preise_kaution double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_wohnflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_zimmer double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_balkone double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_terassen double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_logia double(11,2) DEFAULT '0.00' NOT NULL,
	zustand_baujahr varchar(255) DEFAULT '' NOT NULL,
	zustand_art int(11) DEFAULT '0' NOT NULL,
	energiepass_epart varchar(255) DEFAULT '' NOT NULL,
	energiepass_energieverbrauchkennwert varchar(255) DEFAULT '' NOT NULL,
	energiepass_endenergiebedarf varchar(255) DEFAULT '' NOT NULL,
	energiepass_gebaeudeart varchar(255) DEFAULT '' NOT NULL,
	objektadresse_freigeben tinyint(1) unsigned DEFAULT '0' NOT NULL,
	verfuegbar_ab varchar(255) DEFAULT '' NOT NULL,
	vermietet tinyint(1) unsigned DEFAULT '0' NOT NULL,
	denkmalgeschuetzt tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_wggeeignet tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_raeumeveraenderbar tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_kamin tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_klimatisiert tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_gartennutzung tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_rollstuhlgerecht tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_kabelsattv tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_dvbt tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_barrierefrei tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_sauna tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_swimmingpool tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_wasch_trockenraum tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_wintergarten tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_dvverkabelung tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_rampe tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_hebebuehne tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_kran tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_gastterrasse tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_kantinecafeteria tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_teekueche tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_brauereibindung tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_sporteinrichtungen tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_wellnessbereich tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_telefonferienimmobilie tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_umtsempfang tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_abstellraum tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_bibliothek tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_dachboden tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_gaestewc tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_kabelkanaele tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_seniorengerecht tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_fahrradraum tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_rolladen tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ausstattung_bad varchar(255) DEFAULT '' NOT NULL,
	ausstattung_kueche varchar(255) DEFAULT '' NOT NULL,
	ausstattung_boden varchar(255) DEFAULT '' NOT NULL,
	ausstattung_heizungsart varchar(255) DEFAULT '' NOT NULL,
	ausstattung_befeuerung varchar(255) DEFAULT '' NOT NULL,
	ausstattung_fahrstuhl varchar(255) DEFAULT '' NOT NULL,
	ausstattung_stellplatzart varchar(255) DEFAULT '' NOT NULL,
	ausstattung_ausricht_balkon_terasse varchar(255) DEFAULT '' NOT NULL,
	ausstattung_angeschl_gastronomie varchar(255) DEFAULT '' NOT NULL,
	ausstattung_serviceleistungen varchar(255) DEFAULT '' NOT NULL,
	ausstattung_sicherheitstechnik varchar(255) DEFAULT '' NOT NULL,
	ausstattung_moebliert int(11) DEFAULT '0' NOT NULL,
	ausstattung_kategorie int(11) DEFAULT '0' NOT NULL,
	ausstattung_dachform varchar(255) DEFAULT '' NOT NULL,
	ausstattung_bauweise varchar(255) DEFAULT '' NOT NULL,
	ausstattung_ausbaustufe varchar(255) DEFAULT '' NOT NULL,
	ausstattung_energietyp varchar(255) DEFAULT '' NOT NULL,
	ausstattung_unterkellert int(11) DEFAULT '0' NOT NULL,
	ausstattung_hallenhoehe varchar(255) DEFAULT '' NOT NULL,
	ausstattung_stromanschlusswert varchar(255) DEFAULT '' NOT NULL,
	energiepass_gueltig_bis varchar(255) DEFAULT '' NOT NULL,
	energiepass_mitwarmwasser varchar(255) DEFAULT '' NOT NULL,
	energiepass_primaerenergietraeger varchar(255) DEFAULT '' NOT NULL,
	energiepass_stromwert varchar(255) DEFAULT '' NOT NULL,
	energiepass_waermewert varchar(255) DEFAULT '' NOT NULL,
	energiepass_wertklasse varchar(255) DEFAULT '' NOT NULL,
	energiepass_ausstelldatum varchar(255) DEFAULT '' NOT NULL,
	energiepass_jahrgang varchar(255) DEFAULT '' NOT NULL,
	highlight int(11) DEFAULT '0' NOT NULL,
	objekt_art_zimmer_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_haus_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_grundstueck_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_buero_praxen_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_einzelhandel_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_gastgewerbe_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_hallen_lager_produktion_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_land_forstwirtschaft_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_parken_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_sonstige_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_freizeitimmobilie_gewerblich_typ int(11) DEFAULT '0' NOT NULL,
	objekt_art_zinshaus_renditeobjekt_typ int(11) DEFAULT '0' NOT NULL,
	flaechen_sonstflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_vermietbare_flaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_gewerbeeinheiten int(11) DEFAULT '0' NOT NULL,
	flaechen_nutzflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_gesamtflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_bueroflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_grundstuecksflaeche double(11,2) DEFAULT '0.00' NOT NULL,
	flaechen_anzahl_badezimmer int(11) DEFAULT '0' NOT NULL,
	flaechen_anzahl_schlafzimmer int(11) DEFAULT '0' NOT NULL,
	preise_kaufpreis double(11,2) DEFAULT '0.00' NOT NULL,
	preise_provisionspflichtig tinyint(1) unsigned DEFAULT '0' NOT NULL,
	preise_aussen_courtage varchar(255) DEFAULT '' NOT NULL,
	preise_aussen_courtage_mit_mwst tinyint(1) unsigned DEFAULT '0' NOT NULL,
	preise_waehrung_iso_waehrung varchar(255) DEFAULT '' NOT NULL,
	preise_mwst_satz double(11,2) DEFAULT '0.00' NOT NULL,
	preise_mieteinnahmen_ist double(11,2) DEFAULT '0.00' NOT NULL,
	preise_stp_freiplatz_anzahl int(11) DEFAULT '0' NOT NULL,
	preise_stp_sonstige_anzahl int(11) DEFAULT '0' NOT NULL,
	preise_stp_sonstige_platzart varchar(255) DEFAULT '' NOT NULL,
	search_vermarktung varchar(255) DEFAULT '' NOT NULL,
	search_objekt_typ varchar(255) DEFAULT '' NOT NULL,
	search_zimmer double(11,2) DEFAULT '0.00' NOT NULL,
	search_flaeche double(11,2) DEFAULT '0.00' NOT NULL,
	search_preis double(11,2) DEFAULT '0.00' NOT NULL,
	search_wohngebiet varchar(255) DEFAULT '' NOT NULL,
	geo_adresse_gesperrt_koordinaten_breitengrad double(11,2) DEFAULT '0.00' NOT NULL,
	geo_adresse_gesperrt_koordinaten_laengengrad double(11,2) DEFAULT '0.00' NOT NULL,
	haustiere tinyint(1) unsigned DEFAULT '0' NOT NULL,
	additional_html_field text NOT NULL,
	moderner_grundriss tinyint(1) unsigned DEFAULT '0' NOT NULL,
	energie_ausweis_link_extern varchar(255) DEFAULT '' NOT NULL,
	anhaenge int(11) unsigned DEFAULT '0' NOT NULL,
	importe int(11) unsigned DEFAULT '0' NOT NULL,
	kontaktperson int(11) unsigned DEFAULT '0',
	titel_bild int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_dslimmo_domain_model_import'
#
CREATE TABLE tx_dslimmo_domain_model_import (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	type int(11) DEFAULT '0' NOT NULL,
	datei int(11) unsigned NOT NULL default '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_dslimmo_domain_model_anhang'
#
CREATE TABLE tx_dslimmo_domain_model_anhang (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	immobilie int(11) unsigned DEFAULT '0' NOT NULL,

	type int(11) DEFAULT '0' NOT NULL,
	datei int(11) unsigned NOT NULL default '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_dslimmo_domain_model_kontaktperson'
#
CREATE TABLE tx_dslimmo_domain_model_kontaktperson (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	emailzentrale varchar(255) DEFAULT '' NOT NULL,
	telzentrale varchar(255) DEFAULT '' NOT NULL,
	telfax varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	vorname varchar(255) DEFAULT '' NOT NULL,
	firma varchar(255) DEFAULT '' NOT NULL,
	strasse varchar(255) DEFAULT '' NOT NULL,
	plz varchar(255) DEFAULT '' NOT NULL,
	ort varchar(255) DEFAULT '' NOT NULL,
	url varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_dslimmo_domain_model_anhang'
#
CREATE TABLE tx_dslimmo_domain_model_anhang (

	immobilie int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_dslimmo_immobilie_import_mm'
#
CREATE TABLE tx_dslimmo_immobilie_import_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder