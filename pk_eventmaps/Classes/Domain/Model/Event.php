<?php
namespace EventMaps\PkEventmaps\Domain\Model;

/***
 *
 * This file is part of the "EventMaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Patrick Kudla, Avonis
 *
 ***/

/**
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * date
     *
     * @var \DateTime
     */
    protected $date = null;

    /**
     * aktionszeit
     *
     * @var string
     */
    protected $aktionszeit = '';

    /**
     * location
     *
     * @var string
     */
    protected $location = '';

    /**
     * street
     *
     * @var string
     */
    protected $street = '';

    /**
     * streetnumber
     *
     * @var string
     */
    protected $streetnumber = '';

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
     * moderator
     *
     * @var string
     */
    protected $moderator = '';

    /**
     * informations
     *
     * @var string
     */
    protected $informations = '';

    /**
     * fon
     *
     * @var string
     */
    protected $fon = '';

    /**
     * fax
     *
     * @var string
     */
    protected $fax = '';

    /**
     * mail
     *
     * @var string
     */
    protected $mail = '';

    /**
     * lon
     *
     * @var string
     */
    protected $lon = '';

    /**
     * lat
     *
     * @var string
     */
    protected $lat = '';

    /**
     * month
     *
     * @var string
     */
    protected $month = '';

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
     * Returns the date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns the aktionszeit
     *
     * @return string $aktionszeit
     */
    public function getAktionszeit()
    {
        return $this->aktionszeit;
    }

    /**
     * Sets the aktionszeit
     *
     * @param string $aktionszeit
     * @return void
     */
    public function setAktionszeit($aktionszeit)
    {
        $this->aktionszeit = $aktionszeit;
    }

    /**
     * Returns the location
     *
     * @return string $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param string $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Returns the street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the streetnumber
     *
     * @return string $streetnumber
     */
    public function getStreetnumber()
    {
        return $this->streetnumber;
    }

    /**
     * Sets the streetnumber
     *
     * @param string $streetnumber
     * @return void
     */
    public function setStreetnumber($streetnumber)
    {
        $this->streetnumber = $streetnumber;
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
     * Returns the moderator
     *
     * @return string $moderator
     */
    public function getModerator()
    {
        return $this->moderator;
    }

    /**
     * Sets the moderator
     *
     * @param string $moderator
     * @return void
     */
    public function setModerator($moderator)
    {
        $this->moderator = $moderator;
    }

    /**
     * Returns the informations
     *
     * @return string $informations
     */
    public function getInformations()
    {
        return $this->informations;
    }

    /**
     * Sets the informations
     *
     * @param string $informations
     * @return void
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;
    }

    /**
     * Returns the fon
     *
     * @return string $fon
     */
    public function getFon()
    {
        return $this->fon;
    }

    /**
     * Sets the fon
     *
     * @param string $fon
     * @return void
     */
    public function setFon($fon)
    {
        $this->fon = $fon;
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
     * Returns the lon
     *
     * @return string $lon
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Sets the lon
     *
     * @param string $lon
     * @return void
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
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
     * Returns the month
     *
     * @return string $month
     */
    public function getMonth()
    {
        return $this->getdate()->format('n');
    }


}
