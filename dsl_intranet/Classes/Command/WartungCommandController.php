<?php
namespace DslFactory\DslIntranet\Command;

use \TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
#use DslFactory\DslIntranet\Domain\Repository\FahrzeugeRepository;
#use DslFactory\DslMobile\Domain\Repository\ImportRepository;	   

class WartungCommandController extends CommandController
{
	
    /**
     * The settings.
     * @var array
     */
    protected $settings = array();
	
	protected $objectManager;
	protected $persistenceManager;
	protected $flashMessageService;
	protected $messageQueue;
	
	
 	private function initializeCommand() {
		
		
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
		$this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		  
		//$this->fahrzeugeRepository= $this->objectManager->get(FahrzeugeRepository::class);
		//$this->importRepository= $this->objectManager->get(ImportRepository::class);
		
		$this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		$this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
			
    }	
	
	/**
     * wartung
     * 
     * @param int $command
     * @return void
     */
    public function wartungCommand($command = 0)
    {
		
		$this->initializeCommand();
		
		$uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');
    
		
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);
        $folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
		$files = $storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', false);
		$deleteFile=0;
		$sqlGesamt="";
        foreach ($files as $file) {
//			echo "<br>prüfung datei (".(int) $file->getUid()."): ";
//echo $file->getIdentifier();

			//if($file->getOriginalResource()) {
				
				/*$storageCfg = $file->getOriginalResource()->getOriginalFile()->getStorage()->getConfiguration();
				if ($storageCfg['basePath'] && $file->getOriginalResource()->getOriginalFile()->getIdentifier()) {
					echo "(".$file->getOriginalResource()->getOriginalFile()->getIdentifier().") ";
					//unlink(rtrim($storageCfg['basePath'], '/') . $file->getOriginalResource()->getOriginalFile()->getIdentifier());
				}*/
			//}
                            

			$this->getDatabaseConnection()->store_lastBuiltQuery = 1;
			
            $fileObjects = $this->getDatabaseConnection()->exec_SELECTgetRows('uid', 'sys_file_reference', 'tablenames=' . $this->getDatabaseConnection()->fullQuoteStr('tx_dslintranet_domain_model_dateien', 'sys_file_reference') . ' AND uid_local=' . (int) $file->getUid() . ' AND fieldname=' . $this->getDatabaseConnection()->fullQuoteStr('datei', 'sys_file_reference'), '', 'sorting_foreign', '', 'uid');
			
			$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'WartungCommandControllerWartungCommand', "SQL Query für (".$file->getIdentifier()."): ".$this->getDatabaseConnection()->debug_lastBuiltQuery." // ".print_r(array_keys($fileObjects),1), \TYPO3\CMS\Core\Messaging\FlashMessage::OK, true	);
			$this->messageQueue->addMessage($message);
			
			
			if(is_array($fileObjects)) if(count($fileObjects)>1){
				$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'WartungCommandControllerWartungCommand', $file->getIdentifier()." // ".print_r(array_keys($fileObjects),1)." //  Achtung es existieren mehrere ergebnisse:".count($fileObjects), \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR, true	);
				$this->messageQueue->addMessage($message);
			}
			
            if (!count($fileObjects)) {
				//SELECT uid FROM sys_file WHERE identifier LIKE '%/angebote_rechnungen/_m9a4332.jpg%'
				$findNewNow = $this->getDatabaseConnection()->exec_SELECTgetRows('uid', 'sys_file', 'identifier LIKE "%'.$file->getIdentifier().'%"', '', '', '', 'uid');
				$sql='';
				if($findNewNow) if(count($findNewNow)==2){
					$findNewNow=array_keys($findNewNow);
					$sql='UPDATE sys_file_reference SET uid_local='.$findNewNow[1].' WHERE  uid_local='.$findNewNow[0].';';
					$sqlGesamt.=$sql;
					
					$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'WartungCommandControllerWartungCommand', "SQL Ergebniss: ".print_r($findNewNow,1)."sql: ".$sql.' lastQuery:'.$this->getDatabaseConnection()->debug_lastBuiltQuery, \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR, true	);
					$this->messageQueue->addMessage($message);

				}
				
				
				
				
				$deleteFile++;
				if($command==1) {
					$file->delete();
					$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class, 'WartungCommandControllerWartungCommand', 'Datei '.$file->getIdentifier()." (".(int) $file->getUid().") ist verwaist und wurde gelöscht.", \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, true 
	);
				} else {
					$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class, 'WartungCommandControllerWartungCommand','Datei '.$file->getIdentifier()." (".(int) $file->getUid().") ist verwaist und würde gelöscht werden.",  \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, true );
				}
				
				$this->messageQueue->addMessage($message);
               // echo " false => DELETE !!!!";
				//$file->delete();
				//die;
              //  $file->delete();
            }// else echo " true ";
        }/*wartung end*/
		//die;
		//echo $sqlGesamt;

			if($command==1) {
				$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'WartungCommandControllerWartungCommand', count($files)." geprüft. Davon wurden ".$deleteFile." Dateien gelöscht.", \TYPO3\CMS\Core\Messaging\FlashMessage::OK, true	);
			} else {
				$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'WartungCommandControllerWartungCommand', count($files)." geprüft. Davon würden ".$deleteFile." Dateien gelöscht werden.", \TYPO3\CMS\Core\Messaging\FlashMessage::OK, true	);
			}
	//die;
			
			//$flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
			//$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
			$this->messageQueue->addMessage($message);
			
		
		
		
	
		
		
		
		
		
    }
	
	
	
	
    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
	
}