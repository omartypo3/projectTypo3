<?php
namespace DslFactory\DslImmo\Controller;

use TYPO3\CMS\Core\Database\DatabaseConnection;
/***

 *

 * This file is part of the "immo" Extension for TYPO3 CMS.

 *

 * For the full copyright and license information, please read the

 * LICENSE.txt file that was distributed with this source code.

 *

 *  (c) 2017

 *

 ***/

/**
 * ImportController
 */
class ImportIvmController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * importRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\ImportRepository
     * @inject
     */
    protected $importRepository = null;

    /**
     * immobilieRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\ImmobilieRepository
     * @inject
     */
    protected $immobilieRepository = null;

    /**
     * kontaktpersonRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\KontaktpersonRepository
     * @inject
     */
    protected $kontaktpersonRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $imports = $this->importRepository->findAll();
        $this->view->assign('imports', $imports);
    }

    /**
     * action import
     * 
     * @param int $fileUid
     * @return void
     */
    public function importAction($fileUid = NULL)
    {
        $this->view->assign('time', new \DateTime());
        //$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
        //$importTask
        $uploadSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
        //$this->addFlashMessage(print_r($uploadSettings, 1), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);
        $folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
        $folderBackup = $storage->getFolder(trim($uploadSettings['falStorageBackupDir'], '/') . '/');
        $folderAnhaenge = $storage->getFolder(trim($uploadSettings['falStorageAnhaengeDir'], '/') . '/');
        $folderTemp = $storage->getFolder(trim($uploadSettings['falStorageTempDir'], '/') . '/');
        //$tempDir = 	$storage->getFolder(trim($uploadSettings["falStorageSubDir"],'/')."/");
        // https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/core/Classes/Resource/ResourceStorage.php
        // getFilesInFolder(Folder $folder, $start = 0, $maxNumberOfItems = 0, $useFilters = true, $recursive = false, $sort = '', $sortRev = false)
        //$filesAnhaenge = $storage->getFilesInFolder($folderAnhaenge, 0, 0, true, false, 'modification_date', false);
        //$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
        //$fileObjects = $fileRepository->findByRelation('pages', 'media', $uid);
        //foreach($filesAnhaenge as $fileToCheck){
        /*?><pre><?php var_dump($fileToCheck);?></pre><?php */
        //echo "<br>".$fileToCheck->getUid();
        //}
        //die;
        $files = $storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', true);
        //getoldest file to import
        $zipFileToImport = false;
        $sortedFiles = array(

        );
        foreach ($files as $file) {
            $fileProperties = $file->getProperties();
            $sortedFiles[(int) $fileProperties['modification_date']] = $file;
        }
        krsort($sortedFiles);
        $zipFileToImport = false;
        foreach ($sortedFiles as $file) {
            $fileProperties = $file->getProperties();
            if ($fileProperties['mime_type'] == 'application/zip') {
                $zipFileToImport = $file;
            }
        }
        if ($zipFileToImport) {
            $this->view->assign('nextImportFile', $zipFileToImport);
        }
        /*?><pre><?php print_r(array_keys($sortedFiles));?></pre><?php

                                                                                                                                                                                                                                                                                        		die;*/

        $this->view->assign('files', $sortedFiles);
        if ($fileUid) {
            $importCommandController = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\DslFactory\DslImmo\Command\ImportCommandController::class);
            $importCommandController->importCommand($fileUid);
            $this->redirect('import');
        }
    }

    /**
     * action delete
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Import $import
     * @return void
     */
    public function deleteAction(\DslFactory\DslImmo\Domain\Model\Import $import)
    {
        //$file = $import->getDatei();
        if ($import->getDatei()) {
            $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
            $fileReferenceObject = $resourceFactory->getFileReferenceObject($import->getDatei()->getUid());
            $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
        }
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->importRepository->remove($import);
        $this->redirect('list');
    }

    /**
     * delete an immobilie
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function deleteImmobilie(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        //echo $immobilieUid;
        //if($immobilie = $this->immobilieRepository->findByUidBackend($immobilieUid)){
        //echo $immobilie->getUid();
        //die;
        if ($immobilie->getAnhaenge()) {
            foreach ($immobilie->getAnhaenge() as $anhang) {
                if ($anhang->getDatei()) {
                    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
                    //echo ""
                    //	$storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', false);
                    if ($anhang->getDatei()->getUid()) {
                        //wenn die datei schon gespeichert wurde
                        $fileReferenceObject = $resourceFactory->getFileReferenceObject($anhang->getDatei()->getUid());
                        $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
                    } else {

                    }
                }
            }
        }
        $this->immobilieRepository->remove($immobilie);
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
