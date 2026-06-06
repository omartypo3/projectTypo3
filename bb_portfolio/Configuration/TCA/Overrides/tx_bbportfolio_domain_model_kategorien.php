<?php


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['tx_bbportfolio_domain_model_kategorien']['ctrl']['label'] = 'name';
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_kategorien']['ctrl']['label_alt'] = 'alias';
#$GLOBALS['TCA']['tx_bbportfolio_domain_model_kategorien']['ctrl']['label_alt_force'] = 1;
$GLOBALS['TCA']['tx_bbportfolio_domain_model_kategorien']['columns']['alias']['config']['eval'] = 'trim,alphanum_x,nospace,lower,unique,required';
	