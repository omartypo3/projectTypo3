<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/Typoscript', 'Avonis Theme');

\FluidTYPO3\Flux\Core::registerProviderExtensionKey('avonis_theme', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('avonis_theme', 'Content');


