CREATE TABLE tx_pingagaddress_domain_model_map (
	title varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),

);
CREATE TABLE tx_cartproducts_domain_model_product_product (
	Szblindnummer varchar(255) DEFAULT '' NOT NULL,
	Verfasser varchar(255) DEFAULT '' NOT NULL,
	Verlag varchar(255) DEFAULT '' NOT NULL,
	Jahr varchar(255) DEFAULT '' NOT NULL,
	Seitenanzahl varchar(255) DEFAULT '' NOT NULL,
);
CREATE TABLE tx_sfeventmgt_domain_model_event (
  goal text NOT NULL,
	requirements text NOT NULL,
	vorkenntnisse text NOT NULL,
	zgroup text NOT NULL,
	leader text NOT NULL,
	comment text NOT NULL,
	infos text NOT NULL,
	dateextra text NOT NULL,
	otherdates text NOT NULL,
	pricetext varchar(255) DEFAULT '' NOT NULL,
	veranstaltung int(11) unsigned NOT NULL DEFAULT '0',
	zielgruppe int(11) unsigned NOT NULL DEFAULT '0',
	kursthemen int(11) unsigned NOT NULL DEFAULT '0',
	sprache int(11) unsigned NOT NULL DEFAULT '0',

);
#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
address text,
marker_icon int(11) unsigned DEFAULT '0',
dienstleistungen int(11) unsigned NOT NULL DEFAULT '0',
kantone int(11) unsigned NOT NULL DEFAULT '0',
	gehoerlos text NOT NULL,
	einsatzort varchar(255) NOT NULL DEFAULT '',
	auto_benoetigt smallint(1) unsigned NOT NULL DEFAULT '0',
	technikenlevel text NOT NULL,
	mutter_sprache text NOT NULL,
	weitere_sprachen_written text NOT NULL,
	weitere_sprachen_oral text NOT NULL,
	spezielle text NOT NULL,
	verfuegbarkeit  varchar(255) DEFAULT '' NOT NULL,

	placeofuse text NOT NULL,
	available text NOT NULL,

	angebote text NOT NULL,
	lebensalter text NOT NULL,
	weiterestandorte int(11) unsigned NOT NULL DEFAULT '0',
);

ALTER TABLE tt_address ALTER COLUMN address text;
ALTER TABLE tt_address MODIFY COLUMN  address text;
ALTER TABLE tt_address MODIFY  address text;


CREATE TABLE tx_sfeventmgt_domain_model_registration (
  bill varchar(255) DEFAULT '' NOT NULL,
  acompany varchar(255) DEFAULT '' NOT NULL,
	aaddress varchar(255) DEFAULT '' NOT NULL,
	azip varchar(32) DEFAULT '' NOT NULL,
	acity varchar(255) DEFAULT '' NOT NULL,
	aphone varchar(255) DEFAULT '' NOT NULL,
	aemail varchar(255) DEFAULT '' NOT NULL,
	ajob varchar(255) DEFAULT '' NOT NULL,
	documents varchar(255) DEFAULT '' NOT NULL,
	situation varchar(255) DEFAULT '' NOT NULL,
	newsletter tinyint(1) unsigned DEFAULT '0' NOT NULL,
	personaldata tinyint(1) unsigned DEFAULT '0' NOT NULL,
);
CREATE TABLE tx_pingagaddress_domain_model_dienstleistungen (
	title varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),
);
CREATE TABLE tx_pingagaddress_domain_model_kantone (
	title varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),
);

CREATE TABLE tx_pingagaddress_domain_model_veranstaltung (
	veranstaltung varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),
);
CREATE TABLE tx_pingagaddress_domain_model_zielgruppe (
	zielgruppe varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),
);
CREATE TABLE tx_pingagaddress_domain_model_kursthemen (
	kursthemen varchar(255) NOT NULL DEFAULT '',
  path_segment varchar(2048),
);
CREATE TABLE tx_pingagaddress_domain_model_sprache (
	sprache varchar(255) NOT NULL DEFAULT '',
	path_segment varchar(2048),
);
CREATE TABLE pages (
	fieldshidden tinyint(1) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_news_domain_model_news (
	title2 varchar(255) NOT NULL DEFAULT '',
);

CREATE TABLE tx_pingagaddress_domain_model_language (
	name varchar(255) NOT NULL DEFAULT '',
	order_other_languages int(11) unsigned NOT NULL DEFAULT '0',
);

CREATE TABLE tx_pingagaddress_domain_model_languageoral (
	language text NOT NULL,
	level text NOT NULL,
);

CREATE TABLE tx_pingagaddress_domain_model_languagewritten (
	language text NOT NULL,
	level text NOT NULL,
);

CREATE TABLE tx_pingagaddress_domain_model_techniques (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_spezielle (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_techniqueslevel (
	techniques text NOT NULL,
	level text NOT NULL,
);

CREATE TABLE tx_pingagaddress_domain_model_placeofuse (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_available (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_level (
	name varchar(255) NOT NULL DEFAULT ''
);
CREATE TABLE tx_cart_domain_model_order_item (
  donation smallint(1) unsigned NOT NULL DEFAULT '0',
  entendu text,
);

CREATE TABLE tx_pingagaddress_domain_model_gehoerlos (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_lebensalter (
	name varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_angebote (
	name varchar(255) NOT NULL DEFAULT '',
	beschreibung text,
);

CREATE TABLE fe_users (
	addressid  varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_pingagaddress_domain_model_infouser (
	addressid  varchar(255) NOT NULL DEFAULT '',
	zip  varchar(255) NOT NULL DEFAULT '',
	stadt  varchar(255) NOT NULL DEFAULT '',
	land  varchar(255) NOT NULL DEFAULT '',
	telefon  varchar(255) NOT NULL DEFAULT '',
	email  varchar(255) NOT NULL DEFAULT '',
	description  text,
	name varchar(255) NOT NULL DEFAULT '',
	userid  varchar(255) NOT NULL DEFAULT '',
	angeboteid  varchar(255) NOT NULL DEFAULT '',
	lebensalterid  varchar(255) NOT NULL DEFAULT '',
	dienstleistungenid  varchar(255) NOT NULL DEFAULT '',
	kantonesid  varchar(255) NOT NULL DEFAULT '',
	namelebensalter varchar(255) NOT NULL DEFAULT '',
	nameangebote varchar(255) NOT NULL DEFAULT '',
	beschreibungangebote text,

);

CREATE TABLE tx_pingagaddress_domain_model_weiterestandorte (
  address int(11) unsigned DEFAULT '0' NOT NULL,
	strasse  varchar(255) NOT NULL DEFAULT '',
	plz  varchar(255) NOT NULL DEFAULT '',
	ort  varchar(255) NOT NULL DEFAULT '',
	email  varchar(255) NOT NULL DEFAULT '',
	telefon  varchar(255) NOT NULL DEFAULT '',
	url  varchar(255) NOT NULL DEFAULT '',
	breitengrad varchar(255) NOT NULL DEFAULT '',
	laungengrad  varchar(255) NOT NULL DEFAULT '',
	kantone  varchar(255) NOT NULL DEFAULT '',
	beschreibung text,
);