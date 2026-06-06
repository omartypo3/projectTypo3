<?php
namespace Emagineurs\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class CmsLayoutDrawitem implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface {
	public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {
		if ($row['CType'] === 'menu') {
			$drawItem = FALSE;
			
			$itemContent .= '<strong>' . $GLOBALS['LANG']->sL('LLL:EXT:cms/locallang_ttc.xlf:CType.I.12', TRUE) . '</strong>';
			
			if ($row['pages']) {
				$itemContent .= '<br />Pages: ' . self::getPagesNames($row['pages']) . '<br />';
			}
			
			$itemContent = $parentObject->linkEditContent($itemContent, $row);
		}
	}
	
	public static function getPagesNames($uidList){
		$namesList = array();
		$uidList = explode(',', $uidList);
		foreach($uidList as $uid){
			$namesList[] = '['.$uid.'] '.self::getPageName($uid);
		}
		return implode(', ', $namesList);	
	}
	
	public static  function getPageName($uid){
		$page = self::getRecord('pages', $uid);
		if($page!==false){
			return $page['title'];
		}
		return '';
	}
	
	public static  function getRecord($table, $uid, $where = '', $order = ''){
		if($uid > 0 && empty($where)){
			$where = 'uid='.intval($uid);
		}
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*',$table,$where, '', $order, 1);
		
		if(is_array($res) && count($res) > 0){
			$res = reset($res);
			return $res;
		}
		return false;
	}

}