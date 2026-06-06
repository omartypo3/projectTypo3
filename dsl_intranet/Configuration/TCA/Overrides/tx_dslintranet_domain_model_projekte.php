<?php
defined('TYPO3_MODE') || die();
/*
if (!isset($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['dynamicConfigFile'])) {
        require_once($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_agenturvertraege = [];
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_agenturvertraege[$GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['KundenAgenturvertraege','Tx_DslIntranet_KundenAgenturvertraege']
            ],
            'default' => 'Tx_DslIntranet_KundenAgenturvertraege',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_dslintranet_domain_model_agenturvertraege', $tempColumnstx_dslintranet_tx_dslintranet_domain_model_agenturvertraege);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_dslintranet_domain_model_agenturvertraege',
    $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['label']
);
*/
/* inherit and extend the show items from the parent class */
/*
if (isset($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['1']['showitem'])) {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['Tx_DslIntranet_KundenAgenturvertraege']['showitem'] = $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['1']['showitem'];
} elseif(is_array($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types'])) {
    // use first entry in types array
    $tx_dslintranet_domain_model_agenturvertraege_type_definition = reset($GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']);
    $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['Tx_DslIntranet_KundenAgenturvertraege']['showitem'] = $tx_dslintranet_domain_model_agenturvertraege_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['Tx_DslIntranet_KundenAgenturvertraege']['showitem'] = '';
}
$GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['Tx_DslIntranet_KundenAgenturvertraege']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundenagenturvertraege,';
$GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['types']['Tx_DslIntranet_KundenAgenturvertraege']['showitem'] .= '';

$GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['columns'][$GLOBALS['TCA']['tx_dslintranet_domain_model_agenturvertraege']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_agenturvertraege.tx_extbase_type.Tx_DslIntranet_KundenAgenturvertraege','Tx_DslIntranet_KundenAgenturvertraege'];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    '',
    'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);
*/
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

//nötig für backend dateierweiterungsvalidierung
//http://www.typo3.net/forum/thematik/zeige/thema/120073/
$GLOBALS['TCA']['tx_dslintranet_domain_model_projekte']['columns']['vertrag']['config']['foreign_selector_fieldTcaOverride']['config']['appearance']['elementBrowserAllowed']='pdf';
$GLOBALS['TCA']['tx_dslintranet_domain_model_projekte']['columns']['vertrag']['config']['filter'][0]['parameters']['allowedFileExtensions']='pdf';
//$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['disallowedFileExtensions']='...(php)';
$GLOBALS['TCA']['tx_dslintranet_domain_model_projekte']['columns']['vertrag']['config']['foreign_match_fields'] = array(
						'fieldname' => 'vertrag',
						'tablenames' => 'tx_dslintranet_domain_model_projekte',
						'table_local' => 'sys_file'
);