<?php

namespace Pingag\PingagThurcom\Controller;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 16:47
 */
abstract class BaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\ChannelRepository
     * @inject
     */
    protected $channelRepo;
	
	/**
     * @var \Pingag\PingagThurcom\Domain\Repository\ChannelPackageRepository
     * @inject
     */
    protected $channelPackageRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\ServiceRepository
     * @inject
     */
    protected $serviceRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\InternetPackageRepository
     * @inject
     */
    protected $internetPackageRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\SubscriptionOptionRepository
     * @inject
     */
    protected $subscriptionOptionRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\ProductRepository
     * @inject
     */
    protected $productRepo;
	
	/**
     * @var \Pingag\PingagThurcom\Domain\Repository\ProductConsultationRepository
     * @inject
     */
    protected $productConsultationRepo;

    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\SubscriptionOrderRepository
     * @inject
     */
    protected $subscriptionOrderRepo;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    protected function getFlexformSetting($key)
    {
        $data = $this->configurationManager->getContentObject()->data;
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $data);
        if (isset($data[$key])) {
            return $data[$key];
        }
        return false;
    }

    protected function hasArgument($key)
    {
        return isset($_REQUEST[$key]);
    }

    protected function getArgument($key)
    {
        if($this->hasArgument($key)){
            return $_REQUEST[$key];
        }

        return false;
    }

    public function isPostRequest(){
        return $this->request->getMethod() === 'GET';
    }

    protected function currentUrl()
    {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}