<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
 * The repository for Hostings
 */
class HostingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $orderMapArr = array(
        '0asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'benutzername' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'benutzername' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
            'hauptTarif.domainname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'hauptTarif.domainname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '9asc' => array(
            'hauptTarif.bezahltbis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '9desc' => array(
            'hauptTarif.bezahltbis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(23));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     */
    public function findByFilter($settings, $offset = false, $limit = false, $order = array(), $search = false)
    {

		$this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
		$this->hostingDomainsRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingDomainsRepository');

		if (!is_array($settings)){
            $settings = json_decode($settings, true);
        }
        //	sleep(20);
        //        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning('!!!!!!!!!' . time());
        $manuallyOrderings = array();
        /*
        order[0][column]	
        0
        order[0][dir]	
        desc
        */

        //        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning('!order!:' . print_r($order, 1));
        foreach ($order as $orderItem) {
            //$manuallyOrderings = $this->orderMapArr[$orderItem["column"].$orderItem["dir"]];
            if (isset($this->orderMapArr[$orderItem['column'] . $orderItem['dir']])) {
                foreach ($this->orderMapArr[$orderItem['column'] . $orderItem['dir']] as $k => $v) {
                    $manuallyOrderings[$k] = $v;
                }
            }
        }
        if (count($manuallyOrderings)) {
            //array_push($manuallyOrderings,$this->defaultOrderings);
            foreach ($this->defaultOrderings as $k => $v) {
                if (!isset($manuallyOrderings[$k])) {
                    $manuallyOrderings[$k] = $v;
                }
            }
            $this->defaultOrderings = $manuallyOrderings;
        }
        $query = $this->createQuery();
        /*$this->defaultOrderings = array(
          'datumfertigstellung' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
          );*/

        //return $query->execute();
        $andConstraints = array();
        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                //echo "<br>".$key.":".print_r($value,1);
                if (is_array($value)) {
                    $orConstraints = array();
                    switch ($key) {
                        case 'kundens':    foreach ($value as $wert) {
                                $orConstraints[] = $query->equals('kunde', $wert);
                            }
                    }
                    if (count($orConstraints)) {
                        $andConstraints[] = $query->logicalOr($orConstraints);
                    }
                } else {
                    switch ($key) {

                    }
                }
            }
        }
        //		$andConstraints[] = $query->like('kunde.name', '%pro haar%');
        //$andConstraints[] = $query->like('auftragsart.titel', '%web%');
        $searchOrConstraints = array();
		
        if ($search) {
            //Auftragsnummer
            $searchOrConstraints[] = $query->like('uid', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('benutzername', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('hauptTarif.domainname', '%' . $search . '%');
            //			$searchOrConstraints[] = $query->like('haupt', '%' . $search . '%');
            /*
            //im Auftragstitel
                        $searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
                        //im Notiz
                        $searchOrConstraints[] = $query->like('notiz', '%' . $search . '%');
            */

            //in codomains
            $codomains = $this->hostingDomainsRepository->findByDomainname($search);
            foreach ($codomains as $codomain) {
                $searchOrConstraints[] = $query->contains('zusatzTarif', $codomain);
            }
            //im kundenname
            $kunden = $this->kundenRepository->findByName('%' . $search . '%', true);
            foreach ($kunden as $kunde) {
                //$searchOrConstraints[] = $query->like('kunde.name', '%'.$kunde->getUid().'%'); //642
                $searchOrConstraints[] = $query->equals('kunde', $kunde);
            }
        }
        if (count($searchOrConstraints)) {
            $andConstraints[] = $query->logicalOr($searchOrConstraints);
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        if ($offset !== false) {
            $query->setOffset($offset);
        }
        if ($limit !== false) {
            $query->setLimit($limit);
        }
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param integer $oldid
     */
    public function findByOldid($oldid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('oldid', $oldid)));
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingDomains> $hauptTarif
     * @return \DslFactory\DslIntranet\Domain\Model\HostingDomains $hosting
     */
    public function findByHauptTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hauptTarif)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('hauptTarif', $hauptTarif)));
        $hosting = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $hosting;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingDomains> $hauptTarif
     * @return \DslFactory\DslIntranet\Domain\Model\HostingDomains $hosting
     */
    public function findByZusatzTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarif)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->contains('zusatzTarif', $zusatzTarif)));
        $hosting = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $hosting;
    }

    public function anzahlByKunde()
    {
        $query = $this->createQuery();
        $query->statement('SELECT kunde, count(kunde) as anzahl FROM tx_dslintranet_domain_model_hosting WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'23\') GROUP BY kunde');
        $anzahlByKunde = $query->execute(TRUE);
        $resArr = array();
        foreach ($anzahlByKunde as $value) {
            $resArr[$value['kunde']] = $value['anzahl'];
        }
        return $resArr;
    }
}
