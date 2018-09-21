<?php

/* * *************************************************************
 *  Copyright notice
*
*  (c) 2013
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
 * @package w_service
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class Tx_WService_Controller_ServicePartnerController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * servicePartnerRepository
	 *
	 * @var Tx_WService_Domain_Repository_ServicePartnerRepository
	 * @inject
	 */
	protected $servicePartnerRepository;

	/**
	 * servicePartnerRepository
	 *
	 * @var Tx_WService_Domain_Repository_CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;


	protected function d($value, $die = FALSE) {
		Tx_Extbase_Utility_Debugger::var_dump($value, null, 16);
		if ($die) {
			die;
		}
	}


	public function mapAction() {

		$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdOy5LXKJovNABiA5EQ5Nq-Ywv-JfsduE" type="text/javascript"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/spin.min.js'.'"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/geoPosition.js'.'"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/wservice_map.js'.'"></script>');

        /*
         * We don't show entries any entries on first page load. Loading partner data here is currently not needed.
        */
        /*$source_folders = explode(',',$this->settings['source_folders']);
         $partners = $this->servicePartnerRepository->findForMap($source_folders)->toArray();
         $this->view->assign('partners', $partners);*/
        $this->view->assign('categorys', $this->categoryRepository->findAll());


	}

	public function internationalMapAction() {

		$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdOy5LXKJovNABiA5EQ5Nq-Ywv-JfsduE" type="text/javascript"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/spin.min.js'.'"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/geoPosition.js'.'"></script>');
//		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('w_service'). 'Resources/Public/Js/wservice_map.js'.'"></script>');

		$source_folders = explode(',',$this->settings['source_folders']);
		$partners = $this->servicePartnerRepository->findDealersForMap($source_folders)->toArray();
        $dealersCountries = $this->servicePartnerRepository->findDealersCountriesFor($source_folders);
        $this->view->assign('distunct', $dealersCountries);
        $this->view->assign('partners', $partners);

	}

	/**
	 * Find the locations near the given geolocation
	 * returns XML
	 */
	public function searchAction() {
		$lat = ($this->request->hasArgument("lat")) ? $this->request->getArgument("lat") : 10;
		$lon = ($this->request->hasArgument("lon")) ? $this->request->getArgument("lon") : 0;
		$radius = ($this->request->hasArgument("radius")) ? $this->request->getArgument("radius") : 400;

		return json_encode(
			array(
				"locations" => $this->servicePartnerRepository->findZipNearby($lat, $lon, $radius),
				"lat" => $lat,
				"lon" => $lon,
				"radius" => $radius
			)
		);

	}


	public function test($pos){
		$fails = array();
		foreach($pos as $partnerOption){
			$a = $partnerOption->getLat();
			if(empty($a)){
				$fails[] = $partnerOption;
			}
		}
		$this->d($fails);
	}

	public function setGeodata($servicePartners){
		foreach ($servicePartners as $servicePartner) {
			if(!$servicePartner->getLat()){
				$latLng = $this->getGeoCode($servicePartner);
				if(!$latLng == false){
					$servicePartner->setLat($latLng['lat']);
					$servicePartner->setLng($latLng['lng']);
					$this->servicePartnerRepository->update($servicePartner);
				}
			}
		}
	}

	/**
	 * Get the Geocode as array or false if not
	 * @param $servicePartner
	 * @return mixed
	 */
	public function getGeoCode($servicePartner) {
		$street = $servicePartner->getStreet();
		$zip = $servicePartner->getZip();
		$city = $servicePartner->getCity();

		$address = urlencode($street . ',' . $zip . ',' . $city) . '&sensor=false';
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address;

		$response = file_get_contents($url);

		if ($response != false) {
			$response = json_decode($response, true);
			switch ($response['status']) {
				case 'OK':
					return $this->processResponse($response);
					break;
				case 'REQUEST_DENIED':
					return false;
					break;
				case 'ZERO_RESULTS':
					return false;
					break;
				default :
					return false;
					break;
			}
		} else {
			return false;
		}
	}

	/**
	 * Process the response, or false if no latLng available
	 *
	 * @param $response
	 *
	 * @return mixed
	 */
	public function processResponse($response) {
		$latLng = (isset($response['results'][0]['geometry']['location'])) ? $response['results'][0]['geometry']['location'] : false;
		return $latLng;
	}

}