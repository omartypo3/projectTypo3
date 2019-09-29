<?php

namespace FRONTAL\FagInstitutionManagement\Domain\Repository;


/**
 * The repository for Dates
 */
class DatesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);

        $this->setDefaultQuerySettings($querySettings);
    }
    public function addDate($starttime,$endtime){
        $Query = $this->createQuery();
        $Query->getQuerySettings()->setRespectStoragePage(FALSE);
        $Query->statement("INSERT INTO `tx_faginstitutionmanagement_domain_model_dates`(`startdate`, `enddate`) VALUES ('".$starttime."','".$endtime."')");
        return $Query->execute();
    }

}
