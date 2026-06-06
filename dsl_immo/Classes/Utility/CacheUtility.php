<?php
namespace  DslFactory\DslImmo\Utility;

use \TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use DslFactory\DslImmo\Domain\Repository\ImmobilieRepository;


/**
 * Utility class for Realurl
 *
 * @package TYPO3
 * @subpackage tx_dslimmo
 */
class CacheUtility 
{

	
	protected $cacheManager;
	
	
	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }

	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    
	public function resetImmobilie($uid)
	{
		
		
		/** @var $cacheManager \TYPO3\CMS\Core\Cache\CacheManager */
		if(!$this->cacheManager) $this->cacheManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager');
		$this->cacheManager->getCache('cache_pages')->flushByTag('tx_dslimmo_domain_model_immobilie_'.$uid);
		$this->cacheManager->getCache('cache_pagesection')->flushByTag('tx_dslimmo_domain_model_immobilie_'.$uid);
		
		/*

		if(!$this->objectManager) $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		if(!$this->persistenceManager) $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		if(!$this->immobilieRepository) $this->immobilieRepository= $this->objectManager->get(ImmobilieRepository::class);
		if(!$this->flashMessageService) $this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		if(!$this->messageQueue) $this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
			
		
		//wenn realurl aktiv ist die daten von gelöschten immobilien verwerfen
		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
			
			$sqlNot="";
			$immobilies = $this->immobilieRepository->findAll();
			$aktivArr = array();
			foreach($immobilies as $immobilie){
				$aktivArr[] = $immobilie->getUid();
			}
		
			if($aktivArr) {
				$sqlNotArr = array();
				foreach($aktivArr as $immobilieUid){
					$sqlNotArr[]="original_url LIKE '%immobilie%5D=".$immobilieUid."'";
					$sqlNotArr[]="original_url LIKE '%immobilie%5D=".$immobilieUid."&%'";
				}
				if(count($sqlNotArr)) $sqlNot = " AND NOT (".implode(" OR ",$sqlNotArr).")";
			}

			$sqlCleanRealUrl = "SELECT * FROM tx_realurl_urldata WHERE original_url LIKE '%immobilie%5D=%' ".$sqlNot;
			$oldRealUrlEntries = $this->immobilieRepository->getOldRealUrl();
			if($oldRealUrlEntries) if(is_array($oldRealUrlEntries)){
				$removedRealUrlCounter = 0;
				$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
				$urlCacheEntryRepository = $objectManager->get('DmitryDulepov\\Realurl\\Domain\\Repository\\UrlCacheEntryRepository');
				foreach($oldRealUrlEntries as $entry){
					if($cacheEntry = $urlCacheEntryRepository->findByUid($entry["uid"])){
						$urlCacheEntryRepository->remove($cacheEntry);
						$removedRealUrlCounter++;
					}
				}
				
				$messageRealUrlClean = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
				   'ImportCommandControllerImportCommand',
				   'Realurl '.$removedRealUrlCounter.' Einträge gelöscht ', // [optional] the header
				   \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
				   true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)
				);
				$this->messageQueue->addMessage($messageRealUrlClean);
				
			}
		}
		
		*/
	}

	/** @var $logger \TYPO3\CMS\Core\Log\Logger */
/*        $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        $logger->info('Everything went fine.');
        $logger->warning('Something went awry, check your configuration!');
        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'This is an utter failure!');*/

//$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Templates/');
//$templateLayoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Layouts/');
//$templatePartialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Partials/');
//$templatePathAndFilenameKunde = $templateRootPath . 'Protokolle/' . $mailTemplate . '.html';
//$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
//$viewAnKunde = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
//settings
//$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
//$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
//$settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
//['plugin.']['tx_dslintranet.']['settings'];
//$viewAnKunde->setLayoutRootPath($templateLayoutRootPath);
//$viewAnKunde->setPartialRootPath($templatePartialRootPath);
//$viewAnKunde->setTemplatePathAndFilename($templatePathAndFilenameKunde);

}