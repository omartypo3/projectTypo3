#
# Table structure for table 'tx_silcoplastproduct_domain_model_product'
#
CREATE TABLE tx_silcoplastproduct_domain_model_product (

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	images int(11) unsigned NOT NULL default '0',
	categorie int(11) unsigned DEFAULT '0',

);
#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
  icon int(11) unsigned NOT NULL default '0',
  icong int(11) unsigned NOT NULL default '0',
  type_cat varchar(255) DEFAULT '' NOT NULL,
);
