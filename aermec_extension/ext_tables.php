<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'AermecExtension.' . $_EXTKEY,
	'Aermecextension',
	'Aermec Extension'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Aermec Extension with Extbase and Fluid');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_aermecextension_domain_model_aermecextension', 'EXT:aermec_extension/Resources/Private/Language/locallang_csh_tx_aermecextension_domain_model_aermecextension.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_aermecextension_domain_model_aermecextension');
