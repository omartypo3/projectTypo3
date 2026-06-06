#
# Table structure for table 'sys_file_metadata'
#
CREATE TABLE sys_file_metadata (
	thumbnail varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'sys_file_collection'
#
CREATE TABLE sys_file_collection (
	parentfolder int(11) DEFAULT '0' NOT NULL
);