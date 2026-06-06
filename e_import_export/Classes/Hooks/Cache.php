<?php
namespace Emagineurs\EImportExport\Hooks;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Cache
 */
class Cache implements ClearCacheActionsHookInterface {
	/**
	 * Modifies CacheMenuItems array
	 *
	 * @param array $cacheActions Array of CacheMenuItems
	 * @param array $optionValues Array of AccessConfigurations-identifiers (typically  used by userTS with options.clearCache.identifier)
	 * @access public
	 * @return void
	 */
	public function manipulateCacheActions(&$cacheActions, &$optionValues){
		$languageService = $GLOBALS['LANG'] ?? GeneralUtility::makeInstance(\TYPO3\CMS\Core\Localization\LanguageService::class);
		
		$title = $languageService->sL('LLL:EXT:e_import_export/locallang_db.xlf:ecachestream.title');
		$desc = $languageService->sL('LLL:EXT:e_import_export/locallang_db.xlf:ecachestream.desc');
		
		if (empty($title)) {
			$title = 'Clear Import/Export Cache';
		}
		if (empty($desc)) {
			$desc = 'Clear the import/export cache';
		}
		
		$img = PathUtility::getPublicResourceWebPath('EXT:e_import_export/Resources/Public/Icons/cache.png');
		
		$cacheActions[] = [
			'id' => 'ECacheStream',
			'title' => $title,
			'description' => $desc,
			'href'  => 'ajax.php?ajaxID=ECacheStream&ajaxCall=1',
			'icon'  => '<img src="'.$img.'" width="16" height="16" title="'.$title.'" alt="'.$title.'" />'
		];
		$optionValues[] = 'ECacheStream';
	}
	
	/**
	 * Empty cache stream
	 *
	 * @access public
	 * @return void
	 */
	public function emptyStream(){
		$formprotection = FormProtectionFactory::get();
		$request = $GLOBALS['TYPO3_REQUEST'] ?? null;
		$formToken = $request ? ($request->getQueryParams()['formToken'] ?? $request->getParsedBody()['formToken'] ?? '') : '';
		if ($formprotection->validateToken($formToken, 'tceAction')) {
			#Caches divers:
			$cacheSystem = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('eImportExport');
			$cacheSystem->flush();
		}
	}
}