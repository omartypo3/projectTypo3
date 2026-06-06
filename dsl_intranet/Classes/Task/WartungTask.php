<?php
namespace DslFactory\DslIntranet\Task;


use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
#use DslFactory\DslIntranet\Domain\Repository\FahrzeugeRepository;
#use DslFactory\DslIntranet\Domain\Repository\ImportRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;

class WartungTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	   
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
	   
	public function execute() {
	  $this->initializeCommand();
		
		$uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');
		$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);
        $folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
		$files = $storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', false);
		$deleteFile=0;
		$sqlGesamt="";
        foreach ($files as $file) {
			
			$tableImport ="tx_dslintranet_domain_model_dateien";
            $fieldnameImport ="datei";
			$constraintsImport = $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($tableImport, \PDO::PARAM_STR)),
                $queryBuilder->expr()->eq('uid_local', $queryBuilder->createNamedParameter($file->getUid(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($fieldnameImport, \PDO::PARAM_STR))
            );

            $fileObjects = $queryBuilder
                ->select('uid')
                ->from('sys_file_reference')
                ->where($constraintsImport)
                ->orderBy('sorting_foreign')
                ->execute()
                ->fetchAll();
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
			
            }// else echo " true ";
        }/*wartung end*/
		
		return TRUE; 

    }
	   
	   
	   
	/**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
   

?>