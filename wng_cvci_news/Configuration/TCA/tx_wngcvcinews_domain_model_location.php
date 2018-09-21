<?php
defined('TYPO3_MODE') or die();

$extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('wng_cvci_news');

$tx_wngcvcinews_domain_model_location = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',
		'delete' => 'deleted',
		'iconfile' => $extRelPath . 'Resources/Public/Icons/tx_wngcvcinews_domain_model_location.png',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'searchFields' => 'name,description,street,zip,city,country_zone,country,phone,fax,email,image,imagecaption,imagealttext,imagetitletext,link,latitute,longitute'
	),
	'feInterface' => array(
		'fe_admin_fieldList' => 'name'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, name,description,street,zip,city,country,phone,fax,email,image,link'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.name',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '128'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.description',
			'config' => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon' => 'wizard_rte2.gif',
						'module' => array(
							'name' => 'wizard_rte'
						)
					)
				)
			)
		),
		'street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.street',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '128'
			)
		),
		'zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.zip',
			'config' => array(
				'type' => 'input',
				'size' => '15',
				'max' => '15'
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.city',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '128'
			)
		),
		/*'country_zone' => array(
			'exclude' => 1,
			'displayCond' => 'EXT:static_info_tables:LOADED:true',
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.countryzone'
			// Configuration is done depending on the version @see end of this file
		),
		'country' => array(
			'exclude' => 1,
			'displayCond' => 'EXT:static_info_tables:LOADED:true',
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.country'
			// Configuration is done depending on the version @see end of this file
		),*/
		'phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.phone',
			'config' => array(
				'type' => 'input',
				'size' => '15',
				'max' => '24'
			)
		),
		'fax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.fax',
			'config' => array(
				'type' => 'input',
				'size' => '15',
				'max' => '24'
			)
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.email',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '64',
				'eval' => 'lower'
			)
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', array(
				'maxitems' => 5,
				// Use the imageoverlayPalette instead of the basicoverlayPalette
				'foreign_types' => array(
					'0' => array(
						'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette'
					),
					\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
						'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
						--palette--;;filePalette'
					)
				)
			))
		),
		'link' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.link',
			'config' => array(
				'type' => 'input',
				'size' => '25',
				'max' => '128',
				'checkbox' => '',
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'Link',
						'icon' => 'link_popup.gif',
						'module' => array(
							'name' => 'wizard_element_browser',
							'urlParameters' => array(
								'mode' => 'wizard'
							)
						),
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.latitude',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1
			)
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wng_cvci_news/Resources/Private/Language/locallang_db.xml:tx_wngcvcinews_domain_model_location.longitude',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1
			)
		),
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array(
						'LLL:EXT:lang/locallang_general.php:LGL.allLanguages',
						- 1
					),
					array(
						'LLL:EXT:lang/locallang_general.php:LGL.default_value',
						0
					)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array(
						'',
						0
					)
				),
				'foreign_table' => 'tx_wngcvcinews_domain_model_location',
				'foreign_table_where' => 'AND tx_wngcvcinews_domain_model_location.sys_language_uid IN (-1,0)'
			)
		),
		'l18n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type' => 'none',
				'cols' => 27
			)
		)
	),
	'types' => array(
		'0' => array(
			'showitem' => 'name;;1;;2-2-2,description;;;richtext, street, city, country, country_zone, zip, latitude, longitude, phone, fax, email, image, link'
		)
	),
	'palettes' => array(
		'1' => array(
			'showitem' => 'hidden,l18n_parent,sys_language_uid,t3ver_label'
		)
	)
);

/* If wec_map is present, define the address fields */
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('wec_map')){
	$tx_wngcvcinews_domain_model_location['ctrl']['EXT']['wec_map'] = array(
		'isMappable' => 1,
		'addressFields' => array(
			'street' => 'street',
			'city' => 'city',
			'state' => 'country_zone',
			'zip' => 'zip',
			'country' => 'country'
		)
	);
	$tx_wngcvcinews_domain_model_location['columns']['tx_wecmap_geocode'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:wec_map/locallang_db.xml:berecord_geocodelabel',
		'config' => array(
			'type' => 'passthrough',
			'form_type' => 'user',
			'userFunc' => 'tx_wecmap_backend->checkGeocodeStatus'
		)
	);
	$tx_wngcvcinews_domain_model_location['interface']['showRecordFieldList'] .= ', tx_wecmap_geocode';
	$tx_wngcvcinews_domain_model_location['types']['0']['showitem'] .= ', tx_wecmap_geocode';
	
	$tx_wngcvcinews_domain_model_location['columns']['tx_wecmap_map'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:wec_map/locallang_db.xml:berecord_maplabel',
		'config' => array(
			'type' => 'passthrough',
			'form_type' => 'user',
			'userFunc' => 'tx_wecmap_backend->drawMap'
		)
	);
	$tx_wngcvcinews_domain_model_location['interface']['showRecordFieldList'] .= ', tx_wecmap_map';
	$tx_wngcvcinews_domain_model_location['types']['0']['showitem'] .= ', tx_wecmap_map';
}

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('static_info_tables')){
	$tx_wngcvcinews_domain_model_location['columns']['country_zone']['config'] = array(
		'type' => 'select',
		'items' => array(
			array(
				'',
				0
			)
		),
		'foreign_table' => 'static_country_zones',
		'foreign_table_where' => 'ORDER BY static_country_zones.zn_name_en',
		'itemsProcFunc' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\ElementRenderingHelper->translateCountryZonesSelector',
		'size' => 1,
		'minitems' => 0,
		'maxitems' => 1,
		'wizards' => array(
			'suggest' => array(
				'type' => 'suggest',
				'default' => array(
					'receiverClass' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\SuggestReceiver'
				)
			)
		)
	);
	$tx_wngcvcinews_domain_model_location['columns']['country']['config'] = array(
		'type' => 'select',
		'items' => array(
			array(
				'',
				0
			)
		),
		'foreign_table' => 'static_countries',
		'foreign_table_where' => 'ORDER BY static_countries.cn_short_en',
		'itemsProcFunc' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\ElementRenderingHelper->translateCountriesSelector',
		'size' => 1,
		'minitems' => 0,
		'maxitems' => 1,
		'wizards' => array(
			'suggest' => array(
				'type' => 'suggest',
				'default' => array(
					'receiverClass' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\SuggestReceiver'
				)
			)
		)
	);
}

return $tx_wngcvcinews_domain_model_location;