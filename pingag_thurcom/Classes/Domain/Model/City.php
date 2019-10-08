<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 09:14
 */
class City extends BaseEntity
{

    /** @var string */
    protected $title;
    /** @var string */
    protected $zip;
    /** @var string */
    protected $additionalZips;

    /** @var string */
    protected $extraText;
    /** @var string */
    protected $extraUrl;
	
	/** @var string */
    protected $netzbetreiber;
	/** @var string */
    protected $servicestellen;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagThurcom\Domain\Model\ServiceOption>
     */
    protected $serviceOptions;
	

    /**
     * ServiceLocation constructor.
     */
    public function __construct()
    {
        $this->contactPerson = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagThurcom\Domain\Model\Service> $services
     */
    public function mergeServiceOptions($services)
    {
        $setServices = [];
        foreach ($this->getServiceOptions() as $serviceOption) {
            $setServices[] = $serviceOption->getService();
        }

        foreach ($services as $service){
            if(!in_array($service, $setServices)){
                $newServiceOption = new ServiceOption();
                $newServiceOption->setService($service);
                $newServiceOption->setState(ServiceOption::DEFAULT_STATE);

                $this->getServiceOptions()->attach($newServiceOption);
            }
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalZips()
    {
        return $this->additionalZips;
    }

    /**
     * @param string $additionalZips
     * @return $this
     */
    public function setAdditionalZips($additionalZips)
    {
        $this->additionalZips = $additionalZips;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtraText()
    {
        return $this->extraText;
    }

    /**
     * @param string $extraText
     * @return $this
     */
    public function setExtraText($extraText)
    {
        $this->extraText = $extraText;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtraUrl()
    {
        return $this->extraUrl;
    }

    /**
     * @param string $extraUrl
     * @return $this
     */
    public function setExtraUrl($extraUrl)
    {
        $this->extraUrl = $extraUrl;
        return $this;
    }


    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getServiceOptions()
    {
        return $this->serviceOptions;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $serviceOptions
     * @return $this
     */
    public function setServiceOptions($serviceOptions)
    {
        $this->serviceOptions = $serviceOptions;
        return $this;
    }

    /**
     * @return string
     */
    public function getNetzbetreiber()
    {
        return $this->netzbetreiber;
    }

    /**
     * @param string $netzbetreiber
     * @return $this
     */
    public function setNetzbetreiber($netzbetreiber)
    {
        $this->netzbetreiber = $netzbetreiber;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getServicestellen()
    {
        return $this->servicestellen;
    }

    /**
     * @param string $netzbetreiber
     * @return $this
     */
    public function setServicestellen($servicestellen)
    {
        $this->servicestellen = $servicestellen;
        return $this;
    }
}