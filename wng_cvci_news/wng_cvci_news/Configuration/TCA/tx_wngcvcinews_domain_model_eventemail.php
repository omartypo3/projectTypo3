<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('wng_cvci_news');

$tx_wngcvcinews_domain_model_eventemail = array(
	//'ctrl' => $GLOBALS['TCA']['tx_wngcvcinews_domain_model_eventemail']['ctrl'],
	'ctrl' => array(
		'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_eventemail',
		'label' => 'email',
		'label_alt' => 'firstname,lastname',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY event',
		'delete' => 'deleted',
		'iconfile' => $extRelPath . 'Resources/Public/Icons/tx_wngcvcinews_domain_model_eventemail.png',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'searchFields' => 'firstname, lastname, company, jobfield, address, zip, city, phone, mobile, email, aperitif, apparaitre, comments, event, user'
	),
	'feInterface' => array(
		'fe_admin_fieldList' => 'email'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l18n_parent, l18n_diffsource, hidden, firstname, lastname, company, jobfield, address, zip, city, phone, mobile, email, aperitif, apparaitre, comments, event, user',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, firstname, lastname, company, jobfield, address, zip, city, phone, mobile, email, aperitif, apparaitre, comments, event, user, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_wngcvcinews_domain_model_eventemail',
				'foreign_table_where' => 'AND tx_wngcvcinews_domain_model_eventemail.pid=###CURRENT_PID### AND tx_wngcvcinews_domain_model_eventemail.sys_language_uid IN (-1,0)',
			),
		),
		'l18n_diffsource' => array(
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
			'l18n_mode' => 'mergeIfNotBlank',
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
			'l18n_mode' => 'mergeIfNotBlank',
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

		'firstname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.firstname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lastname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.lastname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'company' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.company',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'jobfield' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.jobfield',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'phone' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'mobile' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.mobile',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'aperitif' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.aperitif',
			'config' => array(
				'type' => 'check',
			),
		),
		'apparaitre' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.apparaitre',
			'config' => array(
				'type' => 'check',
			),
		),
		'comments' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.comments',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		/*'event' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.event',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_news_domain_model_news',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.user',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),*/
		'event' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.event',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_news_domain_model_news',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest'
					)
				)
			)
		),
		'user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xlf:tx_wngcvcinews_domain_model_eventemail.user',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'fe_users',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest'
					)
				)
			)
		),
		
	),
);

return $tx_wngcvcinews_domain_model_eventemail;