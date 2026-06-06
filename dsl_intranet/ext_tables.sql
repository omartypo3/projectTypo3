CREATE TABLE tx_dslintranet_domain_model_aufgaben (
	notiz varchar(255) NOT NULL DEFAULT '',
	begin int(11) NOT NULL DEFAULT '0',
	end int(11) NOT NULL DEFAULT '0',
	erledigt smallint(1) unsigned NOT NULL DEFAULT '0',
	mitarbeiter int(11) unsigned DEFAULT '0',
	auftrag int(11) unsigned DEFAULT '0',
	cruser int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_protokollepending (
	pending smallint(1) unsigned NOT NULL DEFAULT '0',
	timestamp int(11) NOT NULL DEFAULT '0',
	mitarbeiter int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_kundenstammdaten (
	settings_kunde text NOT NULL DEFAULT '',
	newsletter smallint(1) unsigned NOT NULL DEFAULT '0'
);
CREATE TABLE tx_dslintranet_domain_model_news (
	titel varchar(255) NOT NULL DEFAULT '',
	untertitel varchar(255) NOT NULL DEFAULT '',
	text text NOT NULL DEFAULT '',
	angebot1 varchar(255) NOT NULL DEFAULT '',
	angebot2 varchar(255) NOT NULL DEFAULT '',
	angebot3 varchar(255) NOT NULL DEFAULT '',
	link_extern varchar(255) NOT NULL DEFAULT '',
	link_extern_name varchar(255) NOT NULL DEFAULT '',
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0',
	gueltig_ab int(11) NOT NULL DEFAULT '0',
	gueltig_bis int(11) NOT NULL DEFAULT '0',
	datei int(11) unsigned NOT NULL DEFAULT '0',
	countdown smallint(1) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_auftraegetexte (
	auftraege int(11) unsigned DEFAULT '0' NOT NULL,
	titel varchar(255) NOT NULL DEFAULT '',
	beschreibung text,
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_benutzer (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_kunden (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_fegroups (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_kundenagenturvertraege (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_kundendateien (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_kundenfegroups (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_kundennews (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_mitarbeiter (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_splitpane (
	titel varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_dslintranet_domain_model_dateien (
	kunden int(11) unsigned DEFAULT '0' NOT NULL,
	agenturvertraege int(11) unsigned DEFAULT '0' NOT NULL,
	auftraege int(11) unsigned DEFAULT '0' NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,
	datei int(11) unsigned NOT NULL DEFAULT '0',
	projekte int(11) unsigned DEFAULT '0' NOT NULL,
	titel varchar(255) NOT NULL DEFAULT '',
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0',
	temp_datei_name varchar(255) NOT NULL DEFAULT '',
	temp_datei_groesse int(11) NOT NULL DEFAULT '0',
	temp_kunden_name varchar(255) NOT NULL DEFAULT '',
	temp_type varchar(255) NOT NULL DEFAULT '',
	temp_kunden_nummer varchar(255) NOT NULL DEFAULT '',
	temp_timestamp varchar(255) NOT NULL DEFAULT '',
	temp_rechnungsnummer varchar(255) NOT NULL DEFAULT '',
	iduser int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_auftragsarten (
	titel varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_dslintranet_domain_model_protokolle (
	aktion int(11) DEFAULT '0' NOT NULL,
	notiz text DEFAULT NULL,
	kundeninfo_time int(11) NOT NULL DEFAULT '0',
	kundeninfo_mail varchar(255) NOT NULL DEFAULT '',
	notiz_system varchar(255) NOT NULL DEFAULT '',
	zeitpunkt int(11) NOT NULL DEFAULT '0',
	kundeninfo_sichtbarkeit int(11) NOT NULL DEFAULT '0',
	auftrag_status_alt int(11) NOT NULL DEFAULT '0',
	auftrag_status_neu int(11) NOT NULL DEFAULT '0',
	auftrag int(11) unsigned DEFAULT '0',
	datei int(11) unsigned DEFAULT '0',
	pending int(11) unsigned NOT NULL DEFAULT '0',
	agenturvertrag int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_notification (
	art int(11) DEFAULT '0' NOT NULL,
	gelesen int(11) NOT NULL DEFAULT '0',
	wert1 varchar(255) NOT NULL DEFAULT '',
	wert2 varchar(255) NOT NULL DEFAULT '',
	wert3 varchar(255) NOT NULL DEFAULT '',
	wert4 varchar(255) NOT NULL DEFAULT '',
	kunde_name varchar(255) NOT NULL DEFAULT '',
	auftrag_titel varchar(255) NOT NULL DEFAULT '',
	auftrag int(11) unsigned DEFAULT '0',
	cruser int(11) unsigned DEFAULT '0',
	urlaub int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_tarife (
	titel varchar(255) NOT NULL DEFAULT '',
	laufzeit int(11) DEFAULT '0' NOT NULL,
	preis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	notiz text NOT NULL DEFAULT ''
);

#
# Table structure for table 'tx_dslintranet_domain_model_projekte'
#
CREATE TABLE tx_dslintranet_domain_model_projekte (
	titel varchar(255) DEFAULT '' NOT NULL,
	stunden double(11,2) DEFAULT '0.00' NOT NULL,
	preis double(11,2) DEFAULT '0.00' NOT NULL,
	beschreibung text NOT NULL,
	projektbegin date DEFAULT NULL,
	projektende date DEFAULT NULL,
	vertrag int(11) unsigned NOT NULL default '0',
	preis_mehraufwand_stunde double(11,2) DEFAULT '0.00' NOT NULL,
	kunde int(11) unsigned DEFAULT '0',
	dateien int(11) unsigned DEFAULT '0' NOT NULL,
	abgeschlossen tinyint(1) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_dslintranet_domain_model_wartungsvertraege (
	titel varchar(255) NOT NULL DEFAULT '',
	beschreibung text,
	gekuendigt smallint(1) unsigned NOT NULL DEFAULT '0',
	vertragsbegin date DEFAULT NULL,
	bezahltbis date DEFAULT NULL,
	laufzeit int(11) DEFAULT '0' NOT NULL,
	preis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	re_intervall int(11) DEFAULT '0' NOT NULL,
	stunden_pro_jahr int(11) NOT NULL DEFAULT '0',
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0',
	preis_mehraufwand_stunde double(11,2) NOT NULL DEFAULT '0.00',
	oldid int(11) NOT NULL DEFAULT '0',
	kuendigungs_frist int(11) DEFAULT '0' NOT NULL,
	kunde int(11) unsigned DEFAULT '0',
	cruser int(11) unsigned DEFAULT '0',
	optionen int(11) unsigned NOT NULL DEFAULT '0',
	zeitraeume int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_wartungsvertraegeoptionen (
	titel varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_dslintranet_domain_model_wartungsvertraegezeitraeume (
	wartungsvertraege int(11) unsigned DEFAULT '0' NOT NULL,
	von date DEFAULT NULL,
	bis date DEFAULT NULL,
	status int(11) DEFAULT '0' NOT NULL,
	zeiten int(11) unsigned NOT NULL DEFAULT '0',
	rechnungen int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_wartungsvertraegerechnungen (
	wartungsvertraegezeitraeume int(11) unsigned DEFAULT '0' NOT NULL,
	von date DEFAULT NULL,
	bis date DEFAULT NULL,
	preis double(11,2) NOT NULL DEFAULT '0.00',
	notiz varchar(255) NOT NULL DEFAULT '',
	eckdaten varchar(255) NOT NULL DEFAULT '',
	type int(11) DEFAULT '0' NOT NULL,
	status int(11) DEFAULT '0' NOT NULL,
	preis_mehraufwand double(11,2) NOT NULL DEFAULT '0.00'
);

CREATE TABLE fe_users (
	mobilephone varchar(255) NOT NULL DEFAULT '',
	spitzname varchar(255) NOT NULL DEFAULT '',
	initialien varchar(255) NOT NULL DEFAULT '',
	notiz varchar(255) NOT NULL DEFAULT '',
	arbeitsbegin int(11) NOT NULL DEFAULT '0',
	arbeitsende int(11) NOT NULL DEFAULT '0',
	autostop int(11) NOT NULL DEFAULT '0',
	farbe text DEFAULT NULL,
	rechte varchar(255) NOT NULL DEFAULT '',
	urlaubstage_pro_jahr int(11) NOT NULL DEFAULT '0',
	urlaubstage_verbraucht int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE fe_users (
	settings text DEFAULT NULL,
	settings_hosting text DEFAULT NULL,
	geoeffneter_auftrag int(11) NOT NULL DEFAULT '0',
	settings_aufgaben text DEFAULT NULL,
	settings_dateien text DEFAULT NULL,
	settings_kunde text DEFAULT NULL,
	settings_kanban text DEFAULT NULL,
	notizen text DEFAULT NULL,

	avatar int(11) unsigned NOT NULL DEFAULT '0',
	settings_agenturauftrag text DEFAULT NULL,
	settings_ablage text DEFAULT NULL,
	settings_allgemein text DEFAULT NULL,
	settings_kunden text DEFAULT NULL,
	offene_auftraege int(11) unsigned NOT NULL DEFAULT '0',
	ablage int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_fremdkosten (
	auftraege int(11) unsigned DEFAULT '0' NOT NULL,
	anzahl int(11) NOT NULL DEFAULT '0',
	name varchar(255) NOT NULL DEFAULT '',
	preis double(11,2) NOT NULL DEFAULT '0.00'
);

CREATE TABLE tx_dslintranet_domain_model_lieferanten (
	nummer varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE fe_users (
	nummer varchar(255) NOT NULL DEFAULT '',
	qbrefnum varchar(255) NOT NULL DEFAULT '',
	qbbaddr text DEFAULT NULL,
	spitzname varchar(255) NOT NULL DEFAULT '',
	initialien varchar(255) NOT NULL DEFAULT '',
	notiz varchar(255) NOT NULL DEFAULT '',
	freigaben varchar(255) NOT NULL DEFAULT '',
	history text DEFAULT NULL,
	qb_email varchar(255) NOT NULL DEFAULT '',
	qb_einv_email varchar(255) NOT NULL DEFAULT '',
	qb_cont varchar(255) NOT NULL DEFAULT '',
	qb_anrede varchar(255) NOT NULL DEFAULT '',
	qb_firstname varchar(255) NOT NULL DEFAULT '',
	qb_lastname varchar(255) NOT NULL DEFAULT '',
	qb_street varchar(255) NOT NULL DEFAULT '',
	qb_postal varchar(255) NOT NULL DEFAULT '',
	qb_city varchar(255) NOT NULL DEFAULT '',
	qb_phone text DEFAULT NULL,
	qb_fax varchar(255) NOT NULL DEFAULT '',
	qb_cont2 varchar(255) NOT NULL DEFAULT '',
	qb_phone2 varchar(255) NOT NULL DEFAULT '',
	autologin varchar(255) NOT NULL DEFAULT '',
	email_rechnungen varchar(255) NOT NULL DEFAULT '',
	email_angebote varchar(255) NOT NULL DEFAULT '',
	newsletter smallint(1) unsigned NOT NULL DEFAULT '0',
	email_newsletter varchar(255) NOT NULL DEFAULT '',
	qb_kto_inh varchar(255) NOT NULL DEFAULT '',
	qb_bic varchar(255) NOT NULL DEFAULT '',
	qb_iban varchar(255) NOT NULL DEFAULT '',
	qb_bank varchar(255) NOT NULL DEFAULT '',
	pic_drop_zugangscode varchar(255) NOT NULL DEFAULT '',
	passwort_kopie varchar(255) NOT NULL DEFAULT '',
	qb_company varchar(255) NOT NULL DEFAULT '',
	dateien int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_agenturvertraege (
	stunden_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	preis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	beschreibung text,
	vertragsbegin date DEFAULT NULL,
	vertragsende date DEFAULT NULL,
	vertrag int(11) unsigned NOT NULL DEFAULT '0',
	preis_mehraufwand_stunde double(11,2) NOT NULL DEFAULT '0.00',
	kunde int(11) unsigned DEFAULT '0',
	dateien int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_urlaub (
	notiz text NOT NULL DEFAULT '',
	begin date DEFAULT NULL,
	end date DEFAULT NULL,
	status int(11) DEFAULT '0' NOT NULL,
	titel varchar(255) NOT NULL DEFAULT '',
	tage int(11) NOT NULL DEFAULT '0',
	tage_resturlaub int(11) NOT NULL DEFAULT '0',
	oldid int(11) NOT NULL DEFAULT '0',
	sonstiges smallint(1) unsigned NOT NULL DEFAULT '0',
	mitarbeiter int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_zeiteintraege (
	wartungsvertraegezeitraeume int(11) unsigned DEFAULT '0' NOT NULL,
	auftraege int(11) unsigned DEFAULT '0' NOT NULL,
	text text NOT NULL DEFAULT '',
	begin int(11) NOT NULL DEFAULT '0',
	end int(11) NOT NULL DEFAULT '0',
	kontingent int(11) NOT NULL DEFAULT '0',
	zeitnahme int(11) NOT NULL DEFAULT '0',
	oldid int(11) NOT NULL DEFAULT '0',
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0',
	kontingent_mehraufwand int(11) DEFAULT '0' NOT NULL,
	zeitnahme_auto_stopped smallint(1) unsigned NOT NULL DEFAULT '0',
	cruser int(11) unsigned DEFAULT '0',
	phase int(11) unsigned DEFAULT '0',
	tracker int(11) unsigned NOT NULL DEFAULT '0',
	segmente int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_trackersegmente (
	zeiteintraege int(11) unsigned DEFAULT '0' NOT NULL,
	begin int(11) NOT NULL DEFAULT '0',
	end int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_phasen (
	titel varchar(255) NOT NULL DEFAULT '',
	color varchar(255) NOT NULL DEFAULT '',
	highlightcolor varchar(255) NOT NULL DEFAULT '',
	icon varchar(255) NOT NULL DEFAULT '',
	titel_kurz varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_dslintranet_domain_model_zeiteintraegesegmente (
	zeiteintraege int(11) unsigned DEFAULT '0' NOT NULL,
	minuten int(11) NOT NULL DEFAULT '0',
	phase int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_ablage (
	benutzer int(11) unsigned DEFAULT '0' NOT NULL,
	notiz varchar(255) NOT NULL DEFAULT '',
	auftrag int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_hosting (
	benutzername varchar(255) NOT NULL DEFAULT '',
	kennwort varchar(255) NOT NULL DEFAULT '',
	statistik varchar(255) NOT NULL DEFAULT '',
	oldid int(11) NOT NULL DEFAULT '0',
	notiz text NOT NULL DEFAULT '',
	kunde int(11) unsigned DEFAULT '0',
	haupt_tarif int(11) unsigned DEFAULT '0',
	zusatz_leistungen int(11) unsigned NOT NULL DEFAULT '0',
	zusatz_tarif int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_hostingdomains (
	domainname varchar(255) NOT NULL DEFAULT '',
	hosting2 int(11) unsigned DEFAULT '0' NOT NULL,
	sonderpreis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	gekuendigt smallint(1) unsigned NOT NULL DEFAULT '0',
	vertragsbegin date DEFAULT NULL,
	bezahltbis date DEFAULT NULL,
	gekuendigt_zum date DEFAULT NULL,
	oldid int(11) NOT NULL DEFAULT '0',
	sonderlaufzeit int(11) DEFAULT '0' NOT NULL,
	tarif int(11) unsigned DEFAULT '0',
	rechnungen int(11) unsigned NOT NULL DEFAULT '0',
	cruser int(11) unsigned DEFAULT '0',
	notiz text NOT NULL DEFAULT ''

);

CREATE TABLE tx_dslintranet_domain_model_hostingzusatzleistungen (
	hosting int(11) unsigned DEFAULT '0' NOT NULL,
	anzahl int(11) NOT NULL DEFAULT '0',
	sonderpreis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	gekuendigt smallint(1) unsigned NOT NULL DEFAULT '0',
	vertragsbegin date DEFAULT NULL,
	bezahltbis date DEFAULT NULL,
	sonderlaufzeit int(11) DEFAULT '0' NOT NULL,
	zusatzleistung int(11) unsigned DEFAULT '0',
	rechnungen int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_hostingtarifrechnungen (
	hostingdomains int(11) unsigned DEFAULT '0' NOT NULL,
	hostingzusatzleistungen int(11) unsigned DEFAULT '0' NOT NULL,
	von date DEFAULT NULL,
	bis date DEFAULT NULL,
	preis double(11,2) NOT NULL DEFAULT '0.00',
	tarif varchar(255) NOT NULL DEFAULT '',
	notiz text NOT NULL DEFAULT '',
	domainname varchar(255) NOT NULL DEFAULT '',
	cruser int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_dslintranet_domain_model_zusatzleistungen (
	titel varchar(255) NOT NULL DEFAULT '',
	laufzeit int(11) DEFAULT '0' NOT NULL,
	preis_monatlich double(11,2) NOT NULL DEFAULT '0.00',
	notiz text NOT NULL DEFAULT ''
);

CREATE TABLE tx_dslintranet_domain_model_auftraege (
	titel varchar(255) NOT NULL DEFAULT '',
	status int(11) DEFAULT '0' NOT NULL,
	datum int(11) NOT NULL DEFAULT '0',
	prioritaet int(11) DEFAULT '0' NOT NULL,
	datumfertigstellung int(11) NOT NULL DEFAULT '0',
	sichtbarkeit smallint(1) unsigned NOT NULL DEFAULT '0',
	phasen_kontingent text,
	mitarbeiter_kontingent text,
	lieferung_an_kunde tinyint(1) unsigned DEFAULT '0' NOT NULL,
	stundensatz_agenturvertrag double(11,2) DEFAULT '0.00' NOT NULL,
	kontingent int(11) NOT NULL DEFAULT '0',
	kontingent_used_cached int(11) DEFAULT '0' NOT NULL,
	beschreibung text,
	per int(11) DEFAULT '0' NOT NULL,
	durch varchar(255) NOT NULL DEFAULT '',
	oldid int(11) NOT NULL DEFAULT '0',
	datei int(11) unsigned NOT NULL DEFAULT '0',
	festpreis double(11,2) NOT NULL DEFAULT '0.00',
	fremdkosten_summe double(11,2) NOT NULL DEFAULT '0.00',
	datum_abschluss int(11) NOT NULL DEFAULT '0',
	datumproduktion int(11) NOT NULL DEFAULT '0',
	nutzungs_faktor_nur_entwurf_kreativleistung smallint(1) unsigned NOT NULL DEFAULT '0',
	nutzungs_faktoren text,
	stundensatz double(11,2) NOT NULL DEFAULT '0.00',
	phasen_stundensatz text,
	notizen_intern text,
	kunde int(11) unsigned DEFAULT '0',
	mitarbeiter int(11) unsigned NOT NULL DEFAULT '0',
	zeiten int(11) unsigned NOT NULL DEFAULT '0',
	auftragsart int(11) unsigned DEFAULT '0',
	phasen int(11) unsigned NOT NULL DEFAULT '0',
	dateien int(11) unsigned NOT NULL DEFAULT '0',
	ansprechpartner int(11) unsigned DEFAULT '0',
	texte int(11) unsigned NOT NULL DEFAULT '0',
	fegroups int(11) unsigned NOT NULL DEFAULT '0',
	fremdkosten int(11) unsigned NOT NULL DEFAULT '0',
	lieferanten int(11) unsigned NOT NULL DEFAULT '0',
	projekt int(11) unsigned DEFAULT '0'
);


