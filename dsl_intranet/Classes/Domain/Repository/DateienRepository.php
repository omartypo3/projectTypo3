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
 * The repository for Dateiens
 */
class DateienRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $orderMapArr = array(
        '0asc' => array(
            'temp_kunden_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'temp_kunden_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'temp_type' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'temp_type' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'temp_datei_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'temp_datei_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
            'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '4asc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '4desc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '5asc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '5desc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '6asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '6desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '7asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '7desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    protected $orderMapKundeArr = array(
        '0asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
            'type' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'type' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '4asc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '4desc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '5asc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '5desc' => array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );
	
	
    /**
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     * @param integer $kunde
     */
    public function findByFilter($settings, $offset = false, $limit = false, $order = array(), $search = false, $kunde = false)
    {
        if ($limit === -1) {
            $limit = false;
        }
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
            foreach ($this->defaultOrderings as $k => $v) {
                if (!isset($manuallyOrderings[$k])) {
                    $manuallyOrderings[$k] = $v;
                }
            }
            $this->defaultOrderings = $manuallyOrderings;
        }
        $query = $this->createQuery();
        $andConstraints = array();
		$id = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($kunde) {
            //$andConstraints[] = $query->equals('kunde', $GLOBALS['TSFE']->fe_user->user['uid']);
            $andConstraints[] = $query->equals('kunden', $GLOBALS['TSFE']->fe_user->user['uid']);
            $andConstraints[] = $query->equals('sichtbarkeit', 1);
        } else {
        }

        if (!is_array($settings)){
            $settings = json_decode($settings, true);
        }
		        
        //die();
		//$settings = json_decode($settings);

        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                $orConstraints = array();
                switch ($key) {
                    case 'kundens':    foreach ($value as $wert) {
                            $orConstraints[] = $query->equals('kunden', $wert);
                        }
                        break;
                    case 'typens':
						
                        foreach ($value as $wert) {
                            $orConstraints[] = $query->equals('type', $wert);
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
        $searchOrConstraints = array();
        if ($search !== false) {
            //echo "search";die;
            //Auftragsnummer
            $searchOrConstraints[] = $query->logicalOr(array($query->equals('uid', intval($search)), $query->like('uid', '%' . $search . '%')));
            //$query->logicalOr($searchOrConstraints)
            //im Auftragstitel
            $searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_datei_name', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_type', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_kunden_name', '%' . $search . '%');
            $searchOrConstraints[] = $query->equals('temp_kunden_nummer', $search);
        }
        if (count($searchOrConstraints)) {
            $andConstraints[] = $query->logicalOr($searchOrConstraints);
        }
        $andConstraints[] = $query->logicalOr(array($query->equals('auftraege', 0), $query->equals('type', 30)));
        $andConstraints[] = $query->logicalNot($query->equals('type', 10));
		$andConstraints[] = $query->equals('iduser', $id->getUid());
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
        // 		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        //		die;
        return $posts;
    }

    public function findForRefresh()
    {
        $query = $this->createQuery();
		
    // Define the raw SQL query
		$sql = 'SELECT tx_dslintranet_domain_model_dateien.uid 
            FROM tx_dslintranet_domain_model_dateien 
            LEFT JOIN fe_users 
            ON fe_users.uid = tx_dslintranet_domain_model_dateien.kunden 
            WHERE tx_dslintranet_domain_model_dateien.kunden 
            AND (fe_users.tstamp > tx_dslintranet_domain_model_dateien.tstamp 
                 OR tx_dslintranet_domain_model_dateien.temp_timestamp = 0)';

        //2183
        //$andConstraints[] = $query->equals('kunden', 2183);
        //$andConstraints[] = $query->equals('kunden.nummer', '3000');
        //$results = $query->statement("SELECT * FROM tx_dslintranet_domain_model_dateien WHERE kunden = '2183'");
		 
    // die();
		$query->statement($sql);   
		

		
		return $query->execute();	
    }
}
