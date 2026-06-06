<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.mitarbeiter.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_zeiteintraegesegmente']['columns']['phase']['config']['foreign_table_where'] = "AND tx_dslintranet_domain_model_phasen.pid=###CURRENT_PID###";

