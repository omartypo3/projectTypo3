<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key,pages';

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/','Météo Suisse');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('LLL:EXT:mt_meteo/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY . '_pi1'), 'list_type', 'mt_meteo');
#\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
    # 'LLL:EXT:mt_meteo/locallang_db.xml:tt_content.list_type_pi1',
    #$_EXTKEY . '_pi1',
    #\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'ext_icon.gif'
#),'list_type');



if (TYPO3_MODE === 'BE') {
	#$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mtmeteo_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'pi1/class.tx_mtmeteo_pi1_wizicon.php';
}
?>