<?php

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.mitarbeiter.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['kunde']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Kunden' AND fe_users.pid=###PAGE_TSCONFIG_ID###";

$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['laufzeit']['config']['items'] = array(
					array('1 Monat', 10),
					array('3 Monate', 30),
					array('6 Monate', 60),
					array('12 Monate', 120),

);

$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['re_intervall']['config']['items'] = array(
					array('1 Monat', 10),
					array('3 Monate', 30),
					array('6 Monate', 60),
					array('12 Monate', 120),

);


$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['kuendigungs_frist']['config']['items'] = array(

					array('3 Monate', 30)

);

$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['sichtbarkeit']['config']['type'] = 'check';
$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['sichtbarkeit']['config']['items'] = array(
					array('im Kundenbereich Anzeigen', 1),
				);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['sichtbarkeit']['config']['size']);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['sichtbarkeit']['config']['maxitems']);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraege']['columns']['sichtbarkeit']['config']['required']);
