<?php

namespace TYPO3\J77Kesearch\KeSearchIndexer;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

require_once ( ExtensionManagementUtility::extPath( 'ke_search' ).'Classes/indexer/types/class.tx_kesearch_indexer_types_tt_content.php');

class TypesFluidcontent extends \tx_kesearch_indexer_types_tt_content{
	var $indexCTypes = array(
	    'fluidcontent_content'
	);

    public function __construct($pObj)
    {
        parent::__construct($pObj);

        $newWhere = [];
        $whereClause = $this->whereClauseForCType;
        if(!empty($whereClause))
        	$newWhere[] = $whereClause;

        foreach($this->indexCTypes as $cType){
        	$newWhere[] = 'CType="' . $cType . '"';
        }
        $this->whereClauseForCType = implode(' OR ', $newWhere);
    }

	public function getContentFromContentElement($ttContentRow) {
		
		$flexform = $ttContentRow['pi_flexform'];
		$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$flexArray = $objectManager->get('TYPO3\\CMS\\Extbase\\Service\\FlexFormService')->convertFlexFormContentToArray($flexform);
		$iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($flexArray));
		
		$forbiddenKeys = array('id','tag','image','target','display','layout','class','youtubeUrl','color','googleMapsStyle', 'toptitle', 'subtitle', 'unit');
		
		$title = array();
		$content = array();
		
		foreach($iterator as $key=>$value){			
		   if($value!=='' && !$this->in_arrayi($key, $forbiddenKeys) && !is_numeric($value) && (strpos( $value, 'fileadmin') === false) && (strpos( $value, 't3://') === false) && strlen($value) > 13)
		   {
				if(strpos( $key, 'title') !== false || strpos( $key, 'titel') !== false) {
					$title[] = $value;
				} else {
					$content[] = str_replace('&shy', '', $value);
				}
		   }
		}	
		
		//DebuggerUtility::var_dump($result);
		//DebuggerUtility::var_dump($title);
		//die();
		$result = '';
		
		$title = strip_tags(str_replace('<br />',' ', implode(' ', $title)));
		if(!empty($title)) {
			$result .= $title; // . "|||";
		}		
		$result .= strip_tags(str_replace('<br />',' ', implode(' ', $content)));

		return $result;
	}
	
	function in_arrayi($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
