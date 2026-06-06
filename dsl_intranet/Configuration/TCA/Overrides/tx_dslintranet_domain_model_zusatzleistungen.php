<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$GLOBALS['TCA']['tx_dslintranet_domain_model_zusatzleistungen']['columns']['laufzeit']['config']['items'] = array(
					array('1 Monat', 10),
					array('3 Monate', 30),
					array('6 Monate', 60),
					array('12 Monate', 120),

);

$GLOBALS['TCA']['tx_dslintranet_domain_model_zusatzleistungen']['ctrl']['label'] = 'titel';
$GLOBALS['TCA']['tx_dslintranet_domain_model_zusatzleistungen']['ctrl']['label_alt'] = 'preis_monatlich';
$GLOBALS['TCA']['tx_dslintranet_domain_model_zusatzleistungen']['ctrl']['label_alt_force'] = 1;