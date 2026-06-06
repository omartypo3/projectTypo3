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
 * The repository for HostingDomains
 */
class HostingDomainsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $orderMapArr = array(
        '3asc' => array(
            'domainname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'domainname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '9asc' => array(
            'bezahltbis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '9desc' => array(
            'bezahltbis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
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
     * @param \DslFactory\DslIntranet\Domain\Model\Hosting $hosting
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     */
    public function findByFilter(\DslFactory\DslIntranet\Domain\Model\Hosting $hosting = NULL, \DslFactory\DslIntranet\Domain\Model\HostingDomains $hostingDomains = NULL, $settings, $offset = false, $limit = false, $order = array(), $search = false)
    {
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
        //Hauptdomain rausfiltern
        //if($hostingDomains)  $query->matching($query->logicalNot($query->equals('uid', $hostingDomains)));
        //$andConstraints[] = $query->equals('uid', 1);
        if ($hosting) {
            $andConstraints[] = $query->equals('hosting2', $hosting);
        }
        if ($settings) {
            if (is_array($settings)) {
                foreach ($settings as $key => $value) {
                    //echo "<br>".$key.":".print_r($value,1);
                    if (is_array($value)) {
                        $orConstraints = array();
                        switch ($key) {
                            case 'statuss':    break;
                        }
                        if (count($orConstraints)) {
                            $andConstraints[] = $query->logicalOr($orConstraints);
                        }
                    } else {
                        //echo "<br>key:".$key;
                        //echo "<br>value:".$value;
                        switch ($key) {
                            case 'statuss':    $orConstraints = array();
                                switch ($value) {
                                    case 10:    //Alle
                                        break;
                                    case 20:    //fällig und überfällige
                                        $dateFaellig = new \DateTime(date('Y-m-d H:i:s', mktime(0, 0, 0, (int)date('m'), 1, (int)date('Y'))));
                                        date_add($dateFaellig, date_interval_create_from_date_string('1 months'));
                                        $orConstraints[] = $query->lessThanOrEqual('bezahltbis', $dateFaellig->format('Ymd'));
                                        break;
                                }
                                if (count($orConstraints)) {
                                    $andConstraints[] = $query->logicalOr($orConstraints);
                                }
                                break;
                        }
                    }
                }
            }
        }
        $searchOrConstraints = array();
        if ($search !== false) {
            //Auftragsnummer
            //            $searchOrConstraints[] = $query->like('uid', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('domainname', '%' . $search . '%');
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
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        // exit;
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param integer $oldid
     */
    public function findByOldid($oldid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('oldid', intval($oldid))));
        $posts = $query->execute()->getFirst();
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param string $searchDomainname
     */
    public function findByDomainname($searchDomainname)
    {
        $query = $this->createQuery();
        $query->matching($query->like('domainname', '%' . $searchDomainname . '%'));
        //$query->matching($query->logicalAnd($query->equals('oldid', intval($oldid))));
        $posts = $query->execute();
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }
}
