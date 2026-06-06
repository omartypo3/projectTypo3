<?php
defined('TYPO3') || die('Access denied.');

$confExtTplNews = [];
try {
    $confExtTplNews = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('e_news');
} catch (\Exception $e) {
}

$typeId = $confExtTplNews['type_annuaire'] ?? '';
$typeAnnuaire = $typeId;
        

$tx_enews_domain_model_commune = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune',
		'label' => 'title',
        'label_alt' => 'zipcode',
        'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,zipcode,',
		'iconfile' => 'Ext:e_news/Resources/Public/Icons/tx_enews_domain_model_commune.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, zipcode',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, zipcode, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
                'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_enews_domain_model_commune',
				'foreign_table_where' => 'AND tx_enews_domain_model_commune.pid=###CURRENT_PID### AND tx_enews_domain_model_commune.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
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
		),
		'endtime' => array(
			'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
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
		),

		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zipcode' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim'
			)
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.image',
			'config' => array(
				'type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'maxitems' => 1,
			),
		),
		'intercommunalite' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.intercommunalite',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'maire' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.maire',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'population' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.population',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'adresse_mairie' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.adresse_mairie',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
			)
		),
		'telephone' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'fax' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.fax',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'courriel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.courriel',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'site_internet' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.site_internet',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'facebook' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.facebook',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'twitter' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.twitter',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'autreLien' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.autreLien',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),		
	),
);

$activeCompleteCommune = $confExtTplNews['activeCompleteCommune'] ?? false;
 
if($activeCompleteCommune){
    // On crée un nouvel onglet pour les dates et on y met les champs correspondants
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_enews_domain_model_commune',
        ',image, intercommunalite, maire, population, adresse_mairie, telephone, fax, courriel, site_internet, facebook, twitter varchar, autreLien',
        '',
        'after:zipcode'
    );
}   

if(TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('e_annuaires')){
	$GLOBALS['TCA']['tx_enews_domain_model_commune']['columns']['cantons'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_commune.cantons',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('', 0),
			),
			'foreign_table' => 'tx_eannuaires_domain_model_fiche',
			'foreign_table_where' => ' 
				AND tx_eannuaires_domain_model_fiche.deleted=0 
				AND tx_eannuaires_domain_model_fiche.hidden=0 
				AND tx_eannuaires_domain_model_fiche.typeelement = "'.$typeAnnuaire.'"',
		)
	);


    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_enews_domain_model_commune',
        ',cantons',
        '',
        'after:intercommunalite'
    );
}    

return $tx_enews_domain_model_commune;
