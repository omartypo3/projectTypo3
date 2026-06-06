<?php

/** Authentication Unique Keys and Salts. */
define('AUTH_KEY',         'lIVzFHtZMyEwcsrvIYbLUNUEIHCzGsTcVJdzADvLaRsAKkbBatZGbODNAXLxdGTG');
define('SECURE_AUTH_KEY',  'KxaJQrQePZrJDdtKwsWoRygVcQNuphyXBlOaerLvDtUVnPStPqggzNQemAwNFRQl');
define('LOGGED_IN_KEY',    'urdRwEPOHTEMJTNhvocgdqnbrZXlDdwPqglaodUGsKbTBEmJHZQutoHnvEoLiEGq');
define('NONCE_KEY',        'glFnaLFroBNrcPwRPHRmCmMcFBUYsbyspPnVZIkPSHHbMQprGsfMmdrJoMjATfBY');
define('AUTH_SALT',        'DqkQraMDHspzPhQrcEZfqLkvAykEyCyMOeJaKBtlufgpLSPrbruFjOwgaHPNgCrV');
define('SECURE_AUTH_SALT', 'zznRDSsgLthoVFqCZulvodlxpDZNhiZutTarDXoFVYMoYacXnVFdTpDXrgkFjwln');
define('LOGGED_IN_SALT',   'DWDDkrQPkPctkWtSSPAkLeAVsKPhKYkVrkrvJCNzQzlgwyaDFufCwEEKleMOCJBM');
define('NONCE_SALT',       'AEovytMTZAPkqIJlorbsKEIbPzYXwsSDNpOAQFshSTqILoWRTGfObpNKflYdbcoR');

/** Absolute path to the WordPress directory. */
if (!defined("ABSPATH")) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

// Include for settings managed by t3terminal.
$ddev_settings = dirname(__FILE__) . '/wp-config-t3terminal.php';
if(file_exists($ddev_settings)) {
  require_once($ddev_settings);
}

/** Define the database table prefix */
$table_prefix  = 'wp_';

/** Include wp-settings.php */
if (file_exists(ABSPATH . '/wp-settings.php')) {
  require_once ABSPATH . '/wp-settings.php';
}
