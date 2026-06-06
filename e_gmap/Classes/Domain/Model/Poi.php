<?php

namespace Emagineurs\EGmap\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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
 * Poi
 */
class Poi extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * society
     *
     * @var string
     */
    protected $society = '';

    /**
     * picto
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $picto = null;

    /**
     * note
     *
     * @var string
     */
    protected $note = '';

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * address
     *
     * @var string
     */
    protected $address = '';

    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * country
     *
     * @var string
     */
    protected $country = '';

    /**
     * phone
     *
     * @var string
     */
    protected $phone = '';

    /**
     * cellphone
     *
     * @var string
     */
    protected $cellphone = '';

    /**
     * fax
     *
     * @var string
     */
    protected $fax = '';

    /**
     * website
     *
     * @var string
     */
    protected $website = '';

    /**
     * mail
     *
     * @var string
     */
    protected $mail = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;

    /**
     * file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $file = null;

    /**
     * html
     *
     * @var string
     */
    protected $html = '';

    /**
     * lat
     *
     * @var string
     */
    protected $lat = '';

    /**
     * lng
     *
     * @var string
     */
    protected $lng = '';

    /**
     * category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category>
     */
    protected $category;


    /**
     * __construct
     *
     * @return Diapos
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the society
     *
     * @return string $society
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * Sets the society
     *
     * @param string $society
     * @return void
     */
    public function setSociety($society)
    {
        $this->society = $society;
    }

    /**
     * Returns the picto
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $picto
     */
    public function getPicto()
    {
        return $this->picto;
    }

    /**
     * Sets the picto
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $picto
     * @return void
     */
    public function setPicto(\TYPO3\CMS\Extbase\Domain\Model\FileReference $picto)
    {
        $this->picto = $picto;
    }

    /**
     * Returns the note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Sets the note
     *
     * @param string $note
     * @return void
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Returns the address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the cellphone
     *
     * @return string $cellphone
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Sets the cellphone
     *
     * @param string $cellphone
     * @return void
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }

    /**
     * Returns the fax
     *
     * @return string $fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Sets the fax
     *
     * @param string $fax
     * @return void
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Returns the website
     *
     * @return string $website
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the website
     *
     * @param string $website
     * @return void
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Returns the mail
     *
     * @return string $mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Sets the mail
     *
     * @param string $mail
     * @return void
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->file = $file;
    }

    /**
     * Returns the html
     *
     * @return string $html
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Sets the html
     *
     * @param string $html
     * @return void
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * Returns the lat
     *
     * @return string $lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Sets the lat
     *
     * @param string $lat
     * @return void
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Returns the lng
     *
     * @return string $lng
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Sets the lng
     *
     * @param string $lng
     * @return void
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * Returns the category
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category> $category
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Sets the category
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category> $category
     * @return void
     */
    public function setCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $category)
    {
        $this->category = $category;
    }

    /**
     * Is ok
     *
     * @return bool
     */
    public function getPlaceable()
    {
        return $this->isPlaceable();
    }

    /**
     * Is ok
     *
     * @return bool
     */
    public function isPlaceable()
    {
        if (!empty($this->lat) && !empty($this->lng)) {
            return true;
        }
        return false;
    }

    /**
     * Returns the marker icon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $iconmarker
     */
    public function getIconmarker()
    {
        if (!empty($this->picto)) {
            return $this->picto;
        }
        if ($this->category) {
            $cat = $this->category->toArray();
            if (count($cat) > 0) {
                $image = $cat[0]->getIconmarker();
                if (!empty($image)) {
                    return $image;
                }
            }
        }

        return $this->picto;
    }

    /**
     * Is cat egmap
     *
     * @return \Emagineurs\EGmap\Domain\Model\Category
     */
    public function getEgmapCat($index = 0)
    {
        $cat = $this->category->toArray();
        if (count($cat) > $index) {
            return $cat[$index];
        }

        return null;
    }


    /**
     * Get list cat
     *
     * @return string
     */
    public function getCatliste()
    {
        $liste = array();
        if ($this->category) {
            foreach ($this->category as $cat) {
                $liste[] = $cat->getUid();
            }
        }
        return implode(',', $liste);
    }
}