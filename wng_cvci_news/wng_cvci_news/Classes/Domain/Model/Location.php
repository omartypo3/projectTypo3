<?php
namespace Wng\WngCvciNews\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Georg Ringer, montagmorgen.at
 *
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
 ***************************************************************/

/**
 * Location
 */
class Location extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * name
     *
     * @var string
     */
    protected $name;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * street
     *
     * @var string
     */
    protected $street;

    /**
     * zip
     *
     * @var string
     */
    protected $zip;

    /**
     * city
     *
     * @var string
     */
    protected $city;

    /**
     * countryZone
     *
     * @var string
     */
    protected $countryZone;

    /**
     * country
     *
     * @var string
     */
    protected $country;

    /**
     * latitude
     *
     * @var double
     */
    protected $latitude;

    /**
     * longitude
     *
     * @var double
     */
    protected $longitude;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @param string $street street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set zip
     *
     * @param string $zip zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get countryZone
     *
     * @return string
     */
    public function getCountryZone()
    {
        return $this->countryZone;
    }

    /**
     * Set countryZone
     *
     * @param string $countryZone countryZone
     * @return void
     */
    public function setCountryZone($countryZone)
    {
        $this->countryZone = $countryZone;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get latitude
     *
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param double $latitude latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get longitude
     *
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param double $longitude longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getName().', '.$this->getStreet().', '.$this->getZip().' '.$this->getCity();
    }

}