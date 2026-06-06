<?php
namespace Emagineurs\EComment\Utility;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FileUtility {
    /**
     * @param array $fileInfo
     * @return \TYPO3\CMS\Core\Resource\FileInterface
     */
    public static function generateFile($fileInfo){
		$fileMedia = $fileInfo['name'];
		$fileTmpMedia = $fileInfo['tmp_name'];

		/** @var StorageRepository $storageRepository */
		$storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
		$storage = $storageRepository->findByUid(1);

		$identifier = 'tx_ecomment';
		$absoluteIdentiferPath = $storage->getConfiguration()['basePath'].$identifier;
		
		if(file_exists($absoluteIdentiferPath)) {
			$folder = $storage->getFolder($identifier);
		} else {
			$folder = $storage->createFolder($identifier);
		}
		
		$file = $storage->addFile($fileTmpMedia, $folder, $fileMedia);
		
		return $file;
	}

    /**
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @return \TYPO3\CMS\Core\Resource\FileReference
     */
    public static function createFileReference($file){
        /** @var ResourceFactory $resourceFactory */
		$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
		$data = array(
			'uid_local' => $file->getUid()
		);
		$fileRef = $resourceFactory->createFileReferenceObject($data);
		return $fileRef;
	}

}