<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:14
 */

namespace Pingag\PingagThurcom\Controller;


class ServiceLocationController extends BaseController
{
	/**
     * @var \Pingag\PingagThurcom\Domain\Repository\CityRepository
     * @inject
     */
    protected $cityRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\ServiceLocationRepository
     * @inject
     */
    protected $serviceLocationRepo;
    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\SimpleServiceLocationRepository
     * @inject
     */
    protected $simpleLocationRepo;

    const SEARCH_FIELD_NAME = 'service_location_search_term';

    public function listAction()
    {
        $locations = $this->serviceLocationRepo->findAll();
        $this->view->assign('locations', $locations);

        return $this->view->render();
    }
	
	public function listServiceAction()
    {
        $locations = $this->serviceLocationRepo->findAll();
        $this->view->assign('locations', $locations);
		
		$serviceLocations = $this->simpleLocationRepo->findAll();
		$this->view->assign('serviceLocations', $serviceLocations);

        return $this->view->render();
    }

    public function searchAction()
    {
        $location = null;
        if($this->hasArgument(self::SEARCH_FIELD_NAME)){
            $searchTerm = $this->getArgument(self::SEARCH_FIELD_NAME);
            //$location = $this->serviceLocationRepo->findBySearchTerm($searchTerm);
            $cityArray = $this->cityRepo->findBySearchTerm($searchTerm, 30);
            $this->view->assign('searchTerm', $searchTerm);

            if(count($cityArray) == 1){
                $city = $cityArray[0];
                if(!$city->getNetzbetreiber()){
                    $city = false;
                }
            }
			//$city = $this->cityRepo->findBySearchTerm($searchTerm);

			if($city){
                $services = $this->serviceRepo->findAll();
                $city->mergeServiceOptions($services);
				$netzbetreiber = $this->serviceLocationRepo->findByUid($city->getNetzbetreiber());
				$service_stellen = $city->getServicestellen();
				$lokalstellen = explode(',', $service_stellen);

				$servicestellen = $this->simpleLocationRepo->findByUids($lokalstellen);
            }
            /*if($location){
                $services = $this->serviceRepo->findAll();
                $location->mergeServiceOptions($services);
            }*/

            $serviceLocations = $this->simpleLocationRepo->findBySearchTerm($searchTerm);
        }
        
        $this->view->assign('cityArray', $cityArray);
        $this->view->assign('city', $city);
        $this->view->assign('location', $netzbetreiber);
        $this->view->assign('serviceLocations', $servicestellen);

        $this->view->assign('showServiceOptions', $this->getFlexformSetting('showServiceOptions'));

        $this->view->assign('current_url', $this->currentUrl());
        $this->view->assign('search_field_name', self::SEARCH_FIELD_NAME);

        return $this->view->render();
    }

    public function searchAdvancedAction()
    {
        return $this->searchAction();
    }
	
	public function searchAdvancedAboAction()
    {
        return $this->searchAction();
    }
	
	public function searchServiceAction()
    {
        $serviceLocation = null;
        if($this->hasArgument(self::SEARCH_FIELD_NAME)){
            $searchTerm = $this->getArgument(self::SEARCH_FIELD_NAME);
            $this->view->assign('searchTerm', $searchTerm);
			$city = $this->cityRepo->findBySearchTerm($searchTerm);
            //$serviceLocation = $this->simpleLocationRepo->findBySearchTerm($searchTerm);
        }
		if($city){
                $services = $this->serviceRepo->findAll();
                $city->mergeServiceOptions($services);
				$service_stellen = $city->getServicestellen();
				$lokalstellen = explode(',', $service_stellen);

				$servicestellen = $this->simpleLocationRepo->findByUids($lokalstellen);
        }
        
        $this->view->assign('city', $city);

        $this->view->assign('serviceLocations', $servicestellen);

        $this->view->assign('showServiceOptions', $this->getFlexformSetting('showServiceOptions'));

        $this->view->assign('current_url', $this->currentUrl());
        $this->view->assign('search_field_name', self::SEARCH_FIELD_NAME);

        return $this->view->render();
    }
}