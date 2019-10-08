<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 23.07.2018
 * Time: 15:05
 */

namespace Pingag\PingagRealEstate\Domain\Model\Interfaces;

interface RealEstateIDX
{
    /** @return string */
    public function getVersion();
    /** @return string */
    public function getSenderId();
    /** @return string */
    public function getObjectCategory();
    /** @return int */
    public function getObjectType();
    /** @return string */
    public function getOfferType();
    /** @return string */
    public function getRefProperty();
    /** @return string */
    public function getRefHouse();
    /** @return string */
    public function getRefObject();
    /** @return string */
    public function getObjectStreet();
    /** @return string */
    public function getObjectZip();
    /** @return string */
    public function getObjectCity();
    /** @return string */
    public function getObjectCountry();
    /** @return string */
    public function getObjectTitle();
    /** @return string */
    public function getObjectDescription();
    /** @return int */
    public function getSellingPrice();
    /** @return int */
    public function getRentNet();
    /** @return string */
    public function getPriceUnit();
    /** @return string */
    public function getCurrency();
    /** @return string */
    public function getAgencyId();
}