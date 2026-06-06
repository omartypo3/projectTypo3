<?php

namespace DslFactory\DslImmo\Task;

use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use DslFactory\DslImmo\Domain\Repository\ImmobilieRepository;
use DslFactory\DslImmo\Domain\Repository\ImportRepository;	  

   class WartungTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	   /**
     * importRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\ImportRepository
     * @inject
     */
    protected $importRepository;
	protected $objectManager;
	protected $persistenceManager;
	protected $flashMessageService;
	protected $messageQueue;	   

	private function initializeCommand() {

		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
		$this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		$this->immobilieRepository= $this->objectManager->get(ImmobilieRepository::class);
		$this->importRepository= $this->objectManager->get(ImportRepository::class);
		$this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		$this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
    }	

	public function execute() {
		//löschen alter importe 
		$this->initializeCommand();
		
		$uploadSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
		$backupAnzahl = (int)$uploadSettings['backupAnzahl'];
		
		$importe = $this->importRepository->findAll();
		$importArr = array();

		$zaehler = 0;

		$importZaehlerRemoved = 0;

		foreach($importe as $import){
			$zaehler++;
			$importArr[]=$import->getUid();
			//echo $import->getDatei()->getUid().":";
			if($zaehler>$backupAnzahl){ //import dateien größer 8 löschen
				  if($import->getDatei()){
					  $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
					  //checkActionPermission() // https://stackoverflow.com/questions/44783507/typo3-you-are-not-allowed-to-delete-the-file
					  if($fileReferenceObject = $resourceFactory->getFileReferenceObject($import->getDatei()->getUid())){
						  $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
					  }
				  }
			  }
			  if($zaehler>$backupAnzahl){ //ältere importe komplett löschen
				  $this->importRepository->remove($import);
				  $importZaehlerRemoved++;
			  }
		  }
		  $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

		//$uploadSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');

        //$this->addFlashMessage(print_r($uploadSettings, 1), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

		$importType = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('importType');		
		
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);

		
        if ($importType == 'openImmo') {
			$folderInbox = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
			$folderBackup = $storage->getFolder(trim($uploadSettings['falStorageBackupDir'], '/') . '/');
		}
		
		
        
        $folderAnhaenge = $storage->getFolder(trim($uploadSettings['falStorageAnhaengeDir'], '/') . '/');
        $folderTemp = $storage->getFolder(trim($uploadSettings['falStorageTempDir'], '/') . '/');

		$filesToDeleteInAnhaenge=0;
		$files = $storage->getFilesInFolder($folderAnhaenge, 0, 0, true, false, 'modification_date', false);

		foreach ($files as $file) {
			$fileObjects = $this->getDatabaseConnection()->exec_SELECTgetRows('uid', 'sys_file_reference', 'tablenames=' . $this->getDatabaseConnection()->fullQuoteStr('tx_dslimmo_domain_model_anhang', 'sys_file_reference') . ' AND uid_local=' . (int) $file->getUid() . ' AND fieldname=' . $this->getDatabaseConnection()->fullQuoteStr('datei', 'sys_file_reference'), '', 'sorting_foreign', '', 'uid');
			if (!count($fileObjects)) {
				/*$this->addFlashMessage((string) $file->getUid() . ' // ' . $file->getIdentifier() . ' wird gelöscht (' . count($fileObjects) . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);*/
				$filesToDeleteInAnhaenge++;
				$file->delete();
			}
		}
		
		
		//dateien aus dem backup ordner löschen die da nicht hingehören
		$filesToDeleteInBackup=0;
		if ($importType == 'openImmo') {
			$files = $storage->getFilesInFolder($folderBackup, 0, 0, true, false, 'modification_date', false);
			foreach ($files as $file) {
				$fileObjects = $this->getDatabaseConnection()->exec_SELECTgetRows('uid', 'sys_file_reference', 'tablenames=' . $this->getDatabaseConnection()->fullQuoteStr('tx_dslimmo_domain_model_import', 'sys_file_reference') . ' AND uid_local=' . (int) $file->getUid() . ' AND fieldname=' . $this->getDatabaseConnection()->fullQuoteStr('datei', 'sys_file_reference'), '', 'sorting_foreign', '', 'uid');
				if (!count($fileObjects)) {
					/*$this->addFlashMessage((string) $file->getUid() . ' // ' . $file->getIdentifier() . ' wird gelöscht (' . count($fileObjects) . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);*/
					$filesToDeleteInBackup++;
					$file->delete();
				}
			}
		}

		$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,

		'WartungTaskExecute: '.$importZaehlerRemoved.' von '.count($importe).' Importen gelöscht // Dateien aus BackupOrdner gelöscht: '.$filesToDeleteInBackup.' // Dateien aus AnhangOrdner gelöscht: '.$filesToDeleteInAnhaenge,

		'Aufräumen alter Importe ', // [optional] the header

		\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK

		true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)

		);

		
			$this->messageQueue->addMessage($message);
		  

         return TRUE; //ende gut, alles gut?

      }

	   

	   

	   

	/**
     * @return DatabaseConnection
     */

    protected function getDatabaseConnection(){
        return $GLOBALS['TYPO3_DB'];
    }

 }

?>