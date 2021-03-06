#
# Table structure for table 'pages'
#
CREATE TABLE pages (
  show_subnavigation  TINYINT(4) DEFAULT '0'       NOT NULL,
  image            INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  video            INT(11) UNSIGNED DEFAULT '0'    NOT NULL
);
CREATE TABLE tt_content (
  tx_site_link        VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_radical     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_slide       VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_partner     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_quotes      VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_footer      VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_row         VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_social      VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_country     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_toursorbigslider     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_players     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_spansors     VARCHAR(255) NOT NULL DEFAULT '',
  tx_site_businesslist     VARCHAR(255) NOT NULL DEFAULT '',
  body_text           TEXT,
  link_title          VARCHAR(255) NOT NULL DEFAULT '',
  big_slider          TINYINT(4) DEFAULT '0'       NOT NULL,
  type_slant          TINYINT(4) DEFAULT '0'       NOT NULL
);


CREATE TABLE tx_site_link (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  title            VARCHAR(255)                    NOT NULL DEFAULT '',
  link             VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_radical (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  title            VARCHAR(255)                    NOT NULL DEFAULT '',
  minvalue         VARCHAR(255)                    NOT NULL DEFAULT '',
  maxvalue         VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_slide (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  subtitle         VARCHAR(255)                    NOT NULL DEFAULT '',
  title            VARCHAR(255)                    NOT NULL DEFAULT '',
  link             VARCHAR(255)                    NOT NULL DEFAULT '',
  image            INT(11) UNSIGNED DEFAULT '0'    NOT NULL,

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_partner (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  country         VARCHAR(255)                    NOT NULL DEFAULT '',
  icon            INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  title           VARCHAR(255)                    NOT NULL DEFAULT '',
  content         TEXT                            NOT NULL DEFAULT '',
  link_title      VARCHAR(255)                    NOT NULL DEFAULT '',
  link            VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_quotes (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  title           VARCHAR(255)                    NOT NULL DEFAULT '',
  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  content         TEXT                            NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_footer (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  link            VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_row (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  link            VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_social (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  link            VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_country (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  title            VARCHAR(255)                    NOT NULL DEFAULT '',
  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_toursorbigslider (
  uid             INT(11)                         NOT NULL AUTO_INCREMENT,
  pid             INT(11) DEFAULT '0'             NOT NULL,

  title           VARCHAR(255)                    NOT NULL DEFAULT '',
  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  content         TEXT                            NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_players (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  title            VARCHAR(255)                    NOT NULL DEFAULT '',
  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_spansors (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  image           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_site_businesslist (
  uid              INT(11)                         NOT NULL AUTO_INCREMENT,
  pid              INT(11) DEFAULT '0'             NOT NULL,

  title            VARCHAR(255)                    NOT NULL DEFAULT '',

  parent_uid       INT(11) DEFAULT '0'             NOT NULL,
  deleted          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  hidden           TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sorting          INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_oid        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  t3ver_id         INT(11) DEFAULT '0'             NOT NULL,
  t3ver_wsid       INT(11) DEFAULT '0'             NOT NULL,
  t3ver_label      VARCHAR(255) DEFAULT ''         NOT NULL,
  t3ver_state      TINYINT(4) DEFAULT '0'          NOT NULL,
  t3ver_stage      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_count      INT(11) DEFAULT '0'             NOT NULL,
  t3ver_tstamp     INT(11) DEFAULT '0'             NOT NULL,
  t3ver_move_id    INT(11) DEFAULT '0'             NOT NULL,
  tstamp           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  crdate           INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  cruser_id        INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  starttime        TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  endtime          TINYINT(4) UNSIGNED DEFAULT '0' NOT NULL,
  sys_language_uid INT(11) DEFAULT '0'             NOT NULL,
  l10n_state       INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_parent      INT(11) UNSIGNED DEFAULT '0'    NOT NULL,
  l10n_diffsource  MEDIUMBLOB,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)
);
