<?php

namespace TYPO3\J77Kesearch\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 */
class RegisterIndexerFluidcontent {

	/**
	 * objectManager
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	public $objectManager;

	/**
	 * Custom indexer for ke_search
	 *
	 * @param array $params
	 * @param array $pObj
	 *
	 * @return void.
	 * @author Benjamin Beck <beck@beckdigitalemedien.de>
	 */

	public static $indexerType = 'fluidcontent';

	function registerIndexerConfiguration (&$params, $pObj) {
		// add item to "type" field
		$newArray          = array(
			'Indexer for fluidcontent elements',
			self::$indexerType,
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath( 'j77_kesearch' ) . 'customnews-indexer-icon.gif'
		);
		$params['items'][] = $newArray;
	
		
	}

	/**
	 * Custom indexer for ke_search
	 *
	 * @param array $indexerConfig Configuration from TYPO3 Backend
	 * @param array $indexerObject Reference to indexer class.
	 *
	 * @return string Output.
	 * @author Benjamin Beck <beck@beckdigitalemedien.de>
	 */
	public function customIndexer (&$indexerConfig, &$indexerObject) {

		
		$this->objectManager = GeneralUtility::makeInstance( 'TYPO3\CMS\Extbase\Object\ObjectManager' );
		
		// $custom_indexer = new \custom_indexer($indexerObject);
		//$indexer = $this->objectManager->get('TYPO3\J77Kesearch\KeSearchIndexer\FlexibleContent', $indexerObject);
		$indexer = $this->objectManager->get('TYPO3\J77Kesearch\KeSearchIndexer\ConferenceContent', $indexerObject);
	    $indexer = $this->objectManager->get('TYPO3\J77Kesearch\KeSearchIndexer\TeamContent', $indexerObject);
		//$indexer = $this->objectManager->get('TYPO3\J77Kesearch\KeSearchIndexer\TypesFluidcontent', $indexerObject);


		return $indexer->startIndexing();
	}
}




