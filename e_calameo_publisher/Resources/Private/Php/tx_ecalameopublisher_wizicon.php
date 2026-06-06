<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ian SEBBAGH <isebbagh@e-magineurs.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/



/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */




/**
 * Class that adds the wizard icon.
 *
 * @author	Ian SEBBAGH <isebbagh@e-magineurs.com>
 * @package	TYPO3
 * @subpackage	tx_ecalameopublisher
 */

use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

class tx_ecalameopublisher_wizicon
{

	private const EXTENSION_KEY = 'e_calameo_publisher';
	private const LANGUAGE_FILE = 'EXT:e_calameo_publisher/Resources/Private/Language/locallang.xml';

	public function __construct(protected readonly LanguageServiceFactory $languageServiceFactory) {}
	/**
	 * Processing the wizard items array
	 *
	 * @param	array		$wizardItems: The wizard items
	 * @return	Modified array with wizard items
	 */
	function proc($wizardItems)
	{
		$languageService = $this->getLanguageService();

		$iconPath = PathUtility::getAbsoluteWebPath(
			ExtensionManagementUtility::extPath(self::EXTENSION_KEY) . 'Resources/Public/Img/ce_wiz.png'
		);
		$wizardItems['plugins_tx_ecalameopublisher_pi1'] = array(
			'icon' => $iconPath,
			'title' => $languageService->sL(self::LANGUAGE_FILE . ':pi1_title'),
			'description' => $languageService->sL(self::LANGUAGE_FILE . ':pi1_plus_wiz_description'),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=ecalameopublisher_ecalameo'
		);

		return $wizardItems;
	}

	/**
	 * Get the language service
	 *
	 * @return LanguageService
	 */
	protected function getLanguageService(): LanguageService
	{
		if (isset($GLOBALS['BE_USER'])) {
			return $this->languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
		}

		// Fallback to default language
		return $this->languageServiceFactory->create('default');
	}
}
