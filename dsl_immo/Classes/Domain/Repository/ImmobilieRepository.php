<?php
namespace DslFactory\DslImmo\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * The repository for Immobilies
 */
class ImmobilieRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    public function getOldRealUrl()
    {
        $sqlNot = '';
        $immobilies = $this->findAll();
        $aktivArr = array();
        foreach ($immobilies as $immobilie) {
            $aktivArr[] = $immobilie->getUid();
        }
        if ($aktivArr) {
            $sqlNotArr = array();
            foreach ($aktivArr as $immobilieUid) {
                $sqlNotArr[] = 'original_url LIKE \'%immobilie%5D=' . $immobilieUid . '\'';
                $sqlNotArr[] = 'original_url LIKE \'%immobilie%5D=' . $immobilieUid . '&%\'';
            }
            if (count($sqlNotArr)) {
                $sqlNot = ' AND NOT (' . implode(' OR ', $sqlNotArr) . ')';
            }
        }
        $aktivArr[] = $sqlNot;
        $sqlCleanRealUrl = 'SELECT * FROM tx_realurl_urldata WHERE original_url LIKE \'%immobilie%5D=%\' ' . $sqlNot;
        $aktivArr[] = $sqlCleanRealUrl;
        $query = $this->createQuery();
        $query->statement($sqlCleanRealUrl);
        $result = $query->execute(TRUE);
        return $result;
    }

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(false);
        // neue Storage IDs
        //$querySettings->setStoragePageIds(array(9, 25));
        // neue Storage IDs
        $storage = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
        if (isset($storage['storagePid'])) {
            $querySettings->setStoragePageIds(array($storage['storagePid']));
        } else {
            $querySettings->setRespectStoragePage(false);
        }
        if (TYPO3_MODE === 'BE') {
            $querySettings->setIgnoreEnableFields(true);
            $querySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        }
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param string $openimmoobid
     */
    public function findByObjektid($openimmoobid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('openimmoobid', $openimmoobid)));
        $post = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $post;
    }

    /**
     * @param int $uid
     */
    public function findByUidBackend($uid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('uid', $uid)));
        $post = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $post;
    }

    /**
     * @param mixed $uids
     */
    public function findByUids($uids)
    {
        $query = $this->createQuery();
        $orConstraints = array();
        //print_r($uids);
        foreach ($uids as $uid) {
            $orConstraints[] = $query->equals('uid', $uid);
        }
        //print_r($orConstraints);
        //die;
        if (count($orConstraints)) {
            $query->matching($query->logicalAnd($query->logicalOr($orConstraints)));
            //	\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
            //	die;
            return $query->execute();
        }
        return false;
    }

    /**
     * @param $pid
     */
    public function findAllRespectFrontend($pid)
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds(array($pid));
        $this->setDefaultQuerySettings($querySettings);
        $query = $this->createQuery();
        // $querySettings->setIgnoreEnableFields(true);
        //$querySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        //$query->matching($query->logicalAnd($query->equals('uid', $uid)));
        return $query->execute();
    }

    /**
     * @param $filter
     */
    public function findAllHighlights($filter = array())
    {
        $query = $this->createQuery();
        $andConstraints = array();
        if (isset($filter['highlight'])) {
            $andConstraints[] = $query->equals('highlight', $filter['highlight']);
        }
        if ($filter['vermarktung']) {
            $tmpArr = explode(',', $filter['vermarktung']);
            $orConstraints = array();
            foreach ($tmpArr as $value) {
                $orConstraints[] = $query->equals('search_vermarktung', $value);
            }
            $andConstraints[] = $query->logicalOr($orConstraints);
        }
        if ($filter['objekttyp']) {
            $tmpArr = explode(',', $filter['objekttyp']);
            $orConstraints = array();
            foreach ($tmpArr as $value) {
                $orConstraints[] = $query->equals('search_objekt_typ', $value);
            }
            $andConstraints[] = $query->logicalOr($orConstraints);
        }
        $query->matching($query->logicalAnd($andConstraints));
        return $query->execute();
    }
	
	 /**
     * @param $filter
     */
    public function findAllSelected($filter = array())
    {
        $query = $this->createQuery();
        $andConstraints = array();
      
        if (isset($filter['objekte'])) if(count($filter['objekte'])) {
            
            $orConstraints = array();
            foreach ($filter['objekte'] as $value) {
                $orConstraints[] = $query->equals('objekt_nrextern', $value);
            }
            $andConstraints[] = $query->logicalOr($orConstraints);
        }
        
        $query->matching($query->logicalAnd($andConstraints));
        return $query->execute();
    }

    /**
     * @param mixed $session
     */
    public function findByMerkliste($session)
    {
        $immobilien = false;
        if (isset($session['bookmarks'])) {
            if (is_array($session['bookmarks'])) {
                foreach ($session['bookmarks'] as $uid) {
                    if ($immobilie = $this->findByUid($uid)) {
                        if (!is_array($immobilien)) {
                            $immobilien = array(

                            );
                        }
                        $immobilien[] = $immobilie;
                    }
                }
            }
        }
        return $immobilien;
    }

    /**
     * @param mixed $session
     */
    public function findBySearch($session)
    {
        $query = $this->createQuery();
        //$query->matching($query->logicalAnd($query->equals('uid', 2)));
        $andConstraints = array();
        $andConstraints = $this->getAdditionalImmobilienFilter($session['search'], $query, $andConstraints);
        /*
        		if ($session['search']['preisRange']) {
        			//echo "haaaa!!!";
        			switch((int)$session['search']['preisRange']){
        				case 10: //bis 200
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 200);
        					
        					break;
        				case 20: //bis 350
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 350);
        					break;
        				case 30: //bis 500
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 500);
        					break;
        				case 40: //bis 650
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 650);
        					break;
        				case 50: //bis 950
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 950);
        					break;
        				case 60: //bis 1500
        					$andConstraints[] = $query->lessThanOrEqual('preis_kaltmiete', 1500);
        					break;
        				
        			}
        		}
        */

        if ($session['search']['flaeche']['from'] && $session['search']['flaeche']['to']) {
            $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', (double) $session['search']['flaeche']['from']);
            $andConstraints[] = $query->lessThanOrEqual('search_flaeche', (double) $session['search']['flaeche']['to']);
        } elseif($session['search']['flaeche']['to']){
            $andConstraints[] = $query->lessThanOrEqual('search_flaeche', (double) $session['search']['flaeche']['to']);
        }
        if ($session['search']['preis']['from'] && $session['search']['preis']['to']) {
            $andConstraints[] = $query->greaterThanOrEqual('search_preis', (double) $session['search']['preis']['from']);
            $andConstraints[] = $query->lessThanOrEqual('search_preis', (double) $session['search']['preis']['to']);
        } elseif($session['search']['preis']['to']){
            $andConstraints[] = $query->lessThanOrEqual('search_preis', (double) $session['search']['preis']['to']);
        }
        if ($session['search']['zimmer']['from'] && $session['search']['zimmer']['to']) {
            $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', $session['search']['zimmer']['from']);
            $andConstraints[] = $query->lessThanOrEqual('flaechen_anzahl_zimmer', $session['search']['zimmer']['to']);
        } elseif($session['search']['zimmer']['to']){
            $andConstraints[] = $query->lessThanOrEqual('flaechen_anzahl_zimmer', $session['search']['zimmer']['to']);
        }
        if ($session['search']['gebiet']) {
            switch ($session['search']['gebiet']) {
                case 910:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Altbau');
                    break;
                case 920:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                    break;
                case 930:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Wasserturmgebiet');
                    break;
            }
        }
        if ($session['search']['wobatype']) {
            switch ($session['search']['wobatype']) {
                case 810:    //bei mietwohnung alles ausgeben
                    //$andConstraints[] = $query->equals('ausstattung_wggeeignet', 0);
                    //$andConstraints[] = $query->equals('ausstattung_seniorengerecht', 0);
                    break;
                case 820:    $andConstraints[] = $query->equals('ausstattung_wggeeignet', 1);
                    break;
                case 830:    $andConstraints[] = $query->equals('ausstattung_seniorengerecht', 1);
                    break;
            }
        }
        if (isset($session['search']['keller']) && $session['search']['keller']) {
            $andConstraints[] = $query->logicalOr($query->equals('ausstattung_unterkellert', 10), $query->equals('ausstattung_unterkellert', 30));
        }
        if (isset($session['search']['badewanne']) && $session['search']['badewanne']) {
            $andConstraints[] = $query->logicalOr(array($query->equals('ausstattung_bad', '20'), $query->like('ausstattung_bad', '20,%'), $query->like('ausstattung_bad', '%,20'), $query->like('ausstattung_bad', '%,20,%')));
        }
        if (isset($session['search']['balkon']) && $session['search']['balkon']) {
            $andConstraints[] = $query->logicalOr(array(
                $query->logicalNot($query->equals('flaechen_anzahl_balkone', 0)),
                $query->logicalNot($query->equals('flaechen_anzahl_terassen', 0)),
                $query->logicalNot($query->equals('flaechen_anzahl_logia', 0))
            ));
        }
        if (isset($session['search']['haustiere']) && $session['search']['haustiere']) {
            $andConstraints[] = $query->equals('haustiere', 1);
        }
        if (isset($session['search']['aufzug']) && $session['search']['aufzug']) {
            $andConstraints[] = $query->logicalNot($query->equals('ausstattung_fahrstuhl', ''));
        }
        if (isset($session['search']['parkplatz']) && $session['search']['parkplatz']) {
            $andConstraints[] = $query->logicalOr(array(
                $query->logicalNot($query->equals('preise_stp_freiplatz_anzahl', 0)),
                $query->logicalNot($query->equals('preise_stp_sonstige_anzahl', 0)),
                $query->logicalNot($query->equals('preise_stp_sonstige_platzart', ''))
            ));
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $post = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $post;
    }

    /**
     * @param mixed $filter
     * @param $sort
     */
    public function findByFilter($filter = false, $sort = false)
    {
        /*
        		
        		[sorting] => Array
                (
                    [field] => uid
                    [dir] => DESC
                    [active] => 
                )
        */

        //$this->defaultOrderings = array('search_preis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        if (is_array($sort)) {
            //echo "jaa;".$sort["field"];
            $this->defaultOrderings = array($sort['field'] => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        }
        $query = $this->createQuery();
        //$query->matching($query->logicalAnd($query->equals('uid', 2)));
        if ($filter) {
            //print_r($filter);die;
            $andConstraints = array();
            if (isset($filter['flaeche']['from']) && $filter['flaeche']['to']) {
                //$andConstraints[] = $query->logicalOr($query->logicalAnd($query->greaterThanOrEqual('flaechen_wohnflaeche', $filter['flaeche']['from']), $query->lessThanOrEqual('flaechen_wohnflaeche', $filter['flaeche']['to'])), $query->logicalAnd($query->greaterThanOrEqual('flaechen_gesamtflaeche', $filter['flaeche']['from']), $query->lessThanOrEqual('flaechen_gesamtflaeche', $filter['flaeche']['to'])));
                $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', (double) $filter['flaeche']['from']);
                $andConstraints[] = $query->lessThanOrEqual('search_flaeche', (double) $filter['flaeche']['to']);
            }
            if (isset($filter['preis']['from']) && $filter['preis']['to']) {
                $andConstraints[] = $query->greaterThanOrEqual('search_preis', (double) $filter['preis']['from']);
                $andConstraints[] = $query->lessThanOrEqual('search_preis', (double) $filter['preis']['to']);
            }
            if (isset($filter['zimmer']['from']) && $filter['zimmer']['to']) {
                $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', $filter['zimmer']['from']);
                $andConstraints[] = $query->lessThanOrEqual('flaechen_anzahl_zimmer', $filter['zimmer']['to']);
            }
            if ($filter['gebiet']) {
                switch ($filter['gebiet']) {
                    /*woba*/
                    case 910:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Altbau');
                        break;
                    case 920:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                        break;
                    case 930:    $andConstraints[] = $query->equals('geo_lage_gebiet', 'Wasserturmgebiet');
                        break;
                }
            }
            if (isset($filter['keller']) && $filter['keller']) {
                $andConstraints[] = $query->logicalOr($query->equals('ausstattung_unterkellert', 10), $query->equals('ausstattung_unterkellert', 30));
            }
            if (isset($filter['badewanne']) && $filter['badewanne']) {
                $andConstraints[] = $query->logicalOr(array($query->equals('ausstattung_bad', '20'), $query->like('ausstattung_bad', '20,%'), $query->like('ausstattung_bad', '%,20'), $query->like('ausstattung_bad', '%,20,%')));
            }
            if (isset($filter['balkon']) && $filter['balkon']) {
                $andConstraints[] = $query->logicalOr(array(
                    $query->logicalNot($query->equals('flaechen_anzahl_balkone', 0)),
                    $query->logicalNot($query->equals('flaechen_anzahl_terassen', 0)),
                    $query->logicalNot($query->equals('flaechen_anzahl_logia', 0))
                ));
            }
            if (isset($filter['haustiere']) && $filter['haustiere']) {
                $andConstraints[] = $query->equals('haustiere', 1);
            }
            if (isset($filter['aufzug']) && $filter['aufzug']) {
                $andConstraints[] = $query->logicalNot($query->equals('ausstattung_fahrstuhl', ''));
            }
            if (isset($filter['parkplatz']) && $filter['parkplatz']) {
                $andConstraints[] = $query->logicalOr(array(
                    $query->logicalNot($query->equals('preise_stp_freiplatz_anzahl', 0)),
                    $query->logicalNot($query->equals('preise_stp_sonstige_anzahl', 0)),
                    $query->logicalNot($query->equals('preise_stp_sonstige_platzart', ''))
                ));
            }
            $andConstraints = $this->getAdditionalImmobilienFilter($filter, $query, $andConstraints);
            /*
                        if ($filter['mietenKaufen']) {
                            switch ($filter['mietenKaufen']) {
                                case 's1010':    //miete
                                    $andConstraints[] = $query->in('vermarktungs_art', array(20, 30, 40));
                                    //echo "mieten";die;
                                    break;
                                case 's1020':    //kaufen
                                    //echo 'kaufen';die;
                                    //$andConstraints[] = $query->in('vermarktungs_art', array(10));
                                    $andConstraints[] = $query->equals('vermarktungs_art', 10);
                                    //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                                    break;
                            }
                        }
                        if ($filter['objektTyp']) {
                            switch ($filter['objektTyp']) {
                                case 's1000':    //Wohnung // nicht genutzt ?!!
                                    $andConstraints[] = $query->logicalNot($query->equals('objekt_art_zimmer_typ', 0));
                                    //$query->logicalNot
                                    break;
                                case 's1010':    //Wohnung
                                    $andConstraints[] = $query->logicalNot($query->equals('objekt_art_wohnung_typ', 0));
                                    //$query->logicalNot
                                    break;
                                case 's1020':    //Haus
                                    $andConstraints[] = $query->logicalNot($query->equals('objekt_art_haus_typ', 0));
                                    //$query->logicalNot
                                    break;
                                case 's1030':    //Grundstück
                                    $andConstraints[] = $query->logicalNot($query->equals('objekt_art_grundstueck_typ', 0));
                                    //$query->logicalNot
                                    //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                                    break;
                                case 's1040':    //Gewerbe/Büro
                                    //$andConstraints[] = $query->logicalNot($query->equals('objekt_art_buero_praxen_typ', 0));//$query->logicalNot
                                    $andConstraints[] = $query->logicalOr(array(
                                        $query->logicalNot($query->equals('objekt_art_buero_praxen_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_einzelhandel_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_gastgewerbe_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_hallen_lager_produktion_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_land_forstwirtschaft_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_sonstige_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_freizeitimmobilie_gewerblich_typ', 0)),
                                        $query->logicalNot($query->equals('objekt_art_zinshaus_renditeobjekt_typ', 0))
                                    ));
                                    //and ()
                                    //objekt_art_einzelhandel_typ  objekt_art_gastgewerbe_typ objekt_art_hallen_lager_produktion_typ objekt_art_land_forstwirtschaft_typ objekt_art_sonstige_typ objekt_art_freizeitimmobilie_gewerblich_typ objekt_art_zinshaus_renditeobjekt_typ
                                    //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Altbau');
                                    break;
                                case 's1050':    //Garage/Stellplatz
                                    $andConstraints[] = $query->logicalNot($query->equals('objekt_art_parken_typ', 0));
                                    //$query->logicalNot
                                    //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                                    break;
                            }
                        }
            */

            if (count($andConstraints)) {
                $query->matching($query->logicalAnd($andConstraints));
            }
        }
        $post = $query->execute();
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        /*	
        	$GLOBALS['TYPO3_DB']->explainOutput = true;
           		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;
        //$post = $query->execute();		
        	//$post->toArray();
          		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);
        	$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = false;
        	$GLOBALS['TYPO3_DB']->explainOutput = false;
        	
                \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        */

        return $post;
    }

    public function getFlaechenAnzahlZimmerFrom()
    {
        $this->defaultOrderings = array('flaechen_anzahl_zimmer' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        if ($post = $query->execute()->getFirst()) {
            return $post->getFlaechenAnzahlZimmer();
        } else {
            return false;
        }
    }

    public function getFlaechenAnzahlZimmerTo()
    {
        $this->defaultOrderings = array('flaechen_anzahl_zimmer' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        $query = $this->createQuery();
        if ($post = $query->execute()->getFirst()) {
            return $post->getFlaechenAnzahlZimmer();
        } else {
            return false;
        }
    }

    /**
     * @param $filter
     * @param $query
     * @param $andConstraints
     */
    private function getAdditionalImmobilienFilter($filter, $query, $andConstraints)
    {
        if ($filter['preisRange']) {
            //echo "haaaa!!!";
            switch ($filter['preisRange']) {
                case 10:    //bis 200
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 200);
                    break;
                case 20:    //bis 350
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 350);
                    break;
                case 30:    //bis 500
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 500);
                    break;
                case 40:    //bis 650
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 650);
                    break;
                case 50:    //bis 950
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 950);
                    break;
                case 60:    //bis 1500
                    $andConstraints[] = $query->lessThanOrEqual('preise_kaltmiete', 1500);
                    break;
            }
        }
        if ($filter['flaecheRange']) {
            switch ($filter['flaecheRange']) {
                case 10:    //ab 25
                    $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', 25);
                    break;
                case 20:    //ab 50
                    $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', 50);
                    break;
                case 30:    //ab 65
                    $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', 65);
                    break;
                case 40:    //ab 80
                    $andConstraints[] = $query->greaterThanOrEqual('search_flaeche', 80);
                    break;
            }
        }
        if ($filter['zimmerRange']) {
            switch ($filter['zimmerRange']) {
                case 10:    //ab 1
                    $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', 1);
                    break;
                case 20:    //ab 2
                    $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', 2);
                    break;
                case 30:    //ab 3
                    $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', 3);
                    break;
                case 40:    //ab 4
                    $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', 4);
                    break;
                case 50:    //ab 5
                    $andConstraints[] = $query->greaterThanOrEqual('flaechen_anzahl_zimmer', 5);
                    break;
            }
        }
        /*if ($filter['geoLageGebiet']) {
                			$andConstraints[] = $query->equals('geoLageGebiet', $filter['geoLageGebiet']);
                		}*/

        if ($filter['geoLageGebietSet']) {
            $orConstraints = array();
            if (isset($filter['geoLageGebietSet'][10])) {
                if ($filter['geoLageGebietSet'][10]) {
                    $orConstraints[] = $query->equals('geo_lage_gebiet', 'Marienthal');
                }
            }
            if (isset($filter['geoLageGebietSet'][20])) {
                if ($filter['geoLageGebietSet'][20]) {
                    $orConstraints[] = $query->equals('geo_lage_gebiet', 'Neuplanitz');
                }
            }
            if (isset($filter['geoLageGebietSet'][30])) {
                if ($filter['geoLageGebietSet'][30]) {
                    $orConstraints[] = $query->equals('geo_lage_gebiet', 'Zentrum');
                }
            }
            if (count($orConstraints)) {
                $andConstraints[] = $query->logicalOr($orConstraints);
            }
        }
        if (isset($filter['geoLageGebiet'])) {
            if ($filter['geoLageGebiet']) {
                $andConstraints[] = $query->equals('geo_lage_gebiet', $filter['geoLageGebiet']);
            }
        }
        if ($filter['vermarktung']) {
            $andConstraints[] = $query->equals('search_vermarktung', $filter['vermarktung']);
        }
        if ($filter['objektTyp']) {
            $andConstraints[] = $query->equals('search_objekt_typ', $filter['objektTyp']);
        }
        if ($filter['geoEtageSet']) {
            $orConstraints = array();
            if (isset($filter['geoEtageSet'][5])) {
                //erdgeschoss // seeg
                if ($filter['geoEtageSet'][5]) {

                }
            }
            if (isset($filter['geoEtageSet'][905])) {
                //kein erdgeschoss // seeg
                if ($filter['geoEtageSet'][905]) {
                    $orConstraints[] = $query->logicalNot($query->logicalOr(array(
                        $query->equals('geo_etage', '0'),
                        $query->equals('geo_etage', '1')
                    )));
                    $orConstraints[] = $query->logicalNot($query->equals('objekt_art_wohnung_typ', 80));
                }
            }
            if (isset($filter['geoEtageSet'][10])) {
                //erdgeschoss //wewobau
                if ($filter['geoEtageSet'][10]) {
                    $orConstraints[] = $query->equals('geo_etage', '1');
                }
            }
            if (isset($filter['geoEtageSet'][20])) {
                //erstes bis 2. //wewobau
                if ($filter['geoEtageSet'][20]) {
                    $orConstraints[] = $query->equals('geo_etage', '2');
                    $orConstraints[] = $query->equals('geo_etage', '3');
                }
            }
            if (isset($filter['geoEtageSet'][30])) {
                if ($filter['geoEtageSet'][30]) {
                    $orConstraints[] = $query->logicalNot($query->logicalOr(array(
                        $query->equals('geo_etage', ''),
                        $query->equals('geo_etage', '0'),
                        $query->equals('geo_etage', '1'),
                        $query->equals('geo_etage', '2'),
                        $query->equals('geo_etage', '3')
                    )));
                }
            }
            if (isset($filter['geoEtageSet'][100])) {
                if ($filter['geoEtageSet'][100]) {
                    $orConstraints[] = $query->equals('objekt_art_wohnung_typ', 20);
                }
            }
            if (count($orConstraints)) {
                $andConstraints[] = $query->logicalOr($orConstraints);
            }
        }
        if ($filter['ausstattungSet']) {
            if (isset($filter['ausstattungSet'][10])) {
                //Balkon Logia
                if ($filter['ausstattungSet'][10]) {
                    $andConstraints[] = $query->logicalOr(array(
                        $query->greaterThan('flaechen_anzahl_logia', 0),
                        $query->greaterThan('flaechen_anzahl_balkone', 0),
                        $query->greaterThan('flaechen_anzahl_terassen', 0)
                    ));
                }
            }
            if (isset($filter['ausstattungSet'][20])) {
                //Aufzug
                if ($filter['ausstattungSet'][20]) {
                    $andConstraints[] = $query->logicalNot($query->equals('ausstattung_fahrstuhl', ''));
                }
            }
            if (isset($filter['ausstattungSet'][30])) {
                //Bad mit Dusche
                if ($filter['ausstattungSet'][30]) {
                    $andConstraints[] = $query->logicalOr(array(
                        $query->equals('ausstattung_bad', '10'),
                        $query->like('ausstattung_bad', '10,%'),
                        $query->like('ausstattung_bad', '%,10'),
                        $query->like('ausstattung_bad', '%,10,%')
                    ));
                }
            }
            if (isset($filter['ausstattungSet'][40])) {
                //Einbauküche
                if ($filter['ausstattungSet'][40]) {
                    $andConstraints[] = $query->logicalOr(array(
                        $query->equals('ausstattung_kueche', '10'),
                        $query->like('ausstattung_kueche', '10,%'),
                        $query->like('ausstattung_kueche', '%,10'),
                        $query->like('ausstattung_kueche', '%,10,%')
                    ));
                }
            }
        }
        if ($filter['objektTypSet']) {
            if (isset($filter['objektTypSet'][10])) {
                //barierearm / senioren
                if ($filter['objektTypSet'][10]) {
                    $andConstraints[] = $query->equals('ausstattung_seniorengerecht', '1');
                }
            }
            if (isset($filter['objektTypSet'][20])) {
                //voll moebliert
                if ($filter['objektTypSet'][20]) {
                    $andConstraints[] = $query->equals('ausstattung_moebliert', '10');
                }
            }
            if (isset($filter['objektTypSet'][920])) {
                //unmoebliert
                if ($filter['objektTypSet'][920]) {
                    $andConstraints[] = $query->logicalNot($query->equals('ausstattung_moebliert', '10'));
                }
            }
            $orConstraintsWohnungTyp = array();
            if (isset($filter['objektTypSet'][30])) {
                //Maisonette
                if ($filter['objektTypSet'][30]) {
                    $orConstraintsWohnungTyp[] = $query->equals('objekt_art_wohnung_typ', '30');
                }
            }
            if (isset($filter['objektTypSet'][40])) {
                //Penthaus
                if ($filter['objektTypSet'][40]) {
                    $orConstraintsWohnungTyp[] = $query->equals('objekt_art_wohnung_typ', '50');
                }
            }
            if (count($orConstraintsWohnungTyp)) {
                $andConstraints[] = $query->logicalOr($orConstraintsWohnungTyp);
            }
        }
        return $andConstraints;
    }

    /*neu*/
    /**
     * @param $filter
     */
    public function getSearchPreisTo($filter = array())
    {
        $this->defaultOrderings = array('search_preis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        $query = $this->createQuery();
        //$query->matching($query->logicalAnd($query->greaterThan('preise_kaltmiete', 0)));
        $andConstraints = array($query->greaterThan('search_preis', 0));
        $andConstraints = $this->getAdditionalImmobilienFilter($filter, $query, $andConstraints);
        $query->matching($query->logicalAnd($andConstraints));
        if ($post = $query->execute()->getFirst()) {
            return ceil($post->getSearchPreis());
        } else {
            return false;
        }
    }

    /**
     * @param $filter
     */
    public function getSearchPreisFrom($filter = array())
    {
        $this->defaultOrderings = array('search_preis' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        $andConstraints = array($query->greaterThan('search_preis', 0));
        $andConstraints = $this->getAdditionalImmobilienFilter($filter, $query, $andConstraints);
        $query->matching($query->logicalAnd($andConstraints));
        //$query->matching($query->logicalAnd());
        if ($post = $query->execute()->getFirst()) {
            return floor($post->getSearchPreis());
        } else {
            return false;
        }
    }

    /**
     * @param $filter
     */
    public function getSearchFlaecheTo($filter = array())
    {
        $this->defaultOrderings = array('search_flaeche' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
        $query = $this->createQuery();
        //$query->matching($query->logicalAnd($query->greaterThan('preise_kaltmiete', 0)));
        $andConstraints = array($query->greaterThan('search_flaeche', 0));
        $andConstraints = $this->getAdditionalImmobilienFilter($filter, $query, $andConstraints);
        $query->matching($query->logicalAnd($andConstraints));
        if ($post = $query->execute()->getFirst()) {
            return ceil($post->getSearchFlaeche());
        } else {
            return false;
        }
    }

    /**
     * @param $filter
     */
    public function getSearchFlaecheFrom($filter = array())
    {
        $this->defaultOrderings = array('search_flaeche' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        $query = $this->createQuery();
        $andConstraints = array($query->greaterThan('search_flaeche', 0));
        $andConstraints = $this->getAdditionalImmobilienFilter($filter, $query, $andConstraints);
        $query->matching($query->logicalAnd($andConstraints));
        //$query->matching($query->logicalAnd());
        if ($post = $query->execute()->getFirst()) {
            return floor($post->getSearchFlaeche());
        } else {
            return false;
        }
    }

    /**
     * @param $filter
     */
    public function getGeoLageGebietSet()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_pxcdownloads_domain_model_merkzettel');
        /*->addSelectLiteral(
                				$queryBuilder->expr()->sum('tx_pxcdownloads_domain_model_merkzettel.stats_downloads', 'downloads')
                			)*/

        $post = $queryBuilder->select('geo_lage_gebiet')->from('tx_dslimmo_domain_model_immobilie')->groupBy('tx_dslimmo_domain_model_immobilie.geo_lage_gebiet')->orderBy('geo_lage_gebiet', 'asc')->execute()->fetchAll();
        if ($post) {
            return $post;
        } else {
            return false;
        }
    }
}
