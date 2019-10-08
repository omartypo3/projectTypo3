<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 17.07.2018
 * Time: 15:52
 */

namespace Pingag\PingagRealEstate\Domain\Model;

use Pingag\PingagRealEstate\Domain\Model\Interfaces\RealEstateIDX;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class AbstractRealEstate extends AbstractEntity implements RealEstateIDX
{
    /** @var string */
    protected $version;
    /** @var string */
    protected $senderId;
    /** @var string */
    protected $lastModified;
    /** @var string */
    protected $url;
	/** @var string */
    protected $sparefield2;
    /** @var string */
    protected $objectCategory;
    /** @var string */
    protected $objectType;
    /** @var string */
    protected $offerType;
    /** @var string */
    protected $refProperty;
    /** @var string */
    protected $refHouse;
    /** @var string */
    protected $refObject;
    /** @var string */
    protected $objectStreet;
    /** @var string */
    protected $objectZip;
    /** @var string */
    protected $objectCity;
    /** @var string */
    protected $objectX;
    /** @var string */
    protected $objectY;
    /** @var string */
    protected $objectState;
    /** @var string */
    protected $objectCountry;
    /** @var string */
    protected $region;
    /** @var string */
    protected $objectSituation;
    /** @var string */
    protected $availableFrom;

    
    /** @var string */
    protected $objectTitle;
    /** @var string */
    protected $objectDescription;
    /** @var string */
    protected $sellingPrice;
    /** @var string */
    protected $rentNet;
    /** @var string */
    protected $rentExtra;
    /** @var string */
    protected $priceUnit;
    /** @var string */
    protected $price;
    /** @var string */
    protected $currency;
    
    
    /** @var string */
    protected $floor;
    /** @var string */
    protected $numberOfRooms;
    /** @var string */
    protected $numberOfFloors;
    /** @var string */
    protected $numberOfApartments;
    /** @var string */
    protected $surfaceLiving;
    /** @var string */
    protected $surfaceUsable;
    /** @var string */
    protected $surfaceProperty;
    /** @var string */
    protected $yearBuilt;
    /** @var string */
    protected $yearRenovated;
    
    /** @var bool */
    protected $propElevator;
    /** @var bool */
    protected $propChildFriendly;
    /** @var bool */
    protected $propParking;
    /** @var bool */
    protected $propGarage;
    /** @var bool */
    protected $propBalcony;
    /** @var bool */
    protected $propView;
    /** @var bool */
    protected $propFireplace;
    /** @var bool */
    protected $propCabletv;
    /** @var bool */
    protected $isdn;
    /** @var bool */
    protected $wheelchairAccessible;
    /** @var bool */
    protected $animalAllowed;
    /** @var bool */
    protected $ramp;
    /** @var bool */
    protected $minergieGeneral;
    /** @var bool */
    protected $newBuilding;
    /** @var bool */
    protected $railwayTerminal;
    /** @var bool */
    protected $swimmingpool;
    
    /** @var string */
    protected $distancePublicTransport;
    /** @var string */
    protected $distanceShop;
    /** @var string */
    protected $distanceKindergarten;
    /** @var string */
    protected $distanceSchool1;
    /** @var string */
    protected $distanceSchool2;
    /** @var string */
    protected $distanceMotorway;
    
    
    /** @var string */
    protected $agencyId;
    /** @var string */
    protected $agencyName;
    /** @var string */
    protected $agencyName2;
    /** @var string */
    protected $agencyReference;
    /** @var string */
    protected $agencyPhone;
    /** @var string */
    protected $agencyFax;
    /** @var string */
    protected $agencyEmail;
    /** @var string */
    protected $agencyStreet;
    /** @var string */
    protected $agencyZip;
    /** @var string */
    protected $agencyCity;
    
    /** @var string */
    protected $visitName;
    /** @var string */
    protected $visitPhone;
    /** @var string */
    protected $visitEmail;
    
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     * @cascade remove
     */
    protected $pictures;
    
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     * @cascade remove
     */
    protected $documents;

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param string $senderId
     * @return $this
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param string $lastModified
     * @return $this
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getSparefield2()
    {
        return $this->sparefield2;
    }

    /**
     * @param string $sparefield2
     * @return $this
     */
    public function setSparefield2($sparefield2)
    {
        $this->sparefield2 = $sparefield2;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getObjectCategory()
    {
        return $this->objectCategory;
    }

    /**
     * @param string $objectCategory
     * @return $this
     */
    public function setObjectCategory($objectCategory)
    {
        $this->objectCategory = $objectCategory;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * @param string $objectType
     * @return $this
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
        return $this;
    }

    /**
     * @return string
     */
    public function getOfferType()
    {
        return $this->offerType;
    }

    /**
     * @param string $offerType
     * @return $this
     */
    public function setOfferType($offerType)
    {
        $this->offerType = $offerType;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefProperty()
    {
        return $this->refProperty;
    }

    /**
     * @param string $refProperty
     * @return $this
     */
    public function setRefProperty($refProperty)
    {
        $this->refProperty = $refProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefHouse()
    {
        return $this->refHouse;
    }

    /**
     * @param string $refHouse
     * @return $this
     */
    public function setRefHouse($refHouse)
    {
        $this->refHouse = $refHouse;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefObject()
    {
        return $this->refObject;
    }

    /**
     * @param string $refObject
     * @return $this
     */
    public function setRefObject($refObject)
    {
        $this->refObject = $refObject;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectStreet()
    {
        return $this->objectStreet;
    }

    /**
     * @param string $objectStreet
     * @return $this
     */
    public function setObjectStreet($objectStreet)
    {
        $this->objectStreet = $objectStreet;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectZip()
    {
        return $this->objectZip;
    }

    /**
     * @param string $objectZip
     * @return $this
     */
    public function setObjectZip($objectZip)
    {
        $this->objectZip = $objectZip;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectCity()
    {
        return $this->objectCity;
    }

    /**
     * @param string $objectCity
     * @return $this
     */
    public function setObjectCity($objectCity)
    {
        $this->objectCity = $objectCity;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectX()
    {
        return $this->objectX;
    }

    /**
     * @param string $objectX
     * @return $this
     */
    public function setObjectX($objectX)
    {
        $this->objectX = $objectX;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectY()
    {
        return $this->objectY;
    }

    /**
     * @param string $objectY
     * @return $this
     */
    public function setObjectY($objectY)
    {
        $this->objectX = $objectY;
        return $this;
    }


    /**
     * @return string
     */
    public function getObjectState()
    {
        return $this->objectState;
    }

    /**
     * @param string $objectState
     * @return $this
     */
    public function setObjectState($objectState)
    {
        $this->objectState = $objectState;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectCountry()
    {
        return $this->objectCountry;
    }

    /**
     * @param string $objectCountry
     * @return $this
     */
    public function setObjectCountry($objectCountry)
    {
        $this->objectCountry = $objectCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectSituation()
    {
        return $this->objectSituation;
    }

    /**
     * @param string $objectSituation
     * @return $this
     */
    public function setObjectSituation($objectSituation)
    {
        $this->objectSituation = $objectSituation;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param string $availableFrom
     * @return $this
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectTitle()
    {
        return $this->objectTitle;
    }

    /**
     * @param string $objectTitle
     * @return $this
     */
    public function setObjectTitle($objectTitle)
    {
        $this->objectTitle = $objectTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectDescription()
    {
        return $this->objectDescription;
    }

    /**
     * @param string $objectDescription
     * @return $this
     */
    public function setObjectDescription($objectDescription)
    {
        $this->objectDescription = $objectDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @param string $sellingPrice
     * @return $this
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getRentNet()
    {
        return $this->rentNet;
    }

    /**
     * @param string $rentNet
     * @return $this
     */
    public function setRentNet($rentNet)
    {
        $this->rentNet = $rentNet;
        return $this;
    }

    /**
     * @return string
     */
    public function getRentExtra()
    {
        return $this->rentExtra;
    }

    /**
     * @param string $rentExtra
     * @return $this
     */
    public function setRentExtra($rentExtra)
    {
        $this->rentExtra = $rentExtra;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * @param string $priceUnit
     * @return $this
     */
    public function setPriceUnit($priceUnit)
    {
        $this->priceUnit = $priceUnit;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param string $floor
     * @return $this
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumberOfRooms()
    {
        return $this->numberOfRooms;
    }

    /**
     * @param string $numberOfRooms
     * @return $this
     */
    public function setNumberOfRooms($numberOfRooms)
    {
        $this->numberOfRooms = $numberOfRooms;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumberOfFloors()
    {
        return $this->numberOfFloors;
    }

    /**
     * @param string $numberOfFloors
     * @return $this
     */
    public function setNumberOfFloors($numberOfFloors)
    {
        $this->numberOfFloors = $numberOfFloors;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumberOfApartments()
    {
        return $this->numberOfApartments;
    }

    /**
     * @param string $numberOfApartments
     * @return $this
     */
    public function setNumberOfApartments($numberOfApartments)
    {
        $this->numberOfApartments = $numberOfApartments;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceLiving()
    {
        return $this->surfaceLiving;
    }

    /**
     * @param string $surfaceLiving
     * @return $this
     */
    public function setSurfaceLiving($surfaceLiving)
    {
        $this->surfaceLiving = $surfaceLiving;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceUsable()
    {
        return $this->surfaceUsable;
    }

    /**
     * @param string $surfaceUsable
     * @return $this
     */
    public function setSurfaceUsable($surfaceUsable)
    {
        $this->surfaceUsable = $surfaceUsable;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceProperty()
    {
        return $this->surfaceProperty;
    }

    /**
     * @param string $surfaceProperty
     * @return $this
     */
    public function setSurfaceProperty($surfaceProperty)
    {
        $this->surfaceProperty = $surfaceProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getYearBuilt()
    {
        return $this->yearBuilt;
    }

    /**
     * @param string $yearBuilt
     * @return $this
     */
    public function setYearBuilt($yearBuilt)
    {
        $this->yearBuilt = $yearBuilt;
        return $this;
    }

    /**
     * @return string
     */
    public function getYearRenovated()
    {
        return $this->yearRenovated;
    }

    /**
     * @param string $yearRenovated
     * @return $this
     */
    public function setYearRenovated($yearRenovated)
    {
        $this->yearRenovated = $yearRenovated;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropElevator()
    {
        return $this->propElevator;
    }

    /**
     * @param bool $propElevator
     * @return $this
     */
    public function setPropElevator($propElevator)
    {
        $this->propElevator = $propElevator;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropChildFriendly()
    {
        return $this->propChildFriendly;
    }

    /**
     * @param bool $propChildFriendly
     * @return $this
     */
    public function setPropChildFriendly($propChildFriendly)
    {
        $this->propChildFriendly = $propChildFriendly;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropParking()
    {
        return $this->propParking;
    }

    /**
     * @param bool $propParking
     * @return $this
     */
    public function setPropParking($propParking)
    {
        $this->propParking = $propParking;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropGarage()
    {
        return $this->propGarage;
    }

    /**
     * @param bool $propGarage
     * @return $this
     */
    public function setPropGarage($propGarage)
    {
        $this->propGarage = $propGarage;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropBalcony()
    {
        return $this->propBalcony;
    }

    /**
     * @param bool $propBalcony
     * @return $this
     */
    public function setPropBalcony($propBalcony)
    {
        $this->propBalcony = $propBalcony;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropView()
    {
        return $this->propView;
    }

    /**
     * @param bool $propView
     * @return $this
     */
    public function setPropView($propView)
    {
        $this->propView = $propView;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropFireplace()
    {
        return $this->propFireplace;
    }

    /**
     * @param bool $propFireplace
     * @return $this
     */
    public function setPropFireplace($propFireplace)
    {
        $this->propFireplace = $propFireplace;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPropCabletv()
    {
        return $this->propCabletv;
    }

    /**
     * @param bool $propCabletv
     * @return $this
     */
    public function setPropCabletv($propCabletv)
    {
        $this->propCabletv = $propCabletv;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsdn()
    {
        return $this->isdn;
    }

    /**
     * @param bool $isdn
     * @return $this
     */
    public function setIsdn($isdn)
    {
        $this->isdn = $isdn;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWheelchairAccessible()
    {
        return $this->wheelchairAccessible;
    }

    /**
     * @param bool $wheelchairAccessible
     * @return $this
     */
    public function setWheelchairAccessible($wheelchairAccessible)
    {
        $this->wheelchairAccessible = $wheelchairAccessible;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAnimalAllowed()
    {
        return $this->animalAllowed;
    }

    /**
     * @param bool $animalAllowed
     * @return $this
     */
    public function setAnimalAllowed($animalAllowed)
    {
        $this->animalAllowed = $animalAllowed;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRamp()
    {
        return $this->ramp;
    }

    /**
     * @param bool $ramp
     * @return $this
     */
    public function setRamp($ramp)
    {
        $this->ramp = $ramp;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMinergieGeneral()
    {
        return $this->minergieGeneral;
    }

    /**
     * @param bool $minergieGeneral
     * @return $this
     */
    public function setMinergieGeneral($minergieGeneral)
    {
        $this->minergieGeneral = $minergieGeneral;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNewBuilding()
    {
        return $this->newBuilding;
    }

    /**
     * @param bool $newBuilding
     * @return $this
     */
    public function setNewBuilding($newBuilding)
    {
        $this->newBuilding = $newBuilding;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRailwayTerminal()
    {
        return $this->railwayTerminal;
    }

    /**
     * @param bool $railwayTerminal
     * @return $this
     */
    public function setRailwayTerminal($railwayTerminal)
    {
        $this->railwayTerminal = $railwayTerminal;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSwimmingpool()
    {
        return $this->swimmingpool;
    }

    /**
     * @param bool $swimmingpool
     * @return $this
     */
    public function setSwimmingpool($swimmingpool)
    {
        $this->swimmingpool = $swimmingpool;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistancePublicTransport()
    {
        return $this->distancePublicTransport;
    }

    /**
     * @param string $distancePublicTransport
     * @return $this
     */
    public function setDistancePublicTransport($distancePublicTransport)
    {
        $this->distancePublicTransport = $distancePublicTransport;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceShop()
    {
        return $this->distanceShop;
    }

    /**
     * @param string $distanceShop
     * @return $this
     */
    public function setDistanceShop($distanceShop)
    {
        $this->distanceShop = $distanceShop;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceKindergarten()
    {
        return $this->distanceKindergarten;
    }

    /**
     * @param string $distanceKindergarten
     * @return $this
     */
    public function setDistanceKindergarten($distanceKindergarten)
    {
        $this->distanceKindergarten = $distanceKindergarten;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceSchool1()
    {
        return $this->distanceSchool1;
    }

    /**
     * @param string $distanceSchool1
     * @return $this
     */
    public function setDistanceSchool1($distanceSchool1)
    {
        $this->distanceSchool1 = $distanceSchool1;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceSchool2()
    {
        return $this->distanceSchool2;
    }

    /**
     * @param string $distanceSchool2
     * @return $this
     */
    public function setDistanceSchool2($distanceSchool2)
    {
        $this->distanceSchool2 = $distanceSchool2;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceMotorway()
    {
        return $this->distanceMotorway;
    }

    /**
     * @param string $distanceMotorway
     * @return $this
     */
    public function setDistanceMotorway($distanceMotorway)
    {
        $this->distanceMotorway = $distanceMotorway;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyId()
    {
        return $this->agencyId;
    }

    /**
     * @param string $agencyId
     * @return $this
     */
    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyName()
    {
        return $this->agencyName;
    }

    /**
     * @param string $agencyName
     * @return $this
     */
    public function setAgencyName($agencyName)
    {
        $this->agencyName = $agencyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyName2()
    {
        return $this->agencyName2;
    }

    /**
     * @param string $agencyName2
     * @return $this
     */
    public function setAgencyName2($agencyName2)
    {
        $this->agencyName2 = $agencyName2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyReference()
    {
        return $this->agencyReference;
    }

    /**
     * @param string $agencyReference
     * @return $this
     */
    public function setAgencyReference($agencyReference)
    {
        $this->agencyReference = $agencyReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyPhone()
    {
        return $this->agencyPhone;
    }

    /**
     * @param string $agencyPhone
     * @return $this
     */
    public function setAgencyPhone($agencyPhone)
    {
        $this->agencyPhone = $agencyPhone;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyFax()
    {
        return $this->agencyFax;
    }

    /**
     * @param string $agencyFax
     * @return $this
     */
    public function setAgencyFax($agencyFax)
    {
        $this->agencyFax = $agencyFax;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyEmail()
    {
        return $this->agencyEmail;
    }

    /**
     * @param string $agencyEmail
     * @return $this
     */
    public function setAgencyEmail($agencyEmail)
    {
        $this->agencyEmail = $agencyEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyStreet()
    {
        return $this->agencyStreet;
    }

    /**
     * @param string $agencyStreet
     * @return $this
     */
    public function setAgencyStreet($agencyStreet)
    {
        $this->agencyStreet = $agencyStreet;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyZip()
    {
        return $this->agencyZip;
    }

    /**
     * @param string $agencyZip
     * @return $this
     */
    public function setAgencyZip($agencyZip)
    {
        $this->agencyZip = $agencyZip;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencyCity()
    {
        return $this->agencyCity;
    }

    /**
     * @param string $agencyCity
     * @return $this
     */
    public function setAgencyCity($agencyCity)
    {
        $this->agencyCity = $agencyCity;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisitName()
    {
        return $this->visitName;
    }

    /**
     * @param string $visitName
     * @return $this
     */
    public function setVisitName($visitName)
    {
        $this->visitName = $visitName;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisitPhone()
    {
        return $this->visitPhone;
    }

    /**
     * @param string $visitPhone
     * @return $this
     */
    public function setVisitPhone($visitPhone)
    {
        $this->visitPhone = $visitPhone;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisitEmail()
    {
        return $this->visitEmail;
    }

    /**
     * @param string $visitEmail
     * @return $this
     */
    public function setVisitEmail($visitEmail)
    {
        $this->visitEmail = $visitEmail;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $pictures
     * @return void
     */
    public function setPictures(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $pictures)
    {
        $this->pictures = $pictures;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\FileReference $pictures
     */
    public function addPictures(\TYPO3\CMS\Core\Resource\FileReference $pictures)
    {
        if ($this->getPictures() === null) {
            $this->pictures = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        $this->pictures->attach($pictures);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $documents
     * @return void
     */
    public function setDocuments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $documents)
    {
        $this->documents = $documents;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\FileReference $documents
     */
    public function addDocuments(\TYPO3\CMS\Core\Resource\FileReference $documents)
    {
        if ($this->getDocuments() === null) {
            $this->documents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        $this->documents->attach($documents);
    }
}