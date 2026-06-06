<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * The repository for Auftraeges
 */
class AuftraegeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{	
    protected $orderMapArr = array(
        '1asc' => array(
            'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'prioritaet' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'prioritaet' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
			
            'kunde' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
			//,
			//'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
			
        ),
        '3desc' => array(
			
            'kunde' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
			//,
			//'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '4asc' => array(
            'auftragsart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '4desc' => array(
            'auftragsart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '6asc' => array(
            'datumfertigstellung' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '6desc' => array(
            'datumfertigstellung' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '7asc' => array(
            'status' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '7desc' => array(
            'status' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    protected $orderMapKundeArr = array(
        '0asc' => array(
            'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'auftragsart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'auftragsart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
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
        $querySettings->setStoragePageIds(array(9, 25));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param $uid
     */
    public function findByUidCheckMitarbeiterGroup($uid)
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $query = $this->createQuery();
        $andConstraints = array();
        $mitarbeiterGroups = $mitarbeiter->getUsergroup();
        if (!count($mitarbeiterGroups)) {
            return false;
        }
        $orConstraints = array();
        foreach ($mitarbeiterGroups as $value) {
            $orConstraints[] = $query->contains('fegroups', $value);
        }
        $andConstraints[] = $query->logicalOr($orConstraints);
        $andConstraints[] = $query->equals('uid', $uid);
        $query->matching($query->logicalAnd($andConstraints));
        return $query->execute()->getFirst();
    }

    /**
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     * @param integer $kunde
     * @param array $exclude
     */
    public function findByFilter($settings, $offset = false, $limit = false, $order = array(), $search = false, $kunde = false, $exclude = false)
    {
		$this->projekteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProjekteRepository');
		$this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
		$this->projekteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProjekteRepository');


		if (!is_array($settings)){
            $settings = json_decode($settings, true);
        }
        if ($limit === -1) {
            $limit = false;
        }


        

        //	sleep(20);
        //\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning('!!!!!!!!!' . time());
        //$logger->warning('Nothing went fine.!!!???!');
        //		BE_USER->simplelog($message, $extKey='', $error=0);
        $manuallyOrderings = array();
        foreach ($order as $orderItem) {
            if ($kunde) {
                foreach ($this->orderMapKundeArr[$orderItem['column'] . $orderItem['dir']] as $k => $v) {
                    $manuallyOrderings[$k] = $v;
                }
            } else {
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
        } else {
			$this->defaultOrderings = array(
				'datum' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
			);
		}
        $query = $this->createQuery();
        /*$this->defaultOrderings = array(
          'datumfertigstellung' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
          );*/

        //return $query->execute();
        $andConstraints = array();




        if($exclude){
            if(count($exclude)){
                $excludeOrConstraints = array();
                foreach($exclude as $uid){
                    $excludeOrConstraints[] = $query->equals('uid', $uid);
                }
                $andConstraints[] = $query->logicalNot($query->logicalOr($excludeOrConstraints));
            }
        }


        if ($kunde) {
            $andConstraints[] = $query->equals('kunde', $GLOBALS['TSFE']->fe_user->user['uid']);
            $andConstraints[] = $query->equals('sichtbarkeit', 1);
        } else {


            /*bei externen mitarbeitern den filter dass nur aufträge angezeigt werden in welche er involviert ist */
            $feuser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            if($feuser->getRechteExternerMitarbeiter()){
                $andConstraints[] = $query->contains('mitarbeiter', $feuser->getUid());
            }

            //bei mitarbeitern
            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            $orConstraints = array();
            foreach ($mitarbeiter->getUsergroup() as $fegroup) {
                $orConstraints[] = $query->contains('fegroups', $fegroup);
            }
            if (count($orConstraints)) {
                
            }
        }
        $nurFavoriten = false;
        if (isset($settings['favoriten'])) {
            if ($settings['favoriten']) {
                $nurFavoriten = true;
            }
        }



        //die;
        if ($nurFavoriten) {
            //echo "nurFav";die;
            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            $orConstraints = array();
            //echo count($mitarbeiter->getAblage());
            foreach ($mitarbeiter->getAblage() as $ablage) {
                //echo "::".$ablage->getUid();
                if($ablage->getAuftrag()){
                	$orConstraints[] = $query->equals('uid', $ablage->getAuftrag()->getUid());
				}
            }
            //die;
            if (count($orConstraints)) {
                $andConstraints[] = $query->logicalOr($orConstraints);
            } else {
                return NULL;
            }
        } else {
			if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                //echo "<br>".$key.":".print_r($value,1);
                if (is_array($value)) {
                    $orConstraints = array();
                    switch ($key) {
                        case 'prioritaets':    foreach ($value as $wert) {
                                $orConstraints[] = $query->equals('prioritaet', $wert);
                            }
                            break;
                        case 'kundens':    foreach ($value as $wert) {
                                $orConstraints[] = $query->equals('kunde', $wert);
                            }
                            break;
                        case 'auftragsartens':    foreach ($value as $wert) {
                                $orConstraints[] = $query->equals('auftragsart', $wert);
                            }
                            break;
                        case 'mitarbeiters':    foreach ($value as $wert) {
                                $orConstraints[] = $query->contains('mitarbeiter', $wert);
                            }
                            $orConstraints[] = $query->equals('ansprechpartner', $wert);
                            break;
                        case 'statuss':    foreach ($value as $wert) {
                                if ($kunde) {
                                    if ($wert == 20) {
                                        $orConstraints[] = $query->equals('status', 10);
                                    }
                                    if ($wert == 60) {
                                        $orConstraints[] = $query->equals('status', 70);
                                    }
                                }
                                $orConstraints[] = $query->equals('status', $wert);
                            }
                            break;
                    }
                    if (count($orConstraints)) {
                        $andConstraints[] = $query->logicalOr($orConstraints);
                    }
                } else {
                    switch ($key) {
                        case 'von':    //die;
                            if ($value) {
                                $von = new \DateTime($value);
                                //date_s($von, date_interval_create_from_date_string('1 days'));
                                $vonBeginOfDay = new \DateTime($von->format('Y-m-d'));
                                $andConstraints[] = $query->greaterThan('datum', $vonBeginOfDay->getTimestamp() - 1);
                            }
                            break;
                        case 'bis':    //die;
                            if ($value) {
                                $bis = new \DateTime($value);
                                date_add($bis, date_interval_create_from_date_string('1 days'));
                                $bisNextDay = new \DateTime($bis->format('Y-m-d'));
                                $andConstraints[] = $query->lessThanOrEqual('datum', $bisNextDay->getTimestamp() - 1);
                            }
                            break;
                        case 'suchtext':    //   die;
                            $search = $value;
                            break;
                    }
                }
            }
			}
		}
        //		$andConstraints[] = $query->like('kunde.name', '%pro haar%');
        //$andConstraints[] = $query->like('auftragsart.titel', '%web%');
        $searchOrConstraints = array();
        if ($search !== false) {
            //Auftragsnummer
            $searchOrConstraints[] = $query->logicalOr(array($query->equals('uid', intval($search)), $query->like('uid', '%' . $search . '%')));
            //$query->logicalOr($searchOrConstraints)
            //im Auftragstitel
            $searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
			//$searchOrConstraints[] = $query->like('projekt.titel', '%' . $search . '%');
			
			
			
			$projekte = $this->projekteRepository->findBySearch($search);
			foreach($projekte as $projekt){
				$searchOrConstraints[] = $query->equals('projekt', $projekt);
			}
			
			
            //im kundenname
            if (!$kunde) {
                // wenn nicht gerade das kundenlogin plugin ausgeführt wurde also nur wenn das modul sich im mitarbeiter modus befindet
                $kunden = $this->kundenRepository->findByName('%' . $search . '%', true);
                foreach ($kunden as $kundev) {
                    //$searchOrConstraints[] = $query->like('kunde.name', '%'.$kunde->getUid().'%'); //642
                    $searchOrConstraints[] = $query->equals('kunde', $kundev);
                }
            }
        }
        if (count($searchOrConstraints)) {
            $andConstraints[] = $query->logicalOr($searchOrConstraints);
        }
        //$andConstraints[] = $query->like('kunde.qbrefnum', '%'.$search.'%'); //642
        //$andConstraints[] = $query->equals('kunde.qbrefnum', '642'); //642
        //$andConstraints[] = $query->like('mitarbeiter.initialien', '%MZ%'); //642
        //		$andConstraints[] = $query->like('kunde', '%'.$kunde->getUid().'%'); //642
        //$kunde = $this->kundenRepository->findBySearch();
        //echo "!";
        //$kunde = $this->kundenRepository->findByUid(1709);
        //$andConstraints[] = $query->equals('kunde', $kunde); //642
        //$andConstraints[] = $query->like('kunde.spitzname', "%test%");
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        //	$limit=2;
        //		$offset=1;
        //$query->setOffset(0);
        //$query->setLimit(2);
        if ($offset !== false) {
            $query->setOffset($offset);
        }
        if ($limit !== false) {
            $query->setLimit($limit);
        }
        //		if($search !== false) $query->setLimit($limit);
        //[search][value]
        //$query->setOffset(0);
        //$query->setLimit(1);
        //$query->setOffset(2);
        $posts = $query->execute();
        // 		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        //		die;
        return $posts;
    }

    public function anzahlByKunde()
    {
        $query = $this->createQuery();
        $query->statement('SELECT kunde, count(kunde) as anzahl FROM tx_dslintranet_domain_model_auftraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') GROUP BY kunde');
        $anzahlByKunde = $query->execute(TRUE);
        $resArr = array();
        foreach ($anzahlByKunde as $value) {
            $resArr[$value['kunde']] = $value['anzahl'];
        }
        return $resArr;
    }

    public function anzahlAVByKunde()
    {
        $query = $this->createQuery();
        $query->statement('SELECT kunde, count(kunde) as anzahl FROM tx_dslintranet_domain_model_auftraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND auftragsart=6 GROUP BY kunde');
        $anzahlByKunde = $query->execute(TRUE);
        $resArr = array();
        foreach ($anzahlByKunde as $value) {
            $resArr[$value['kunde']] = $value['anzahl'];
        }
        return $resArr;
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

    public function getAgenturvertraegeRange()
    {
        $now = new \DateTime();
        $query = $this->createQuery();
        $query->statement('SELECT datum_abschluss FROM tx_dslintranet_domain_model_auftraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND auftragsart=6 ORDER BY datum_abschluss ASC LIMIT 0,1');
        $datumFirst = $query->execute(TRUE);
        $query->statement('SELECT datum_abschluss FROM tx_dslintranet_domain_model_auftraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25,9\') AND auftragsart=6 ORDER BY datum_abschluss DESC LIMIT 0,1');
        $datumLast = $query->execute(TRUE);
        if (!$datumFirst[0]['datum_abschluss']) {
            $minDate = new \DateTime();
        } else {
            $minDate = new \DateTime('@' . $datumFirst[0]['datum_abschluss']);
        }
        if (!$datumLast[0]['datum_abschluss']) {
            $maxDate = new \DateTime('31.12.' . ($now->format('Y') + 1));
        } else {
            $maxDate = new \DateTime('@' . $datumLast[0]['datum_abschluss']);
        }
        $minDate = new \DateTime('01.01.' . $minDate->format('Y'));
        $maxDate = new \DateTime('31.12.' . $maxDate->format('Y'));
        if (intval($maxDate->format('Y')) < $now->format('Y') + 1) {
            $maxDate = new \DateTime('31.12.' . ($now->format('Y') + 1));
        }
        //if($maxDate->format('Y') <= $now->format('Y')) $maxDate = new \DateTime( $maxDate->format('d.m.').($now->format('Y')+1) );
        // $maxDate = date_add($maxDate, date_interval_create_from_date_string('1 month'));
        //$maxDate = date_sub($maxDate, date_interval_create_from_date_string('1 day'));
        return array('minDate' => $minDate, 'maxDate' => $maxDate);
    }

    //first last SELECT * FROM tx_dslintranet_domain_model_auftraege WHERE auftragsart=6 AND deleted=0 AND hidden=0 AND FIND_IN_SET(pid,'25,9') ORDER BY datum
    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertrag
     * @param integer $kunde
     */
    public function findAuftraegeByAgenturvertrag($agenturvertrag, $kunde = false)
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('auftragsart', 6);
        $andConstraints[] = $query->equals('kunde', $agenturvertrag->getKunde());
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', $agenturvertrag->getVertragsbegin());
        if ($agenturvertrag->getVertragsende()) {
            $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($agenturvertrag->getVertragsende()->format('d.m.Y') . ' 23:59:59'));
        }
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', new \DateTime($settings['start'] . ' 00:00:00'));
        $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($settings['end'] . ' 23:59:59'));
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertrag
     * @param integer $kunde
     */
    public function findAuftraegeByAgenturvertragJahr($agenturvertrag = false, $kunde = false)
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('auftragsart', 6);
        if ($agenturvertrag) {
            $andConstraints[] = $query->equals('kunde', $agenturvertrag->getKunde());
            $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', $agenturvertrag->getVertragsbegin());
            if ($agenturvertrag->getVertragsende()) {
                $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($agenturvertrag->getVertragsende()->format('d.m.Y') . ' 23:59:59'));
            }
        }
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $start = new \DateTime('01.01.' . $settings['statJahr']);
        $end = new \DateTime('31.12.' . $settings['statJahr']);
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', new \DateTime($start->format('d.m.Y') . ' 00:00:00'));
        $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($end->format('d.m.Y') . ' 23:59:59'));
        //echo "<br>greaterThanOrEqual('datum_abschluss".$start->format('d.m.Y'). ' 00:00:00';
        //echo "<br>lessThanOrEqual('datum_abschluss".$end->format('d.m.Y').' 23:59:59';
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertrag
     * @param integer $kunde
     */
    public function findAuftraegeByKundenAgenturvertragJahr($agenturvertrag = false, $kunde = false)
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('auftragsart', 6);
        if ($agenturvertrag) {
            $andConstraints[] = $query->equals('kunde', $agenturvertrag->getKunde());
            $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', $agenturvertrag->getVertragsbegin());
            if ($agenturvertrag->getVertragsende()) {
                $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($agenturvertrag->getVertragsende()->format('d.m.Y') . ' 23:59:59'));
            }
        }
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $start = new \DateTime('01.01.' . $agenturvertrag->getMonth()->format('Y'));
        $end = new \DateTime('31.12.' . $agenturvertrag->getMonth()->format('Y'));
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', new \DateTime($start->format('d.m.Y') . ' 00:00:00'));
        $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($end->format('d.m.Y') . ' 23:59:59'));
        //echo "<br>greaterThanOrEqual('datum_abschluss".$start->format('d.m.Y'). ' 00:00:00';
        //echo "<br>lessThanOrEqual('datum_abschluss".$end->format('d.m.Y').' 23:59:59';
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege $agenturvertrag
     * @param integer $kunde
     */
    public function findAuftraegeByKundenAgenturvertrag($agenturvertrag, $kunde = false)
    {
        //return false;
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('auftragsart', 6);
        $andConstraints[] = $query->equals('kunde', $agenturvertrag->getKunde());
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', $agenturvertrag->getVertragsbegin());
        if ($agenturvertrag->getVertragsende()) {
            $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($agenturvertrag->getVertragsende()->format('d.m.Y') . ' 23:59:59'));
        }
        //$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        //$settings = $mitarbeiter->getSettingsAgenturauftrag();
        //$start = new \DateTime('01.01.' . $settings['statJahr']);
        //$end = new \DateTime('31.12.' . $settings['statJahr']);
        $start = new \DateTime('01.' . $agenturvertrag->getMonth()->format('m.Y'));
        $end = clone $start;
        date_add($end, date_interval_create_from_date_string('1 month'));
        date_sub($end, date_interval_create_from_date_string('1 day'));
        //echo $start->format('d.m.Y') . ' 00:00:00';
        //echo $end->format('d.m.Y') . ' 23:59:59';
        //die;
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', new \DateTime($start->format('d.m.Y') . ' 00:00:00'));
        $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($end->format('d.m.Y') . ' 23:59:59'));
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }
	
	
		/**
     * @param \DslFactory\DslIntranet\Domain\Model\Projekte $projekt
     * @param integer $kunde
     */
    public function findAuftraegeByProjekt($projekt, $kunde = false)
    {
        //return false;
		
		
		$this->defaultOrderings = array(
				'datum_abschluss' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
			);
		
        $query = $this->createQuery();
        $andConstraints = array();
        //$andConstraints[] = $query->equals('auftragsart', 6);
        $andConstraints[] = $query->equals('projekt', $projekt);
        /*$andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', $agenturvertrag->getVertragsbegin());
        if ($agenturvertrag->getVertragsende()) {
            $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($agenturvertrag->getVertragsende()->format('d.m.Y') . ' 23:59:59'));
        }*/
		/*
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAgenturauftrag();
        $andConstraints[] = $query->greaterThanOrEqual('datum_abschluss', new \DateTime($settings['start'] . ' 00:00:00'));
        $andConstraints[] = $query->lessThanOrEqual('datum_abschluss', new \DateTime($settings['end'] . ' 23:59:59'));
        */
		if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }
	
	
}
