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
 * Organizer
 */
class Organizer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
     * phone
     *
     * @var string
     */
    protected $phone;

    /**
     * fax
     *
     * @var string
     */
    protected $fax;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    /**
     * link
     *
     * @var string
     */
    protected $link;


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
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set fax
     *
     * @param string $fax fax
     * @return void
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set link
     *
     * @param string $link link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
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