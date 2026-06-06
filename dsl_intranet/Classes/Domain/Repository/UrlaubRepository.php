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
 * The repository for Urlaubs
 */
class UrlaubRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $orderMapArr = array(
        '0asc' => array(
            'begin' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            'end' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'begin' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            'end' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '4asc' => array(
            'status' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '4desc' => array(
            'status' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
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
        $querySettings->setStoragePageIds(array(22));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param integer $jahr
     */
    public function findByJahr($jahr)
    {
        $jahr_anfang = new \DateTime();
        $jahr_ende = new \DateTime();
        $jahr_anfang->setDate($jahr, 1, 1)->setTime(0, 0, 0);
        $jahr_ende->setDate($jahr + 1, 1, 1)->setTime(0, 0, 0);
        $query = $this->createQuery();
        $query->matching($query->logicalOr(array(
            $query->logicalAnd(array($query->greaterThanOrEqual('begin', $jahr_anfang->format('Y-m-d')), $query->lessThan('begin', $jahr_ende->format('Y-m-d')))),
            $query->logicalAnd(array($query->greaterThanOrEqual('end', $jahr_anfang->format('Y-m-d')), $query->lessThan('end', $jahr_ende->format('Y-m-d'))))
        )));
        $posts = $query->execute();
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
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
        //	sleep(20);
        //\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning('!!!!!!!!!' . time());
        //$logger->warning('Nothing went fine.!!!???!');
        //		BE_USER->simplelog($message, $extKey='', $error=0);
		
		

        $manuallyOrderings = array();
        /*
        order[0][column]	
        0
        order[0][dir]	
        desc
        */

        //\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning('!order!:' . print_r($order, 1));
        foreach ($order as $orderItem) {
            //$manuallyOrderings = $this->orderMapArr[$orderItem["column"].$orderItem["dir"]];
			if(isset($this->orderMapArr[$orderItem['column'] . $orderItem['dir']])) {
				if(is_array($this->orderMapArr[$orderItem['column'] . $orderItem['dir']])) {
					foreach ($this->orderMapArr[$orderItem['column'] . $orderItem['dir']] as $k => $v) {
						$manuallyOrderings[$k] = $v;
					}
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
        
		//echo "blaaa";
        //return $query->execute();
        $andConstraints = array();

        foreach ($settings as $key => $value) {
            //echo "<br>".$key.":".print_r($value,1);
            if (is_array($value)) {
                $orConstraints = array();

                //echo $key.":";
                switch ($key) {
                    case 'mitarbeiter':    //echo "case!!!";
                        //echo $value;
                        foreach ($value as $uid) {

                            $orConstraints[] = $query->equals('mitarbeiter', $uid);
                        }
                        break;
                }
                if (count($orConstraints)) {
                    $andConstraints[] = $query->logicalOr($orConstraints);
                }
            } else {
                switch ($key) {
                    case 'status':    $andConstraints[] = $query->equals('status', $value);
                        break;
                    case 'begin':    $begin = $value->format('Y-m-d');
                        //   $orDateConstraints[] = $query->greaterThanOrEqual('begin', $value->format("Y-m-d"));//$andConstraints[] = $query->greaterThanOrEqual('begin', $value->format("Y-m-d"));
                        break;
                    case 'end':    $end = $value->format('Y-m-d');
                        //   $orDateConstraints[] = $query->lessThanOrEqual('end', $value->format("Y-m-d"));//$andConstraints[] = $query->lessThanOrEqual('end', $value->format("Y-m-d"));
                        break;
                    case 'mitarbeiter':    $andConstraints[] = $query->equals('mitarbeiter', $value);
                        break;
                    case 'jahr':    $jahr_anfang = new \DateTime();
                        $jahr_ende = new \DateTime();
                        $jahr_anfang->setDate($value, 1, 1)->setTime(0, 0, 0);
                        $jahr_ende->setDate($value + 1, 1, 1)->setTime(0, 0, 0);
                        $andConstraints[] = $query->logicalOr(array(
                            $query->logicalAnd(array($query->greaterThanOrEqual('begin', $jahr_anfang->format('Y-m-d')), $query->lessThan('begin', $jahr_ende->format('Y-m-d')))),
                            $query->logicalAnd(array($query->greaterThanOrEqual('end', $jahr_anfang->format('Y-m-d')), $query->lessThan('end', $jahr_ende->format('Y-m-d'))))
                        ));
                        break;
                }
            }
        }

        if (isset($begin) && isset($end)) {
            
            $andConstraints[] = $query->logicalAnd(array(
                $query->logicalOr(array(
                    $query->logicalAnd(array($query->greaterThanOrEqual('end', $end), $query->lessThanOrEqual('begin', $end))),
                    $query->logicalAnd(array($query->greaterThanOrEqual('end', $begin), $query->lessThanOrEqual('begin', $begin))),
                    $query->logicalAnd(array($query->lessThanOrEqual('end', $end), $query->greaterThanOrEqual('begin', $begin)))
                ))
            ));
        } elseif (isset($begin)) {
            $andConstraints[] = $query->greaterThanOrEqual('begin', $begin);
        } elseif (isset($end)) {
            $andConstraints[] = $query->lessThanOrEqual('begin', $end);
        }
        //if (count($orDateConstraints)) {
        //	$andConstraints[] = $query->logicalOr($orDateConstraints);
        //}
        //		$andConstraints[] = $query->like('kunde.name', '%pro haar%');
        //$andConstraints[] = $query->like('auftragsart.titel', '%web%');
        $searchOrConstraints = array();
        if ($search !== false) {
            //Auftragsnummer
            $searchOrConstraints[] = $query->like('uid', '%' . $search . '%');
            //im Auftragstitel
            $searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
            //im Notiz
            $searchOrConstraints[] = $query->like('notiz', '%' . $search . '%');
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
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);die;
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
}
