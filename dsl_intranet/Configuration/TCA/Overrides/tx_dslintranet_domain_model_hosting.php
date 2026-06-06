<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


// TCEFORM.tx_dslintranet_domain_model_hosting.kunde.PAGE_TSCONFIG_ID = 8
$GLOBALS['TCA']['tx_dslintranet_domain_model_hosting']['columns']['kunde']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Kunden' AND fe_users.pid=###PAGE_TSCONFIG_ID###";//AND fe_users.pid=###PAGE_TSCONFIG_ID###