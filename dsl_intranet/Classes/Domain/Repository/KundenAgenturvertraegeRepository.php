<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for KundenAgenturvertraeges
 */
class KundenAgenturvertraegeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(9, 25));
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findAllForKunde()
    {
        $query = $this->createQuery();
        //$query->setOrderings(array("sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $kunde = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $andConstraints = array();
        $andConstraints[] = $query->equals('kunde', $kunde);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        return $query = $query->execute();
    }

    public function getRange()
    {
        $now = new \DateTime();
        $kunde = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $query = $this->createQuery();
        $query->statement('SELECT vertragsbegin FROM tx_dslintranet_domain_model_agenturvertraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND kunde = ' . $kunde->getUid() . ' ORDER BY vertragsbegin ASC LIMIT 0,1');
        $datumFirst = $query->execute(TRUE);
        $query->statement('SELECT vertragsende FROM tx_dslintranet_domain_model_agenturvertraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND kunde = ' . $kunde->getUid() . ' AND vertragsende=\'0000-00-00\'');
        $datumLastOpened = $query->execute(TRUE);
        if (!$datumLastOpened) {
            //print_r($datumLastOpened);die;
            $query->statement('SELECT vertragsende FROM tx_dslintranet_domain_model_agenturvertraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND kunde = ' . $kunde->getUid() . ' ORDER BY vertragsende DESC LIMIT 0,1');
            $datumLast = $query->execute(TRUE);
        }
        if (!isset($datumFirst[0]['vertragsbegin'])) {
            $minDate = new \DateTime();
        } else {
            $minDate = new \DateTime($datumFirst[0]['vertragsbegin']);
        }
        if (!isset($datumLast[0]['vertragsende'])) {
            $maxDate = new \DateTime();
        } else {
            $maxDate = new \DateTime($datumLast[0]['vertragsende']);
        }
        //echo $maxDate->format("d.m.Y");die;
        $minDate = new \DateTime('01.' . $minDate->format('m.Y'));
        if ($maxDate > $now) {
            $maxDate = $now;
        }
        $maxDate = new \DateTime('01.' . $maxDate->format('m.Y'));
        /*if (intval($maxDate->format('Y')) < $now->format('Y') + 1) {
          $maxDate = new \DateTime('31.12.' . ($now->format('Y') + 1));
          }*/

        //if($maxDate->format('Y') <= $now->format('Y')) $maxDate = new \DateTime( $maxDate->format('d.m.').($now->format('Y')+1) );
        // $maxDate = date_add($maxDate, date_interval_create_from_date_string('1 month'));
        //$maxDate = date_sub($maxDate, date_interval_create_from_date_string('1 day'));
        return array('minDate' => $minDate, 'maxDate' => $maxDate);
    }
}
