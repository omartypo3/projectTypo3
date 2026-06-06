<?php
namespace Emagineurs\EMagineurs\Xclass;

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\MathUtility;

readonly class FileRepository extends \TYPO3\CMS\Core\Resource\FileRepository
{
    public function findFileReferenceByUid($uid)
    {
        if (!MathUtility::canBeInterpretedAsInteger($uid)) {
            throw new \InvalidArgumentException('The UID of record has to be an integer. UID given: "' . $uid . '"', 1316889798);
        }
        try {
            $fileReferenceObject = $this->factory->getFileReferenceObject($uid);
        } catch (\InvalidArgumentException | \TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException $exception) {
            $fileReferenceObject = false;
        }
        return $fileReferenceObject;
    }
}
