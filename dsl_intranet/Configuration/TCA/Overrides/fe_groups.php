<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_groups']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['fe_groups']['ctrl']['dynamicConfigFile'])) {
        require_once($GLOBALS['TCA']['fe_groups']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_groups']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dslintranet_fe_groups = [];
    $tempColumnstx_dslintranet_fe_groups[$GLOBALS['TCA']['fe_groups']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['KundenFegroups','Tx_DslIntranet_KundenFegroups']
            ],
            'default' => 'Tx_DslIntranet_KundenFegroups',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_groups', $tempColumnstx_dslintranet_fe_groups);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_groups',
    $GLOBALS['TCA']['fe_groups']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_groups']['ctrl']['label']
);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_groups']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_KundenFegroups']['showitem'] = $GLOBALS['TCA']['fe_groups']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_groups']['types'])) {
    // use first entry in types array
    $fe_groups_type_definition = reset($GLOBALS['TCA']['fe_groups']['types']);
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_KundenFegroups']['showitem'] = $fe_groups_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_KundenFegroups']['showitem'] = '';
}
$GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_KundenFegroups']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundenfegroups,';
$GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_KundenFegroups']['showitem'] .= '';

$GLOBALS['TCA']['fe_groups']['columns'][$GLOBALS['TCA']['fe_groups']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_extbase_type.Tx_DslIntranet_KundenFegroups','Tx_DslIntranet_KundenFegroups'];

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_groups']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_Fegroups']['showitem'] = $GLOBALS['TCA']['fe_groups']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_groups']['types'])) {
    // use first entry in types array
    $fe_groups_type_definition = reset($GLOBALS['TCA']['fe_groups']['types']);
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_Fegroups']['showitem'] = $fe_groups_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_Fegroups']['showitem'] = '';
}
$GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_Fegroups']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_fegroups,';
$GLOBALS['TCA']['fe_groups']['types']['Tx_DslIntranet_Fegroups']['showitem'] .= '';

$GLOBALS['TCA']['fe_groups']['columns'][$GLOBALS['TCA']['fe_groups']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_extbase_type.Tx_DslIntranet_Fegroups','Tx_DslIntranet_Fegroups'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('fe_groups', 'EXT:frontend/Resources/Private/Language/locallang_csh_fe_groups.xlf');

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder