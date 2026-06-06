<?php
defined('TYPO3') || die('Access denied.');

$tx_enews_domain_model_dates = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates',
		'label' => 'begindate',
        'label_alt' => 'finishdate',
        'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
        
		'hideTable' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'place, adress, adressmore, city,',
		'iconfile' => 'Ext:e_news/Resources/Public/Icons/tx_enews_domain_model_commune.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, zipcode',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, begindate, finishdate, beginhour,  finishhour, place, address, addressmore, city'),
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
		'begindate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.begindate',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'finishdate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.finishdate',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'beginhour' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.beginhour',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			)
		),
		'finishhour' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.finishhour',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			)
		),
		'place' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.place',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.address',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		),
		'addressmore' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.addressmore',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
			)
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:e_news/Resources/Private/Language/locallang_db.xlf:tx_enews_domain_model_dates.city',
			'config' => array(
				'type' => 'input',
				'size' => 48,
			)
		)
	),
);

return $tx_enews_domain_model_dates;