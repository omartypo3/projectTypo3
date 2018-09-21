<?php

/**
 * add custom doktype 'Fluidpage Page'
 */
call_user_func(
	function ( $extKey, $table ) {

		$extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey);
		$customPageIcon = $extRelPath . 'Resources/Public/Icons/Page/Fluidpage.svg';
		$fluidpageDoktype = 120;

		// Add new page type as possible select item:
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'Fluid Page',
				$fluidpageDoktype,
				$customPageIcon
			],
			'1',
			'after'
		);
	},
	'theme',
	'pages_language_overlay'
);
