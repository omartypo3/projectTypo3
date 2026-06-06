<?php


## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


$GLOBALS['TCA']['tx_dslintranet_domain_model_notification']['columns']['art']['config']['items'] = array(
					array('Mitarbeiter zum Auftrag hinzugefügt', 10),
					array('B', 20),
					array('C', 30)
);

$GLOBALS['TCA']['tx_dslintranet_domain_model_notification']['columns']['crdate'] = array(
    			'exclude' => 1,
    			'config' => array(
    				'type' => 'input',
    				'size' => 13,
    				'max' => 20,
    				'eval' => 'datetime',
    				'checkbox' => 0,
    				'default' => 0,
    				'range' => array(
    					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
    				),
    			),
    		);