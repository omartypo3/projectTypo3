	<?php 
defined('TYPO3') || die('Access denied.');

$GLOBALS['TCA']['tx_powermail_domain_model_field']['columns']['type']['config']['items']['multirecipients'] = array('Multi-destinataires', 'multirecipients');

$multiRecipFields = array(  
	'optionsmails' => array(
		'exclude' => 1,
		'label' => "LLL:EXT:e_powermail_multirecip/Resources/Private/Language/locallang.xlf:tx_epowermailmultirecip_xml.options",
		'config' => array(
			'type' => "text",
			'cols' => 30,
			'rows' => 5
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
     'tx_powermail_domain_model_field',
     $multiRecipFields,
     1
);

$selectShowitem = $GLOBALS['TCA']['tx_powermail_domain_model_field']['types']['select']['showitem'];

$tabsArray = explode('--div--;',$selectShowitem);
$tabsArray[0] = 'settings, optionsmails, mandatory,';

$listFields = implode('--div--;', $tabsArray);

$GLOBALS['TCA']['tx_powermail_domain_model_field']['types']['multirecipients']['showitem'] = $listFields;

// The 'interface' section is deprecated in TYPO3 v13, only add if it exists for backwards compatibility
if (isset($GLOBALS['TCA']['tx_powermail_domain_model_field']['interface']['showRecordFieldList'])) {
    $GLOBALS['TCA']['tx_powermail_domain_model_field']['interface']['showRecordFieldList'] .= ',optionsmails';
}