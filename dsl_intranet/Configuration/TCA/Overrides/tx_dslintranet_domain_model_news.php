<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['type'])) {
    if (file_exists(isset($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['dynamicConfigFile']))) {
        require_once($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    /*$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_news = [];
    $tempColumnstx_dslintranet_tx_dslintranet_domain_model_news[$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['KundenNews','Tx_DslIntranet_KundenNews']
            ],
            'default' => 'Tx_DslIntranet_KundenNews',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_dslintranet_domain_model_news', $tempColumnstx_dslintranet_tx_dslintranet_domain_model_news);
*/}

/*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_dslintranet_domain_model_news',
    $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['label']
);*/

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['1']['showitem'])) {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['Tx_DslIntranet_KundenNews']['showitem'] = $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['1']['showitem'];
} elseif(is_array($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types'])) {
    // use first entry in types array
    $tx_dslintranet_domain_model_news_type_definition = reset($GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']);
    $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['Tx_DslIntranet_KundenNews']['showitem'] = $tx_dslintranet_domain_model_news_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['Tx_DslIntranet_KundenNews']['showitem'] = '';
}
$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['Tx_DslIntranet_KundenNews']['showitem'] .= ',--div--;LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_kundennews,';
$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['types']['Tx_DslIntranet_KundenNews']['showitem'] .= '';

//$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['columns'][$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dsl_intranet/Resources/Private/Language/locallang_db.xlf:tx_dslintranet_domain_model_news.tx_extbase_type.Tx_DslIntranet_KundenNews','Tx_DslIntranet_KundenNews'];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'dsl_intranet',
    'EXT:dsl_intranet/Resources/Private/Language/locallang_csh_tx_dslintranet_domain_model_news.xlf'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

//nötig für backend dateierweiterungsvalidierung
//http://www.typo3.net/forum/thematik/zeige/thema/120073/
$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['columns']['datei']['config']['foreign_selector_fieldTcaOverride']['config']['appearance']['elementBrowserAllowed']='jpg,png';
$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['columns']['datei']['config']['filter'][0]['parameters']['allowedFileExtensions']='jpg,png';
//$GLOBALS['TCA']['tx_dslintranet_domain_model_dateien']['columns']['datei']['config']['filter'][0]['parameters']['disallowedFileExtensions']='...(php)';
$GLOBALS['TCA']['tx_dslintranet_domain_model_news']['columns']['datei']['config']['foreign_match_fields'] = array(
						'fieldname' => 'datei',
						'tablenames' => 'tx_dslintranet_domain_model_news',
						'table_local' => 'sys_file'
);