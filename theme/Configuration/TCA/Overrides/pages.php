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

		// Add icon for new page type:
		\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
			$GLOBALS['TCA']['pages'],
			[
				'ctrl' => [
					'typeicon_classes' => [
						$fluidpageDoktype => 'apps-pagetree-fluidpage',
					],
				],
			]
		);
	},
	'theme',
	'pages'
);

