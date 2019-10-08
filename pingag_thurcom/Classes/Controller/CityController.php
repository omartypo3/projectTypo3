<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:14
 */

namespace Pingag\PingagThurcom\Controller;


class CityController extends BaseController
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

    const SEARCH_FIELD_NAME = 'city_search_term';

    public function listAction()
    {
        $city = $this->cityRepo->findAll();
        $this->view->assign('city', $city);

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
        $city = null;
        if($this->hasArgument(self::SEARCH_FIELD_NAME)){
            $searchTerm = $this->getArgument(self::SEARCH_FIELD_NAME);
            $cityArray = $this->cityRepo->findBySearchTerm($searchTerm, 30);
            $this->view->assign('searchTerm', $searchTerm);

            if($_SERVER['REMOTE_ADDR'] == '85.195.252.43'){
                //var_dump($this->getArgument('hide_city_list')); die;
            }
            
            if(count($cityArray) == 1 || $this->getArgument('hide_city_list') == 1){
                $city = $cityArray[0];
                if(!$city->getNetzbetreiber()){
                    $city = false;
                }
            }
            if($city){
                $services = $this->serviceRepo->findAll();
                $city->mergeServiceOptions($services);
				$netzbetreiber = $this->serviceLocationRepo->findByUid($city->getNetzbetreiber());
				$service_stellen = $city->getServicestellen();
				$lokalstellen = explode(',', $service_stellen);
                $servicestellen = $this->simpleLocationRepo->findByUids($lokalstellen);
            }
        }

        $this->view->assign('cityArray', $cityArray);
        $this->view->assign('city', $city);
		$this->view->assign('netzbetreiber', $netzbetreiber);
        $this->view->assign('servicestellen', $servicestellen);

        $this->view->assign('showServiceOptions', $this->getFlexformSetting('showServiceOptions'));

        $this->view->assign('current_url', $this->currentUrl());
        $this->view->assign('search_field_name', self::SEARCH_FIELD_NAME);

        return $this->view->render();
    }

    public function searchAdvancedAction()
    {
        return $this->searchAction();
    }
	
	public function searchAboAction()
    {
        return $this->searchAction();
    }
	
}