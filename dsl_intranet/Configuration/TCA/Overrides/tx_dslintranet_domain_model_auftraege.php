<?php


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.mitarbeiter.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['kunde']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Kunden' AND fe_users.pid=###PAGE_TSCONFIG_ID###";
/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.mitarbeiter.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['mitarbeiter']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Mitarbeiter' AND fe_users.pid=###PAGE_TSCONFIG_ID###";
/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.ansprechpartner.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['ansprechpartner']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Mitarbeiter' AND fe_users.pid=###PAGE_TSCONFIG_ID###";


/*
http://www.typo3lexikon.de/typo3-tutorials/tipps-und-tricks/marker-in-flexforms.html
TSConfig: TCEFORM.tx_dslintranet_domain_model_auftraege.fegroups.PAGE_TSCONFIG_ID = 7
*/
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['fegroups']['config']['foreign_table_where'] = "AND fe_groups.tx_extbase_type = 'Tx_DslIntranet_Fegroups'  AND fe_groups.pid=###PAGE_TSCONFIG_ID###";
/*Achtung problem / fehlerhaft?!*/
/*fegroups*/


$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['auftragsart']['config']['foreign_table_where'] = "AND tx_dslintranet_domain_model_auftragsarten.pid=###CURRENT_PID###";

$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] = array(
					array('Vorbereitet/Angelegt durch Kunde', 5),//nur in Kundenansicht
					array('Angebot schreiben', 10),					
					array('Angeboten', 20),
					array('Auftrag Erteilt', 30),
					array('in Bearbeitung', 40),
					array('in Produktion', 50),
					array('Rechnung schreiben', 60),
					array('Abgeschlossen/Archiv', 70)
);
/*
vor absprache vom 24.08.16
					array('in Auslieferung', 60),
					array('Rechnung schreiben', 70),
					array('Auftrag Abgeschlossen', 80)
*/

$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['prioritaet']['config']['items'] = array(
					array('A', 10),
					array('B', 20),
					array('C', 30)
);


$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['phasen']['config']['foreign_table_where'] = "AND tx_dslintranet_domain_model_phasen.pid=###CURRENT_PID###";

$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['sichtbarkeit']['config']['type'] = 'check';
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['sichtbarkeit']['config']['items'] = array(
					array('im Kundenbereich Anzeigen', 1),
				);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['sichtbarkeit']['config']['size']);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['sichtbarkeit']['config']['maxitems']);
unset($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['sichtbarkeit']['config']['required']);


$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['per']['config']['items'] = array(
					array('E-Mail', 30),
					array('Fax', 20),
					array('Persönlich', 40),
					array('Telefon', 10),
					array('WhatsApp', 50)
);

$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['verechnung_agenturvertrag_fremdkosten_inklusive']['config']['items']
 = array(
					array('Bei Auftragsart Agenturvertrag auswählen', 0),
					array('Ja', 10),
					array('Nein', 20)
					
);
$GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['verechnung_agenturvertrag_nutzungsfaktor_inklusive']['config']['items']
 = array(
					array('Bei Auftragsart Agenturvertrag auswählen', 0),
					array('Ja', 10),
					array('Nein', 20)
					
);
 