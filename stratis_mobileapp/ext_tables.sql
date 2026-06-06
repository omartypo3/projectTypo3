#
# Table structure extend for table 'tx_stratismobileapp_domain_model_appsettings'
#
CREATE TABLE tx_stratismobileapp_domain_model_appsettings (
	uid int(11) NOT NULL auto_increment,
	pid int(11) NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,

	version TEXT DEFAULT '',

	PRIMARY KEY (uid)
);
