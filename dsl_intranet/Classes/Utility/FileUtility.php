<?php

namespace DslFactory\DslIntranet\Utility;


use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Resource\File as FalFile;
use TYPO3\CMS\Core\Resource\FileReference as FalFileReference;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Class FileUtility
 * @package DslFactory\DslIntranet\Utility
 */
class FileUtility
{
    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $resourceFactory;

    /**
     * @var \TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect
     */
    protected $fileDeletionAspect;


    public function __construct(protected ResourceFactory $_resourceFactory, protected FileDeletionAspect $_fileDeletionAspect)
    {
        $this->resourceFactory = $_resourceFactory;
        $this->fileDeletionAspect = $_fileDeletionAspect;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\File[] $files
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference[]
     */
    public function createFileReferencesFromFiles($files)
    {
        $result = [];

        foreach ($files as $file)
        {
            $result[] = $this->createFileReferenceFromFalFileObject($file);
        }

        return $result;
    }

    /**
     * @param FalFile $file
     * @param int $pid
     * @param int $foreignUid
     * @param string $tableName
     * @param string $fieldName
     * @return FileReference
     * @throws \TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException
     */
    public function createFileReferenceFromFalFileObject(
        FalFile $file,
        int $pid,
        int $foreignUid,
        string $tableName,
        string $fieldName
    ): FileReference {
        // 1. Create the reference record in sys_file_reference
        $referenceUid = $this->createFileReferenceRecord(
            $file->getUid(),
            $foreignUid,
            $tableName,
            $fieldName,
            $pid
        );

        // 2. Get the persisted reference
        $falReference = $this->resourceFactory->getFileReferenceObject($referenceUid);

        // 3. Create Extbase model
        $extbaseReference = new FileReference();
        $extbaseReference->setOriginalResource($falReference);

        return $extbaseReference;
    }

    protected function createFileReferenceRecord(
        int $fileUid,
        int $foreignUid,
        string $tableName,
        string $fieldName,
        int $pid
    ): int {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');

        $connection->insert(
            'sys_file_reference',
            [
                'uid_local' => $fileUid,
                'uid_foreign' => $foreignUid,
                'tablenames' => $tableName,
                'fieldname' => $fieldName,
                'pid' => $pid,
                'tstamp' => time(),
                'crdate' => time(),
                'table_local' => 'sys_file',
            ]
        );

        return (int)$connection->lastInsertId();
    }

    /**
     * @param FalFileReference $falFileReference
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected function createFileReferenceFromFalFileReferenceObject(FalFileReference $falFileReference)
    {
        /** @var $fileReference \TYPO3\CMS\Extbase\Domain\Model\FileReference **/
//        $fileReference = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference');
        $fileReference = new FileReference();

        $fileReference->setOriginalResource($falFileReference);

        return $fileReference;
    }

    /**
     * @param $path
     * @return bool
     */
    public function deleteFolderRecursive($path) {
        $path = rtrim($path, '/');

        // Skip systemd-protected directories
        if (strpos($path, '/tmp/systemd-private-') === 0) {
            return false;
        }

        if (!file_exists($path)) {
            return false;
        }

        try {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $path,
                    \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_PATHNAME
                ),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            $deletionErrors = false;
            foreach ($iterator as $item) {
                try {
                    if (is_dir($item)) {
                        if (!@rmdir($item)) {
                            $deletionErrors = true;
                        }
                    } else {
                        if (!@unlink($item)) {
                            $deletionErrors = true;
                        }
                    }
                } catch (\Exception $e) {
                    $deletionErrors = true;
                }
            }

            if (!$deletionErrors) {
                return @rmdir($path);
            }
            return false;

        } catch (\UnexpectedValueException $e) {
            // Handle permission errors gracefully
            error_log("Directory access denied: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Add each image from an store to the sys_file and sys_file_metadata table via typo3 api
     *
     * @param array  $files
     * @param string $targetFolder
     * @param boolean $delete
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderReadPermissionsException
     * @return FalFile[] $absoluteImagePaths
     */
    public function indexImages($files, $targetFolder, $delete = false, $duplicateBehviour = DuplicationBehavior::RENAME)
    {
        $result = [];
        //$storage = $this->resourceFactory->getDefaultStorage();
        $storage = $this->resourceFactory->getStorageObject(2);

        // TODO use storage methods
        //$this->createDirIfNotExists(Environment::getPublicPath() . '/fileadmin/' . $targetFolder);
        /*$folder = Environment::getPublicPath() . '/fileadmin/' . $targetFolder;
        GeneralUtility::mkdir_deep($folder);*/

        $targetFolder = $storage->getFolder($targetFolder);
        $isFileArray = array_filter($files, 'is_array') === $files;
        if($isFileArray) {
            foreach ($files as $file)
            {
                $tmpFile = $file['tmp_name'];
                if($duplicateBehviour === DuplicationBehavior::RENAME) {
                    $newFile = $targetFolder->addFile($tmpFile, $file['name'], $duplicateBehviour);
                } else {
                    $newFile = $targetFolder->addFile($tmpFile . '/' . $file['name'], $file['name'], $duplicateBehviour);
                }
                if ($newFile && $delete)
                {
                    $this->deleteFolderRecursive(dirname($tmpFile));
                }

                $result[] = $newFile;
            }
        } else {
            $tmpFile = $files['tmp_name'];
            if($duplicateBehviour === DuplicationBehavior::RENAME) {
                $newFile = $targetFolder->addFile($tmpFile, $files['name'], $duplicateBehviour);
            } else {
                $newFile = $targetFolder->addFile($tmpFile . '/' . $files['name'], $files['name'], $duplicateBehviour);
            }
            if ($newFile && $delete)
            {
                $this->deleteFolderRecursive(dirname($tmpFile));
            }

            $result[] = $newFile;
        }



        return $result;
    }


    /**
     * Create a dir if it not exits
     *
     * @param $dir
     *
     * @return void
     */
    protected function createDirIfNotExists($dir)
    {
        if (!is_dir($dir))
        {
            mkdir($dir, 0775, true);
            chmod($dir, 0775);
        }
    }

    /**
     * @param $path
     * @return bool
     */
    public function deleteFolderIfEmpty($path) {
        $path = rtrim($path, '/');

        // Skip if it doesn't exist or is not a directory
        if (!file_exists($path) || !is_dir($path)) {
            return false;
        }

        // Skip systemd-protected directories
        if (strpos($path, '/tmp/systemd-private-') === 0) {
            return false;
        }

        // Check if the directory is empty
        $isEmpty = true;
        $dir = new \FilesystemIterator($path);
        foreach ($dir as $file) {
            // If any file/dir exists (except "." and ".."), mark as non-empty
            if (!$file->isDot()) {
                $isEmpty = false;
                break;
            }
        }

        // Only delete if empty
        if ($isEmpty) {
            return @rmdir($path);
        }

        return false;
    }

    /**
     * Cleanup database records for a deleted file (also removes processed/thumbnail files)
     *
     * @param \TYPO3\CMS\Core\Resource\File $fileObject
     */
    public function removeFileFromRepository(\TYPO3\CMS\Core\Resource\File $fileObject)
    {
        if ($fileObject->exists())
        {
            $fileObject->delete();
        }

    }

    /**
     * Replaces spaces with hyphens and remove special characters from string
     * @param $string
     * @return mixed
     */
    public function cleanString($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
