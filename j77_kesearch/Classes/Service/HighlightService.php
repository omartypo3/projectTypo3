<?php

namespace TYPO3\J77Kesearch\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class HighlightService implements \TYPO3\CMS\Core\SingletonInterface {
	
	
	protected $highlighted_results = array();
	protected $libObj = null;
	protected $searchObj = null;
	protected $sword = null;
	
	
	public function modifySearchWords($searchWordInformation, $libObj) {
		$this->libObj = $libObj;		
		
		//DebuggerUtility::var_dump($libObj);
	}
	
	public function getQueryParts($queryParts, $searchObj) {
	
		$this->sword = $searchObj->pObj->sword;	
		
		$queryParts['LIMIT'] = '0,500';
	//	DebuggerUtility::var_dump($queryParts);
		
		
		
		
		return $queryParts;
	}
	
	public function modifyResultList($fluidTemplateVariables, $pi2object) {
		
		/*if(!empty($this->sword)) {
			$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
			$repository = $objectManager->get(\J77\XXX\Domain\Repository\JobRepository::class);
			$querySettings = $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
			$querySettings->setRespectStoragePage(FALSE);		
			$repository->setDefaultQuerySettings ($querySettings);

			$pi2object->fluidTemplateVariables['jobs'] = $repository->search($this->sword);
		}*/
	}
}