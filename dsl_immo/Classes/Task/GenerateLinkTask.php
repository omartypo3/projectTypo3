<?php
namespace DslFactory\DslImmo\Task;


use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use DslFactory\DslImmo\Domain\Repository\ImmobilieRepository;
use TYPO3\CMS\Frontend\Page\CacheHashCalculator;

class GenerateLinksTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	
	
	
	  /**
     * immobilieRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\ImmobilieRepository
     * @inject
     */
    protected $immobilieRepository;

	protected $objectManager;
	protected $persistenceManager;
	protected $flashMessageService;
	protected $messageQueue;	  
	
	
	private function initializeCommand() {
		
		
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
		$this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		  
		$this->immobilieRepository= $this->objectManager->get(ImmobilieRepository::class);
		//$this->importRepository= $this->objectManager->get(ImportRepository::class);
		
		$this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		$this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
			
		
      
    }	
	
	public function execute() {
		
		
		$this->initializeCommand();
		
		//[...]

		
		
		
		$this->initFrontend();

		$linkZaehlerGeneriert = 0;
		
		$importSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('import');
		$canonicalPid = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('canonicalPid');
		
		$canonicalPlugin = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('canonicalPlugin'); // default tx_dslimmo_immodetail
		$canonicalPluginAction = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('canonicalPluginAction');
		
		
		if($canonicalPid){

			if($importSettings['immobilien.']['storagePid']){
				$immobilien = $this->immobilieRepository->findAllRespectFrontend($importSettings['immobilien.']['storagePid']);
			} else {
				$immobilien = $this->immobilieRepository->findAll();
			}
			if($immobilien) foreach($immobilien as $immobilie){


				$params = "id=".$canonicalPid."&".$canonicalPlugin."%5Bimmobilie%5D=".$immobilie->getUid();
				if($canonicalPluginAction) $params.="&".$canonicalPlugin."%5Baction%5D=".$canonicalPluginAction;
				//cHash Manuell berechnen da  da typolink_URL diesen nicht berechnet
				$cacheHash = GeneralUtility::makeInstance(CacheHashCalculator::class);
				$cHash = $cacheHash->generateForParameters($params);

				$cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
				
				$paramsArr = array(
							'immobilie' => $immobilie->getUid()
						);
				if($canonicalPluginAction) $paramsArr["action"] = $canonicalPluginAction;
				
				$linkConf = array(
					'parameter' => $canonicalPid,//$this->extConf['targetPageUid'],
					'forceAbsoluteUrl' => 1,
					'additionalParams' => \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl(NULL, array(
						$canonicalPlugin => $paramsArr,
						'cHash'=>$cHash
					)),
				);
				
				
				$link = $cObj->typolink_URL($linkConf);
				$linkZaehlerGeneriert++;

				//}
			}
		}
		// 	bei hermes: cHash=9c242767a35e7df924c78f24fe400311&id=85&tx_dslimmo_immoout%5Baction%5D=show&tx_dslimmo_immoout%5Bimmobilie%5D=31
		
		// bei wewobau: cHash=7138c4c8a2bd8886a9cfbaf6a299f395&id=14&tx_dslimmo_immodetail%5Bimmobilie%5D=74
		
		
		$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
		'Links generiert: '.$linkZaehlerGeneriert,
		'Link Generierung', // [optional] the header
		\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
		true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)
		);
		
		//.print_r($importSettings,1)."canopid:".$canonicalPid
		  
			
			//$flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
			//$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
			$this->messageQueue->addMessage($message);
		  
		
		//foreach($documents as $document) {
	

		return TRUE;
	}

	/*
	 * init frontnend to render frontend links in task
	 */
	protected function initFrontend() {
		$id = 1;
		$type = 0;
		if (!is_object($GLOBALS['TT'])) {
			$GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\TimeTracker;
			$GLOBALS['TT']->start();
		}
		$GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController',  $GLOBALS['TYPO3_CONF_VARS'], $id, $typeNum);
		$GLOBALS['TSFE']->connectToDB();
		$GLOBALS['TSFE']->initFEuser();
		$GLOBALS['TSFE']->determineId();
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->getConfigArray();

		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
			$rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($id);
			$host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
			$_SERVER['HTTP_HOST'] = $host;
		}
	}
}

?>