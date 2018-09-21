#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
  tx_wngcvcinews_is_event tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_wngcvcinews_start_date int(11) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_end_date int(11) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_start_time int(11) unsigned DEFAULT '0' NOT NULL,
	tx_wngcvcinews_end_time int(11) unsigned DEFAULT '0' NOT NULL,
	tx_wngcvcinews_all_day tinyint(4) unsigned DEFAULT '0' NOT NULL,

	tx_wngcvcinews_organizer varchar(128) DEFAULT '' NOT NULL,
	tx_wngcvcinews_organizer_id int(11) unsigned DEFAULT '0' NOT NULL,
	tx_wngcvcinews_organizer_pid int(11) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_organizer_link varchar(255) DEFAULT '' NOT NULL,

	tx_wngcvcinews_location varchar(128) DEFAULT '' NOT NULL,
	tx_wngcvcinews_location_id int(11) unsigned DEFAULT '0' NOT NULL,
	tx_wngcvcinews_location_pid int(11) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_location_link varchar(255) DEFAULT '' NOT NULL,

	tx_wngcvcinews_latitude decimal(10,7),
	tx_wngcvcinews_longitude decimal(10,7),
	tx_wngcvcinews_address tinytext,

	tx_wngcvcinews_price tinytext,
	tx_wngcvcinews_url tinytext,
	tx_wngcvcinews_url_title tinytext,
	tx_wngcvcinews_theme tinytext,
	tx_wngcvcinews_type tinytext,
	tx_wngcvcinews_phone tinytext,
	tx_wngcvcinews_apero tinyint(3) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_organisor tinytext,
	tx_wngcvcinews_form tinyint(3) DEFAULT '0' NOT NULL,
	tx_wngcvcinews_participant tinyint(3) DEFAULT '0' NOT NULL,

	tx_wngcvcinews_event_emails int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_wngcvcinews_domain_model_organizer'
#
CREATE TABLE tx_wngcvcinews_domain_model_organizer (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	name varchar(128) DEFAULT '' NOT NULL,
	description text NOT NULL,
	street varchar(128) DEFAULT '' NOT NULL,
	zip varchar(16) DEFAULT '' NOT NULL,
	city varchar(128) DEFAULT '' NOT NULL,
	country_zone varchar(16) DEFAULT '' NOT NULL,
	country varchar(16) DEFAULT '' NOT NULL,
	phone varchar(24) DEFAULT '' NOT NULL,
	fax varchar(24) DEFAULT '' NOT NULL,
	email varchar(64) DEFAULT '' NOT NULL,
	image varchar(64) DEFAULT '' NOT NULL,
	imagecaption text NOT NULL,
	imagealttext text NOT NULL,
	imagetitletext text NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	no_auto_pb tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);

#
# Table structure for table 'tx_wngcvcinews_domain_model_location'
#
CREATE TABLE tx_wngcvcinews_domain_model_location (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	name varchar(128) DEFAULT '' NOT NULL,
	description text NOT NULL,
	street varchar(128) DEFAULT '' NOT NULL,
	zip varchar(16) DEFAULT '' NOT NULL,
	city varchar(128) DEFAULT '' NOT NULL,
	country_zone varchar(16) DEFAULT '' NOT NULL,
	country varchar(16) DEFAULT '' NOT NULL,
	phone varchar(24) DEFAULT '' NOT NULL,
	fax varchar(24) DEFAULT '' NOT NULL,
	email varchar(64) DEFAULT '' NOT NULL,
	image varchar(64) DEFAULT '' NOT NULL,
	imagecaption text NOT NULL,
	imagealttext text NOT NULL,
	imagetitletext text NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	latitude double default '0',
  longitude double default '0',

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	no_auto_pb tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);

#
# Table structure for table 'tx_wngcvcinews_domain_model_eventemail'
#
CREATE TABLE tx_wngcvcinews_domain_model_eventemail (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	firstname varchar(255) DEFAULT '' NOT NULL,
	lastname varchar(255) DEFAULT '' NOT NULL,
	company varchar(255) DEFAULT '' NOT NULL,
	jobfield varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	mobile varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	aperitif tinyint(4) DEFAULT '0' NOT NULL,
	apparaitre tinyint(4) DEFAULT '0' NOT NULL,
	comments text NOT NULL,
	event int(11) unsigned DEFAULT '0',
	user int(11) unsigned DEFAULT '0',

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
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	no_auto_pb tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
  KEY language (l18n_parent,sys_language_uid)
);