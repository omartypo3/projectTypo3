<?php
namespace Emagineurs\EComment\Domain\Repository;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CategoryRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        $this->objectType = \TYPO3\CMS\Extbase\Domain\Model\Category::class;
    }

    /**
     * Find file categories
     *
     * @param FileInterface $file
     * @return array
     */
    public function findByFile(FileInterface $file): array
    {
        if ($file instanceof \TYPO3\CMS\Core\Resource\ProcessedFile) {
            $file = $file->getOriginalFile();
        }
        
        $uid = (int)$file->getProperty('uid');
        $query = $this->createQuery();
        $query->statement("SELECT sys_category.* FROM sys_category,sys_category_record_mm,sys_file_metadata WHERE sys_category.uid=sys_category_record_mm.uid_local AND sys_category_record_mm.tablenames='sys_file_metadata' AND sys_category_record_mm.uid_foreign=sys_file_metadata.uid AND sys_file_metadata.file=" . $uid);
        return $query->execute()->toArray();
    }
}