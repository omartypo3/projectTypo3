<?php
namespace DslFactory\DslProdukte\Domain\Repository;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
/**
 * The repository for Produktes
 */
class ProdukteRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findAllWithoutPidRestriction() {
//echo "findAllWithoutPidRestriction";				
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->getQuerySettings()->setRespectSysLanguage(TRUE);
		//$query->getQuerySettings()->setSysLanguageUid($GLOBALS['TSFE']->sys_language_uid);
//		$query->getQuerySettings()->setSysLanguageUid($GLOBALS['TSFE']->sys_language_uid);
//		$query->getQuerySettings()->setIgnoreEnableFields(TRUE);
/*$query->matching(
	$query->logicalNot(
			$query->equals('uid',6)
	)
);
*/
/*$parentQuery->matching(
					$parentQuery->equals('uid',$item->getL10nParent())
				);
				*/

        $items = $query->execute();

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
		
		if($sys_language_uid > 0){
			$inactiveItemsInParentLanguageConstraints=array();			
			foreach($items as $item){

				if($item->getL10nParent()) {

                    $parentQuery = $this->createQuery();
                    $parentQuery->getQuerySettings()->setRespectStoragePage(FALSE);
                    $parentQuery->getQuerySettings()->setLanguageUid(0);//setSysLanguageUid(0);
                    $parentQuery->matching( $parentQuery->equals('uid',$item->getL10nParent())	);
                    $itemsParent = $parentQuery->execute();
                    if (!count($itemsParent)) $inactiveItemsInParentLanguageConstraints[] = $query->equals('uid', $item->getLocalizedUid());
                }
			}
			//wenn elemente gefiltert werden müssen abfrage mit filter erneut ausführen
			if(count($inactiveItemsInParentLanguageConstraints)){ 
				$query->matching( $query->logicalNot(	$query->logicalOr($inactiveItemsInParentLanguageConstraints) ) );
				$items = $query->execute();
			}
		
		}
		
		return $items;
	}
	/**
	 * Finds rechtsanwaelte by given filter parameter
	 * 
	 * @param array $filter
	 * @param $kategorien
	 * @param $anwendungsbereiche
	 * @param $eigenschaften
	 * @return array
	 */
	public function findByFilter($filter, $kategorien, $anwendungsbereiche, $eigenschaften) {
		
		//macht eigentlich keinen sinn mehr ...???
		echo "resp:findByFilter deaktiverit";
		exit;
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		//$query->getQuerySettings()->setRespectSysLanguage(TRUE);
/*		if($pidArr) {
			$querySettings->setStoragePageIds(array($pidArr));
		} else {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
		}*/
		
		$constraintsAnds = array();
		//Filter Anwendungsbereiche
		$constraints = array();
		if (count($filter['anwendungsbereiche'])) {
			foreach ($anwendungsbereiche as $anwendungsbereich) {
				if (in_array($anwendungsbereich->getUid(), $filter['anwendungsbereiche']) || !count($filter['anwendungsbereiche'])) {
					$constraints[] = $query->contains('anwendungsbereiche', $anwendungsbereich);
				}
			}
		}
		if (count($constraints)) {
			$constraintsAnds[] = $query->logicalOr($constraints);
		}
		
		
		//Filter Eigenschaften
		$constraints = array();
		if (count($filter['eigenschaften'])) {
			foreach ($eigenschaften as $eigenschaft) {
//				echo "\neigenschaft Uid:".$eigenschaft->getUid();
				if (in_array($eigenschaft->getUid(), $filter['eigenschaften']) || !count($filter['eigenschaften'])) {
//					echo "\n--: in Array JA";
					$constraints[] = $query->contains('eigenschaften', $eigenschaft);
				}
			}
		}
		if (count($constraints)) {
//			echo "\nconstraints: ";
//			print_r($constraints);
			$constraintsAnds[] = $query->logicalOr($constraints);
		}
		
		
		//filter Kategorien
		$constraints = array();
		if (count($filter['kategorien'])) {
			foreach ($kategorien as $kategorie) {
				if (in_array($kategorie->getUid(), $filter['kategorien']) || !count($filter['kategorien'])) {
					$constraints[] = $query->contains('kategorien', $kategorie);
				}
			}
		}
		if (count($constraints)) {
			$constraintsAnds[] = $query->logicalOr($constraints);
		}
		//alle ands verknüppeln
		if (count($constraintsAnds)) {
			//$query->matching($query->logicalAnd($constraintsAnds));
			$query->matching($query->logicalOr($constraintsAnds));
		}
//	\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
		return $query->execute();
	}
	
	 /**
  * Finds a default language product for the given product
  *
  * @param \DslFactory\DslProdukte\Domain\Model\Produkt $produkt
  */
  public function findDefaultLanguageProdukt(\DslFactory\DslProdukte\Domain\Model\Produkte $produkt) {
	  $query = $this->createQuery();
	
	
//	$query->getQuerySettings()->setRespectSysLanguage(false);
	$query->getQuerySettings()->setRespectStoragePage(false);
	$query->getQuerySettings()->setLanguageUid(0);
	//$query->getQuerySettings()->setSysLanguageUid(0);
	// NULL, "content_fallback", "strict" or "ignore"
	//$query->getQuerySettings()->setLanguageMode(NULL);
	//$query->getQuerySettings()->setLanguageOverlayMode(0);
	
	//$query->getQuerySettings()->setReturnRawQueryResult(TRUE); 
	$result = $query->matching(
		$query->logicalAnd(
			$query->equals('uid', $produkt->getUid()),
			$query->equals('sys_language_uid', 0),
			$query->equals('l10n_parent', 0)
		)
	)->execute(TRUE);	
	if($result[0]) return $result[0]; else return false;
	
	?><hr><pre><?php print_r($result);	?></pre><?php 	
	exit;
	return $result->getFirst();
	echo time().":";
	\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
/*	?><pre><?php print_r($result->getFirst());	?></pre><?php */
	
	foreach($result as $r) {
		?><hr><pre><?php print_r($r);	?></pre><?php 	
	}
	exit;
	return $result->getFirst(); 
	 /* //Disable Language restriction
	  $query->getQuerySettings()->setRespectSysLanguage(FALSE);
	  $query->getQuerySettings()->setRespectStoragePage(FALSE);
	  $query->getQuerySettings()->setSysLanguageUid(0);
	//  $query->setQuerySettings($querySettings);
	  
	echo "<br>".$produkt->getUid().":";
	   $constraints = $query->logicalAnd(
		   $query->equals('uid', $produkt->getUid()),//$produkt->_getProperty('t3_origuid')
		   $query->equals('sys_language_uid', 0)
	   );
	
	   $result = $query->matching($constraints)->execute();
	   */
	   foreach ($result as $r) {
			return $r;
		}
		return false;
	}

}