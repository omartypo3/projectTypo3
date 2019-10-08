<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 13.08.2018
 * Time: 13:37
 */

namespace Pingag\PingagRealEstate\Form;

use Pingag\PingagRealEstate\Service\RealEstateOptionFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RealEstateFilter
{

    const SELECT_ALL_KEYWORD = 'all';
    
    /**
     * Km
     * @var string
     */
    protected $searchString = '';
    /**
     * Ort, Region, PLZ, Land
     * @var string
     */
    protected $searchkm = '';
    /**
     * Mieten / Kaufen
     * @var string
     */
    protected $offerType;
    /**
     * "Was"
     * @var string
     */
    protected $objectCategory;
    /**
     * Objektart
     * @var string
     */
    protected $objectType;
    /** @var int */
    protected $disableObjectType;
    /** @var string */
    protected $priceMin;
    /** @var string */
    protected $priceMax;
    /** @var string */
    protected $roomsMin;
    /** @var string */
    protected $roomsMax;
    
    
    /** @var string */
    protected $objectSituation;
    /** @var string */
    protected $floor;
    /** @var string */
    protected $surfaceUsableMin;
    /** @var string */
    protected $surfaceUsableMax;
    
    /** @var array */
    protected $options;
    
    /** @var array */
    protected $properties;
    
    /** @var bool */
    protected $propBalcony;
    /** @var bool */
    protected $animalAllowed;
    /** @var bool */
    protected $propElevator;
    /** @var bool */
    protected $minergieGeneral;
    /** @var bool */
    protected $newBuilding;
    /** @var bool */
    protected $propGarage;
    /** @var bool */
    protected $propParking;
    /** @var bool */
    protected $wheelchairAccessible;
    
    /** @var int */
    protected $limit = 0;
    /** @var int */
    protected $offset = 0;
    /** @var bool */
    protected $showExtended = false;
    
    /**
     * RealEstateFilter constructor.
     */
    public function __construct()
    {
        $this->offerType = 'RENT';
        $this->priceMin = 0;
        $this->priceMax = 10000000;
        $this->roomsMin = 0;
        $this->roomsMax = 10;
        $this->surfaceUsableMin = 0;
        $this->surfaceUsableMax = 5000;
    }
    
    public function buildFilterOptions()
    {
        $optionsFactory = GeneralUtility::makeInstance(RealEstateOptionFactory::class);
        $this->options = $optionsFactory->getFilterOptions($this);
    }
    
    public function getDisableObjectType()
    {
        return ($this->getObjectCategory() && $this->getObjectCategory() !== self::SELECT_ALL_KEYWORD) ? '' : 1;
    }

    /**
     * @return array
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * @param array $searchString
     * @return $this
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchkm()
    {
        return $this->searchkm;
    }

    /**
     * @param string $searchkm
     * @return $this
     */
    public function setSearchkm($searchkm)
    {
        $this->searchkm = $searchkm;
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
    public function getPriceMin()
    {
        return $this->priceMin;
    }

    /**
     * @param string $priceMin
     * @return $this
     */
    public function setPriceMin($priceMin)
    {
        $this->priceMin = $priceMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriceMax()
    {
        return $this->priceMax;
    }

    /**
     * @param string $priceMax
     * @return $this
     */
    public function setPriceMax($priceMax)
    {
        $this->priceMax = $priceMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoomsMin()
    {
        return $this->roomsMin;
    }

    /**
     * @param string $roomsMin
     * @return $this
     */
    public function setRoomsMin($roomsMin)
    {
        $this->roomsMin = $roomsMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoomsMax()
    {
        return $this->roomsMax;
    }

    /**
     * @param string $roomsMax
     * @return $this
     */
    public function setRoomsMax($roomsMax)
    {
        $this->roomsMax = $roomsMax;
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
    public function getSurfaceUsableMin()
    {
        return $this->surfaceUsableMin;
    }

    /**
     * @param string $surfaceUsableMin
     * @return $this
     */
    public function setSurfaceUsableMin($surfaceUsableMin)
    {
        $this->surfaceUsableMin = $surfaceUsableMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceUsableMax()
    {
        return $this->surfaceUsableMax;
    }

    /**
     * @param string $surfaceUsableMax
     * @return $this
     */
    public function setSurfaceUsableMax($surfaceUsableMax)
    {
        $this->surfaceUsableMax = $surfaceUsableMax;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return $this
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowExtended()
    {
        return $this->showExtended;
    }

    /**
     * @param bool $showExtended
     * @return $this
     */
    public function setShowExtended($showExtended)
    {
        $this->showExtended = $showExtended;
        return $this;
    }
}