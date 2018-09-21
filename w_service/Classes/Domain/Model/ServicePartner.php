<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013
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
 *
 *
 * @package w_service
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_WService_Domain_Model_ServicePartner extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * company
	 *
	 * @var string
	 */
	protected $company;

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
	 * country
	 *
	 * @var string
	 */
	protected $country;

	/**
	 * city
	 *
	 * @var string
	 */
	protected $city;

	/**
	 * industry
	 *
	 * @var string
	 */
	protected $industry;

	/**
	 * phone
	 *
	 * @var string
	 */
	protected $phone;

	/**
	 * cell
	 *
	 * @var string
	 */
	protected $cell;

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
	 * website
	 *
	 * @var string
	 */
	protected $website;

    /**
     * additional
     *
     * @var string
     */
    protected $additional;

    /**
     * notes
     *
     * @var string
     */
    protected $notes;

    /**
     * lat
     *
     * @var string
     */
    protected $lat;

    /**
     * lng
     *
     * @var string
     */
    protected $lng;

	/**
	 * category
	 *
	 * @var Tx_WService_Domain_Model_Category
	 */
	protected $category;

	/**
	 * boost
	 *
	 * @var boolean
	 */
	protected $boost;

    /**
     * localizedUid
     *
     * @var integer
     */
    protected $localizedUid;

    /**
     * hidden
     *
     * @var boolean
     */
    protected $hidden = FALSE;

    /**
     * Returns the localizedUid
     *
     * @return integer $localizedUid
     */
    public function getLocalizedUid() {
        return $this->_localizedUid;
    }

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Gets boost value
	 *
	 * @return string $company
	 */
	public function isBoost() {
		return $this->boost;
	}

	/**
	 * Sets boost value
	 *
	 * @param boolean $boost
	 * @return void
	 */
	public function setBoost($boost) {
		$this->boost = $boost;
	}

	/**
	 * Returns the company
	 *
	 * @return string $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 *
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the street
	 *
	 * @return string $street
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * Sets the street
	 *
	 * @param string $street
	 * @return void
	 */
	public function setStreet($street) {
		$this->street = $street;
	}

	/**
	 * Returns the zip
	 *
	 * @return string $zip
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets the zip
	 *
	 * @param string $zip
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Returns the city
	 *
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the country
	 *
	 * @return string $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the country
	 *
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the industry
	 *
	 * @return string $industry
	 */
	public function getIndustry() {
		return $this->industry;
	}

	/**
	 * Sets the industry
	 *
	 * @param string $industry
	 * @return void
	 */
	public function setIndustry($industry) {
		$this->industry = $industry;
	}

	/**
	 * Returns the phone
	 *
	 * @return string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 *
	 * @param string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the cell
	 *
	 * @return string $cell
	 */
	public function getCell() {
		return $this->cell;
	}

	/**
	 * Sets the cell
	 *
	 * @param string $cell
	 * @return void
	 */
	public function setCell($cell) {
		$this->cell = $cell;
	}

	/**
	 * Returns the fax
	 *
	 * @return string $fax
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets the fax
	 *
	 * @param string $fax
	 * @return void
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Returns the email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the website
	 *
	 * @return string $website
	 */
	public function getWebsite() {
		return $this->website;
	}

	/**
	 * Sets the website
	 *
	 * @param string $website
	 * @return void
	 */
	public function setWebsite($website) {
		$this->website = $website;
	}

    /**
     * Returns the additional
     *
     * @return string $additional
     */
    public function getAdditional() {
        return $this->additional;
    }

    /**
     * Sets the additional
     *
     * @param string $additional
     * @return void
     */
    public function setAdditional($additional) {
        $this->additional = $additional;
    }

    /**
     * Returns the notes
     *
     * @return string $notes
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Sets the notes
     *
     * @param string $notes
     * @return void
     */
    public function setNotes($notes) {
        $this->notes = $notes;
    }

    /**
     * Returns the lat
     *
     * @return string $lat
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * Sets the lat
     *
     * @param string $lat
     * @return void
     */
    public function setLat($lat) {
        $this->lat = $lat;
    }

    /**
     * Returns the lng
     *
     * @return string $lng
     */
    public function getLng() {
        return $this->lng;
    }

    /**
     * Sets the lng
     *
     * @param string $lng
     * @return void
     */
    public function setLng($lng) {
        $this->lng = $lng;
    }

	/**
	 * Sets a Category
	 *
	 * @param Tx_WService_Domain_Model_Category $category
	 * @return void
	 */
	public function setCategory(Tx_WService_Domain_Model_Category $category) {
		$this->category = $category;
	}

	/**
	 * Returns the category
	 *
	 * @return Tx_WService_Domain_Model_Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

    /**
     * Returns hidden
     *
     * @return boolean $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }


    /**
     * Sets hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }


    /**
     * Returns the boolean state of hidden
     *
     * @return boolean
     */
    public function isHidden() {
        return $this->getHidden();
    }
}
?>