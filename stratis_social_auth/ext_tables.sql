#
# Table structure for table 'tx_stratissocialauth_domain_model_configuration'
#
CREATE TABLE tx_stratissocialauth_domain_model_configuration (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,
    type varchar(255) DEFAULT '' NOT NULL,
    storage_pid int(11) DEFAULT '0' NOT NULL,
    default_groups varchar(255) DEFAULT '' NOT NULL,
    providers varchar(255) DEFAULT '' NOT NULL,

    mail_sender_name varchar(255) DEFAULT '' NOT NULL,
    mail_sender_email varchar(255) DEFAULT '' NOT NULL,
    mail_subject varchar(255) DEFAULT '' NOT NULL,
    mail_body text,

    PRIMARY KEY (uid)
);

#
# Table structure for table 'tx_stratissocialauth_domain_model_provider'
#
CREATE TABLE tx_stratissocialauth_domain_model_provider (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,
    key_id varchar(255) DEFAULT '' NOT NULL,
    key_secret varchar(255) DEFAULT '' NOT NULL,
    open_id_url varchar(255) DEFAULT '' NOT NULL,
    type varchar(255) DEFAULT '' NOT NULL,
    scope varchar(255) DEFAULT '' NOT NULL,
    acr_values varchar(255) DEFAULT '' NOT NULL,
    display varchar(255) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid)
);

#
# Table structure for table 'tx_stratissocialauth_domain_model_social_account'
#
CREATE TABLE tx_stratissocialauth_domain_model_social_account (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,

    user varchar(255) DEFAULT '' NOT NULL,
    provider varchar(255) DEFAULT '' NOT NULL,
    identifier varchar(255) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid)
);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
    social_accounts  varchar(255) DEFAULT '' NOT NULL,
    civility tinyint(4) DEFAULT '0' NOT NULL,
    gender tinyint(1) DEFAULT '0' NOT NULL,
    created_by_france_connect tinyint(4) DEFAULT '0' NOT NULL,
);
