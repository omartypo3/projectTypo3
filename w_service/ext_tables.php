<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_plugin.label'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'International',
	'International Dealersmap'
);

t3lib_div::loadTCA('tt_content');

/* Add plugin to plugins list */
t3lib_extMgm::addPlugin(array('LLL:EXT:w_service/locallang.xml:service.title', 'wservice_pi1'), 'list_type');
$TCA['tt_content']['types']['list']['subtypes_excludelist']['wservice_pi1'] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['wservice_pi1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('wservice_pi1', 'FILE:EXT:w_service/Configuration/FlexForms/flexform_service.xml');

/* Add plugin to plugins list */
t3lib_extMgm::addPlugin(array('International Dealers map', 'wservice_international', 'FILE:EXT:w_service/ext_icon.gif'), 'CType');
$TCA['tt_content']['types']['list']['subtypes_excludelist']['wservice_international'] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['wservice_international'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('wservice_international', 'FILE:EXT:w_service/Configuration/FlexForms/flexform_international.xml');
/*$TCA['tt_content']['types']['list']['subtypes_excludelist']['wservice_international'] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['wservice_international'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('wservice_international', 'FILE:EXT:w_service/Configuration/FlexForms/flexform_international.xml');*/
//$TCA['tt_content']['types']['wservice_international']['showitem']='CType;;;;;;;;2-2-2,pi_flexform;;;;';
//$TCA['tt_content']['columns']['pi_flexform']['config']['ds'][',wservice_international'] = 'FILE:EXT:w_service/Configuration/FlexForms/flexform_international.xml';

/* Add Plugin to content type list */
t3lib_extMgm::addPlugin(array('LLL:EXT:w_service/locallang.xml:service.title', 'wservice_pi1', 'FILE:EXT:w_service/ext_icon.gif'), 'CType');
$TCA['tt_content']['types']['wservice_pi1']['showitem']='CType;;;;;;;;2-2-2,pi_flexform;;;;';
$TCA['tt_content']['columns']['pi_flexform']['config']['ds'][',wservice_pi1'] = 'FILE:EXT:w_service/Configuration/FlexForms/flexform_service.xml';

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Wagner Service');

if (TYPO3_MODE=='BE')    {
	$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['tx_wservice_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'Classes/class.tx_wservice_wizicon.php';
}


//Service Flexform
$pluginSignature = str_replace('_', '', $_EXTKEY) . '_' . service;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';


t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Wagner Service');
t3lib_extMgm::addLLrefForTCAdescr('tx_wservice_domain_model_category', 'EXT:w_service/Resources/Private/Language/locallang_csh_tx_wservice_domain_model_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wservice_domain_model_category');


$TCA['tx_wservice_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,parent_category,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wservice_domain_model_category.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wservice_domain_model_servicepartner', 'EXT:w_service/Resources/Private/Language/locallang_csh_tx_wservice_domain_model_servicepartner.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wservice_domain_model_servicepartner');
$TCA['tx_wservice_domain_model_servicepartner'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner',
		'label' => 'company',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,company,street,zip,city,industry,phone,cell,fax,email,website,additional,category,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ServicePartner.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wservice_domain_model_servicepartner.gif'
	),
);

?>