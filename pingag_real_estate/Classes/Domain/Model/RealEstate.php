<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.07.2018
 * Time: 13:49
 */

namespace Pingag\PingagRealEstate\Domain\Model;

use Pingag\PingagRealEstate\Util\GeneralUtil;

class RealEstate extends AbstractRealEstate
{

    const REAL_ESTATE_PROPERTIES = [
        'propBalcony',
        'animalAllowed',
        'propElevator',
        'minergieGeneral',
        'newBuilding',
        'propGarage',
        'propParking',
        'wheelchairAccessible',
    ];

    public function calculatePrice()
    {
        $offerType = $this->getOfferType();
        if ($offerType == 'SALE') {
            $this->setPrice($this->getSellingPrice());
        } elseif ($offerType == 'RENT') {
            $this->setPrice((int)$this->getRentNet() + (int)$this->getRentExtra());
        }
    }

    public function getRefCode()
    {
        return implode('.', [
            $this->getRefProperty(),
            $this->getRefHouse(),
            $this->getRefObject()
        ]);
    }

    public function getAddress()
    {
        return $this->getObjectStreet() . ', ' . $this->getObjectZip() . ' ' . $this->getObjectCity();
    }

    public function getObjectTeaser()
    {
        return strip_tags($this->getObjectDescription());
    }
    
    public function getIsSale()
    {
        return $this->getOfferType() === 'SALE';
    }
    
    public function getIsRent()
    {
        return $this->getOfferType() === 'RENT';
    }
    
    public function getPriceText()
    {
        if($this->getPrice() == 0){
            return GeneralUtil::translate('show.priceOnRequest');
        }
        return $this->getCurrency() . ' ' . number_format($this->getPrice(), 0, ".", "‘") . '.–';
    }
    
    public static function propertyGetter($property)
    {
        return 'is' . ucfirst($property);
    }
    
    public function getAvailableProperties()
    {
        $properties = [];
        foreach (self::REAL_ESTATE_PROPERTIES as $property) {
            $getter = self::propertyGetter($property);
            if (method_exists($this, $getter)) {
                if ($this->$getter()) {
                    $properties[] = $property;
                }
            }
        }
        return $properties;
    }
}