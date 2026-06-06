<?php
defined('TYPO3_MODE') || die();

/*if (!isset($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['type'])) {
    if (file_exists(isset($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['dynamicConfigFile']))) {
        require_once($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_dateien = [];
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_dateien[$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['KundenDateien','Tx_DslIntranet_KundenDateien']
            ],
            'default' => 'Tx_DslIntranet_KundenDateien',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_dslintranet_domain_model_dateien', $tempColumnstx_dslintranet_tx_dslintranet_domain_model_dateien);
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_dslintranet_domain_model_dateien',
    $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['label']
);


/* inherit and extend the show items from the parent class */
/*
if (isset($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['1']['showitem'])) {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['Tx_DslIntranet_KundenDateien']['showitem'] = $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['1']['showitem'];
} elseif(is_array($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types'])) {
    // use first entry in types array
    $tx_dslintranet_domain_model_dateien_type_definition = reset($GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']);
    $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['Tx_DslIntranet_KundenDateien']['showitem'] = $tx_dslintranet_domain_model_dateien_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['Tx_DslIntranet_KundenDateien']['showitem'] = '';
}
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['Tx_DslIntranet_KundenDateien']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundendateien,';
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['types']['Tx_DslIntranet_KundenDateien']['showitem'] .= '';

$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns'][$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_dateien.tx_extbase_type.Tx_DslIntranet_KundenDateien','Tx_DslIntranet_KundenDateien'];
*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'dsl_intranet',
    'EXT:/Resources/Private/Language/locallang_csh_tx_dslintranet_domain_model_dateien.xlf'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



//nötig für backend dateierweiterungsvalidierung
//http://www.typo3.net/forum/thematik/zeige/thema/120073/
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['foreign_selector_fieldTcaOverride']['config']['appearance']['elementBrowserAllowed']='iif,pdf';
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['allowedFileExtensions']='iif,pdf';
//$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['disallowedFileExtensions']='...(php)';
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['foreign_match_fields'] = array(
						'fieldname' => 'datei',
						'tablenames' => 'tx_dslintranet_domain_model_dateien',
						'table_local' => 'sys_file'
);

//scheint jedoch nicht zu greifen
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['maxitems']=1;
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['minitems']=1;
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['appearance']['enabledControls']['dragdrop']=false;
$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['appearance']['enabledControls']['localize']=false;
//end

$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['type']['config']['items'] = array(
					array('Kunden Import aus Quickbooks', 10),
					array('KD Angebot', 20),
					array('Rechnung', 30),
					array('Rechnung Agenturvertrag', 35),
					array('Auftragsdokumente ', 50),//in Aufträgen
	
					array('LR Angebot', 40),
					array('Logos / Vektoren / Druckdaten', 60),
					array('Fotos', 70),
					/*array('Korrekturabzug', 80),
					array('Druckdaten', 90), am 22.08.2019 abgewählt wird nicht genutzt bzw. korrekturabzüge und druckdaten müssen im auftrag hochgeladen werden*/
					array('Sonstige Dokumente', 100),//im Dokumentencenter
);


$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['crdate'] = array(
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

$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['tstamp'] = array(
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