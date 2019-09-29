#
# Table structure for table 'tx_pingag_clic_connector_job'
#
CREATE TABLE tx_pingag_clic_connector_job (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	id varchar(255) DEFAULT '0' NOT NULL,
	cms_id varchar(255) DEFAULT '0' NOT NULL,
	main_category_id varchar(255) DEFAULT '0' NOT NULL,
	category_id varchar(255) DEFAULT '0' NOT NULL,
	wlcheading_id int(11) DEFAULT '0' NOT NULL,
	type varchar(100) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '0' NOT NULL,
	zip varchar(100) DEFAULT '0' NOT NULL,

	publication_level int(11) DEFAULT '0' NOT NULL,
	client_id int(11) DEFAULT '0' NOT NULL,
	job_type_id varchar(255) DEFAULT '0' NOT NULL,
	quota_id varchar(255) DEFAULT '0' NOT NULL,

	max_quota varchar(100) DEFAULT '0' NOT NULL,
	min_quota varchar(100) DEFAULT '0' NOT NULL,
	quota_from varchar(100) DEFAULT '0' NOT NULL,
	quota_to varchar(100) DEFAULT '0' NOT NULL,

	detail_url mediumtext,
	country_code varchar(10) DEFAULT '0' NOT NULL,
	language_code varchar(10) DEFAULT '0' NOT NULL,

	external_url varchar(255) DEFAULT '0' NOT NULL,
	source_deeplink_url varchar(255) DEFAULT '0' NOT NULL,
	contact_email varchar(255) DEFAULT '0' NOT NULL,
	companyname varchar(255) DEFAULT '0' NOT NULL,
	contact_companyname varchar(255) DEFAULT '0' NOT NULL,

	ad_id varchar(255) DEFAULT '0' NOT NULL,
	updated_at varchar(255) DEFAULT '0' NOT NULL,
	insert_at varchar(255) DEFAULT '0' NOT NULL,
	publication_date varchar(255) DEFAULT '0' NOT NULL,
	publication_start_date varchar(255) DEFAULT '0' NOT NULL,

	avalable_from_id varchar(255) DEFAULT '0' NOT NULL,
	avalable_from varchar(255) DEFAULT '0' NOT NULL,
	transaction_type_id varchar(255) DEFAULT '0' NOT NULL,

	prop_medbase_section varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_section_de varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_section_fr varchar(255) DEFAULT '0' NOT NULL,

	prop_medbase_type varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_type_de varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_type_fr varchar(255) DEFAULT '0' NOT NULL,

	prop_medbase_location varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_location_de varchar(255) DEFAULT '0' NOT NULL,
	prop_medbase_location_fr varchar(255) DEFAULT '0' NOT NULL,

	version int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	editlock tinyint(4) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,

	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	fe_group varchar(100) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY sys_language_uid_l10n_parent (sys_language_uid,l10n_parent)
);

#
# Table structure for table 'tx_pingag_clic_connector_job_subscription'
#
CREATE TABLE tx_pingag_clic_connector_job_subscription (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	email varchar(255) DEFAULT '0' NOT NULL,
	first_name varchar(255) DEFAULT '0' NOT NULL,
	last_name varchar(255) DEFAULT '0' NOT NULL,
	sections varchar(255) DEFAULT '0' NOT NULL,

	version int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	editlock tinyint(4) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,

	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	fe_group varchar(100) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY sys_language_uid_l10n_parent (sys_language_uid,l10n_parent)
);