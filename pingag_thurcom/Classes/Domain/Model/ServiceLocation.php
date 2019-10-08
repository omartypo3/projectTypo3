<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 09:14
 */
class ServiceLocation extends BaseEntity
{

    /** @var string */
    protected $title;
    /** @var string */
    protected $address;
    /** @var string */
    protected $zip;
    /** @var string */
    protected $city;
    /** @var string */
    protected $extraCity;
    /** @var string */
    protected $telephone;
    /** @var string */
    protected $email;
    /** @var string */
    protected $website;
    /** @var string */
    protected $description;

    /** @var string */
    protected $extraText;
    /** @var string */
    protected $extraUrl;

    /** @var float */
    protected $lat;
    /** @var float */
    protected $lng;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\FileReference>
     * @lazy
     */
    protected $logo;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagThurcom\Domain\Model\ContactPerson>
     * @lazy
     */
    protected $contactPerson;

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
        $this->serviceOptions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtraCity()
    {
        return $this->extraCity;
    }

    /**
     * @param string $extraCity
     * @return $this
     */
    public function setExtraCity($extraCity)
    {
        $this->extraCity = $extraCity;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return $this
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     * @return $this
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
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
     * @return mixed
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param mixed $contactPerson
     * @return $this
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }
}