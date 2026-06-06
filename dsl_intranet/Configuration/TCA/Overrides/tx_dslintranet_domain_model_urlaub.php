<?php 
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder


$GLOBALS['TCA']['tx_dslintranet_domain_model_urlaub']['columns']['mitarbeiter']['config']['foreign_table_where'] = "AND fe_users.tx_extbase_type = 'Tx_DslIntranet_Mitarbeiter'";

$GLOBALS['TCA']['tx_dslintranet_domain_model_urlaub']['columns']['status']['config']['items'] = array(
					array('Beantragt', 10),
					array('Bestätigt', 20),
					array('Abgelehnt', 30)

);

$GLOBALS['TCA']['tx_dslintranet_domain_model_urlaub']['columns']['crdate'] = array(
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