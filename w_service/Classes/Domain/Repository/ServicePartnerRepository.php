<?php

/* * *************************************************************
 *  Copyright notice
*
*  (c) 2012
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
* ************************************************************* */

/**
 *
 *
 * @package b4
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class Tx_WService_Domain_Repository_ServicePartnerRepository extends Tx_Extbase_Persistence_Repository {

	protected $defaultOrderings = array("sorting" => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING);

	public function findAll() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query->execute();
	}
    public function findAllDealers() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement(
            "SELECT * FROM tx_wservice_domain_model_servicepartner  WHERE category = 3"
        );
        return $query->execute();
    }
    public function findAllDealersCountries() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement(
            "SELECT DISTINCT additional
                    FROM tx_wservice_domain_model_servicepartner  
                    WHERE category = 3
                    AND hidden = 0 AND deleted = 0
            "
        );
        return $query->execute();
    }
    public function findDealersCountriesFor($pid = null) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);

        if($pid){
            $query->statement(
                'SELECT DISTINCT additional
                    FROM tx_wservice_domain_model_servicepartner  
                    WHERE additional <> ""
                    AND pid IN ( ' . implode(',', $pid) . ' )
                    AND category = 3
                    AND hidden = 0 AND deleted = 0
            ');
        }else{
            $query->statement(
                'SELECT DISTINCT additional
                    FROM tx_wservice_domain_model_servicepartner  
                    WHERE additional <> ""
                    AND category = 3
                    AND hidden = 0 AND deleted = 0
            ');
        }

        return $query->execute();
    }

    public function findForMap($pid = null) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        $constraints = array();
        $constraints[] = $query->logicalNot( $query->equals('lat', '') );

        if (is_array($pid)) {
            $constraints[] = $query->in('pid', $pid);
        }

        $query->matching(
            $query->logicalAnd($constraints)
        );

        // temporary limit reduce the load of the google map
        //$query->setLimit(1000);
        return $query->execute();
    }

    public function findDealersForMap($pid = null) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        $constraints = array();
        $constraints[] = $query->logicalNot( $query->equals('lat', '') );

        if (is_array($pid)) {
            $constraints[] = $query->in('pid', $pid);
        }

        $constraints[] = $query->equals('category', '3');

        $query->matching(
            $query->logicalAnd($constraints)
        );

        // temporary limit reduce the load of the google map
        //$query->setLimit(1000);
        return $query->execute();
    }

	/**
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findToConvert($limit = 100) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching(
			$query->equals('lat', '')
		);
        $query->setLimit($limit);
		return $query->execute();
	}

	/**
	 * @param float $lat
	 * @param float $lon
	 * @param integer $radius
	 *
	 * @TODO Add "WHERE tx_wservice_domain_model_servicepartner.deleted=0 AND tx_wservice_domain_model_servicepartner.hidden=0" later
	 * @return array
	 */
	public function findZipNearby($lat, $lon, $radius){
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement(
            "SELECT uid, company, street, zip, city, country, lat, lng, category, phone, email, fax, website, additional, boost, hidden, deleted,
            (3959 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance
            FROM tx_wservice_domain_model_servicepartner HAVING distance < ? AND deleted = 0 AND hidden = 0
            ORDER BY distance;"
            , array($lat, $lon, $lat, $radius)
        );
		return $query->execute();
	}

	public function find($pids) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->matching($query->equals('pid', $pids));

		return $query->execute();
	}

}

?>