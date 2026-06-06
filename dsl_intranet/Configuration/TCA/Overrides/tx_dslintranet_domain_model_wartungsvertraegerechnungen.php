<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraegerechnungen']['columns']['type']['config']['items'] = array(
					array('Zwischenrechnung', 10),
					array('Endabrechnung/Neuer Zeitraum', 20),
					
);

$GLOBALS['TCA']['tx_dslintranet_domain_model_wartungsvertraegerechnungen']['columns']['status']['config']['items'] = array(
					array('Angelegt/Geplant', 10),
					array('Offen/Rechnung schreiben', 20),
					array('Berechnet/Fertig', 30),
					
);

