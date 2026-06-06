<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


$GLOBALS['TCA']['tx_dslintranet_domain_model_phasen']['columns']['sorting'] = array(
	'exclude'	=> 1,
	'label'		=> 'sorting',
	'config'	=> array(
		'type' => 'input',
		'size' => 6,
		'eval' => '',
		'readOnly' => 1
	),
);