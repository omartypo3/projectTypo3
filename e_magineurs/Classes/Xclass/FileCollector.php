<?php
namespace Emagineurs\EMagineurs\Xclass;

class FileCollector extends \TYPO3\CMS\Frontend\Resource\FileCollector
{
    public function addFileReferences(array $fileReferenceUids = []): void
    {
        foreach ($fileReferenceUids as $fileReferenceUid) {
            try {
                $fileObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject($fileReferenceUid);
                if ($fileObject instanceof \TYPO3\CMS\Core\Resource\FileReference) {
                    $this->addFileObject($fileObject);
                }
            } catch (\Throwable $e) {
                // ignore missing/deleted references
            }
        }
    }
}
