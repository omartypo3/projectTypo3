<?php
namespace BravoBuero\BbDownloadlog\Slot;

/**
 * Class LogFileDump
 * @package BravoBuero\BbDownloadlog\Slot
 */

class LogFileDump {
    public function logFileDump($file,$thisvar) {
		

		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$entryRepository = $objectManager->get('BravoBuero\\BbDownloadlog\\Domain\\Repository\\EntryRepository');
		
		
		if($file instanceof \TYPO3\CMS\Core\Resource\ProcessedFile) return;
		//var_dump($file);
		if($file instanceof \TYPO3\CMS\Core\Resource\File){
			
			$entry = new \BravoBuero\BbDownloadlog\Domain\Model\Entry();
			$entry->setZeitpunkt(new \DateTime());

			$entry->setFile($file);

			if($thisvar->getFeUser()){
				if(is_array($thisvar->getFeUser()->user)) $entry->setFeuser($thisvar->getFeUser()->user['uid']);
				if(is_array($thisvar->getFeUser()->groupData)) $entry->setFeusergroups(implode(',',$thisvar->getFeUser()->groupData['uid']));
			}



			$entryRepository->add($entry);
			$objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		
		}
		
    }
}
?>