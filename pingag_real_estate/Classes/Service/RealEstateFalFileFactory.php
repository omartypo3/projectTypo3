<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 09.08.2018
 * Time: 16:45
 */

namespace Pingag\PingagRealEstate\Service;

use Pingag\PingagRealEstate\Domain\Model\RealEstate;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\Exception\FileNotFoundException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RealEstateFalFileFactory
{

    protected $filename;
    protected $title;
    protected $fieldName;
    protected $sourceFolder;
    protected $targetFolder;
    public $missingFiles = [];

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository;

    /**
     * @var ResourceFactory
     */
    protected $resourceFactory;

    /**
     * RealEstatePictureFactory constructor.
     * @param ResourceFactory $resourceFactory
     */
    public function __construct()
    {
        $this->resourceFactory = ResourceFactory::getInstance();
    }

    const FAL_TARGET_FOLDER = 'real-estate/';

    public function addRealEstateFalFile(RealEstate $realEstate, $filename, $sourceFolder, $title = null, $fieldName)
    {
        $this->filename = $filename;
        $this->title = $title;
        $this->sourceFolder = $sourceFolder;
        $this->fieldName = $fieldName;
        $this->targetFolder = self::FAL_TARGET_FOLDER . $realEstate->getUid() . '/' . $this->fieldName;

        //$this->deleteTargetFolder();
        //return true;

        try {
            $file = $this->createFile();
            $this->createFileReference($realEstate, $file);
        } catch (FileNotFoundException $e) {
            $this->missingFiles[] = $this->getSourceImagePath();
        }
    }

    /**
     * @param RealEstate $realEstate
     * @param File $file
     */
    protected function createFileReference(RealEstate $realEstate, File $file)
    {
        // Assemble DataHandler data
		// $resourceFactory = ResourceFactory::getInstance();
		// following line gives error - UID given: ""
		// $fileObject = $resourceFactory->getFileObject((int)$file);
		// following line gives error - No file reference was found for given UID: "1"
		//$fileObject = $resourceFactory->getFileReferenceObject((int)$file);
        $newId = uniqid('NEW');
        $data['sys_file_reference'][$newId] = array(
			'uid' => $newId,
            'table_local' => 'sys_file',
            'uid_local' => $file->getUid(),
			//'uid_local' => $fileObject->getUid(),
            'tablenames' => 'tx_pingag_real_estate',
            'uid_foreign' => $realEstate->getUid(),
            'fieldname' => $this->fieldName,
            'pid' => $realEstate->getPid(),
            'title' => $this->title
        );
        $data['tx_pingag_real_estate'][$realEstate->getUid()] = array(
            $this->fieldName => $newId
        );

        // Get an instance of the DataHandler and process the data
        /** @var DataHandler $dataHandler */
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($data, array());
        $dataHandler->process_datamap();
        // Error or success reporting
        if ($dataHandler->errorLog) {
            // Error - Reference not created
            DebuggerUtility::var_dump($dataHandler->errorLog);
        }
    }

    /**
     * @return File
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    protected function createFile()
    {
        $rootStorage = $this->resourceFactory->getStorageObject(0);

        // get import image file
        $originalFilePath = $this->getSourceImagePath();
        if (!$rootStorage->hasFile($originalFilePath)) {
            throw new FileNotFoundException("File {$originalFilePath} does not exsists.");
        }

        // copy image to fileadmin
        /** @var File $originalFile */
        $originalFile = $rootStorage->getFile($originalFilePath);
        $folder = $this->getTargetFolder();
        $file = $originalFile->copyTo($folder);

        return $file;
    }

    protected function getSourceImagePath()
    {
        return $this->sourceFolder . $this->filename;
    }

    /**
     * @return \TYPO3\CMS\Core\Resource\Folder|\TYPO3\CMS\Core\Resource\InaccessibleFolder
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    protected function getTargetFolder()
    {
        $fileadminStorage = $this->resourceFactory->getDefaultStorage();
        $fileadmin = $fileadminStorage->getRootLevelFolder();
        if (!$fileadmin->hasFolder($this->targetFolder)) {
            $fileadmin->createFolder($this->targetFolder);
        }
        return $fileadminStorage->getFolder($this->targetFolder);
    }


    public function cleanUpTargetFolder()
    {
        $storage = $this->resourceFactory->getDefaultStorage();
        $storage->getFolder(self::FAL_TARGET_FOLDER)->delete();
        $storage->createFolder(self::FAL_TARGET_FOLDER);
    }
}