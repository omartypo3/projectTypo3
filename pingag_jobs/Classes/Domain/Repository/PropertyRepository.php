<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 06.08.2018
 * Time: 14:40
 */

namespace Pingag\PingagJobs\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class PropertyRepository extends Repository
{
    public function findAllByType($type, $languageUid = null)
    {
        $query = $this->createQuery();
        if($languageUid !== null){
            $query->getQuerySettings()->setLanguageUid($languageUid);
        }
        $query->matching($query->equals('type', $type));
        return $query->execute();
    }
    
    public function findByImportId($id)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setLanguageUid(0);
        $query->matching($query->equals('import_id', $id));
        return $query->execute();    
    }
}