#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	placename varchar(255) DEFAULT '' NOT NULL,
	adresse varchar(255) DEFAULT '' NOT NULL,
	complement_adresse varchar(255) DEFAULT '' NOT NULL,
	is_event tinyint(1) unsigned DEFAULT '0' NOT NULL,
	placeadress text,
	begindate varchar(255) DEFAULT '' NOT NULL,
	finishdate varchar(255) DEFAULT '' NOT NULL,
	beginschedule varchar(255) DEFAULT '' NOT NULL,
	finishschedule varchar(255) DEFAULT '' NOT NULL, 
	linklist text,
	schedules text,
	eventphone varchar(255) DEFAULT '',
	eventmail varchar(255) DEFAULT '',
	rightpicture tinyint(4) unsigned DEFAULT '0' NOT NULL,
	mainpicture varchar(255) DEFAULT '',
	feuser varchar(255) DEFAULT '' NOT NULL,
	uservalidation tinyint(1) unsigned DEFAULT '0' NOT NULL,
	uservalidationtoken varchar(255) DEFAULT '' NOT NULL,
	adminvalidation tinyint(1) unsigned DEFAULT '0' NOT NULL,
	adminvalidationtoken varchar(255) DEFAULT '' NOT NULL,
	youngaudience tinyint(1) unsigned DEFAULT '0' NOT NULL,
	freeentrance tinyint(1) unsigned DEFAULT '0' NOT NULL,
	numberpage int(11) DEFAULT '0' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	iframetitle varchar(255) DEFAULT '' NOT NULL,
	iframe text NOT NULL,
	date_edition int(11) DEFAULT '0' NOT NULL,
	authorpublication varchar(255) DEFAULT '' NOT NULL,
	type_document varchar(255) DEFAULT '' NOT NULL,
	calameo_plugin text,
	calameo_html text,
	bloctexte tinytext,
	town tinytext,
    commandable tinyint(4) unsigned DEFAULT '0' NOT NULL,
	related_annuaire text,
	related_project text,
	related_project_news text,
	related_tools text,
	related_pages text,
	related_subject text,
	dates tinytext,
	toptitle text,
	topteaser text,
	countview int(11) DEFAULT '0' NOT NULL,
	zipcode varchar(255) DEFAULT '',
	contenttitle1 varchar(255) DEFAULT '',
	contenttext1 text,
	contenttitle2 varchar(255) DEFAULT '',
	contenttext2 text,
	contenttitle3 varchar(255) DEFAULT '',
	contenttext3 text,
	contenttitle4 varchar(255) DEFAULT '',
	contenttext4 text,
	contenttitle5 varchar(255) DEFAULT '',
	contenttext5 text,
	section smallint(5) NOT NULL DEFAULT '0'
);

#
# Table structure for table 'tx_enews_domain_model_bloctexte'
#
CREATE TABLE tx_enews_domain_model_bloctexte (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	content text NOT NULL,

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
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_enews_domain_model_commune'
#
CREATE TABLE tx_enews_domain_model_commune (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	zipcode varchar(255) DEFAULT '' NOT NULL,

  image int(11) unsigned DEFAULT '0' NOT NULL,
  intercommunalite varchar(255) DEFAULT '' NOT NULL,
  cantons int(11) unsigned DEFAULT '0' NOT NULL,
  maire varchar(255) DEFAULT '' NOT NULL,
  population varchar(255) DEFAULT '' NOT NULL,
  adresse_mairie varchar(255) DEFAULT '' NOT NULL,
  telephone varchar(255) DEFAULT '' NOT NULL,
  fax varchar(255) DEFAULT '' NOT NULL,
  courriel varchar(255) DEFAULT '' NOT NULL,
  site_internet varchar(255) DEFAULT '' NOT NULL,
  facebook varchar(255) DEFAULT '' NOT NULL,
  twitter varchar(255) DEFAULT '' NOT NULL,
  autreLien varchar(255) DEFAULT '' NOT NULL,

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
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_egmap_domain_model_poi'
#
CREATE TABLE tx_egmap_domain_model_poi (
	enews  int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_enews_domain_model_commune'
#
CREATE TABLE tx_enews_domain_model_commune (
	categories int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Add show in preview to file reference
CREATE TABLE sys_file_reference (
	copyright varchar(255) DEFAULT '' NOT NULL,
	hauteur varchar(255) DEFAULT '' NOT NULL,
	largeur varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_news_domain_model_tag'
#
CREATE TABLE tx_news_domain_model_tag (
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	media int(11) unsigned DEFAULT '0',
);

#
# Table structure for table 'tx_enews_domain_model_dates'
#
CREATE TABLE tx_enews_domain_model_dates (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	begindate int(11) unsigned DEFAULT '0' NOT NULL,
	finishdate int(11) unsigned DEFAULT '0' NOT NULL,
	beginhour varchar(255) DEFAULT '' NOT NULL,
	finishhour varchar(255) DEFAULT '' NOT NULL,
	place varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	addressmore varchar(255) DEFAULT '' NOT NULL,
	zipcode varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,

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
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
  KEY language (l10n_parent,sys_language_uid)
);