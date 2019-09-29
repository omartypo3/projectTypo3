<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FRONTAL.fag_institution_management',
	'Directoryservices',
	'Directory services (List & Single)'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FRONTAL.fag_institution_management',
	'Peopleregister',
	'People register (List & Single)'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FRONTAL.fag_institution_management',
	'Citycouncil',
	'City council'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FRONTAL.fag_institution_management',
	'Onlineswitch',
	'Online switch'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'FRONTAL.fag_institution_management',
    'NextStepLogin',
    'Next Step Login'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'FRONTAL.fag_institution_management',
    'Terminal',
    'Terminal'
);
//include flexform
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['faginstitutionmanagement_directoryservices'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('faginstitutionmanagement_directoryservices', 'FILE:EXT:fag_institution_management/Configuration/FlexForms/InstitutionFlexform.xml');
