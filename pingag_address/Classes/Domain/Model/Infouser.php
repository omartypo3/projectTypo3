<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "Kommunikation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * Infouser
 */
class Infouser extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $addressid = '';

    /**
     * @var string
     */
    protected $zip = '';

    /**
     * @var string
     */
    protected $stadt = '';

    /**
     * @var string
     */
    protected $land = '';

    /**
     * @var string
     */
    protected $telefon = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $userid = '';

    /**
     * @var string
     */
    protected $angeboteid = '';

    /**
     * @var string
     */
    protected $lebensalterid = '';

    /**
     * @var string
     */
    protected $dienstleistungenid = '';

    /**
     * @var string
     */
    protected $kantonesid = '';

    /**
     * namelebensalter
     *
     * @var string
     */
    protected $namelebensalter = '';

    /**
     * nameangebote
     *
     * @var string
     */
    protected $nameangebote = '';

    /**
     * beschreibungangebote
     *
     * @var string
     */
    protected $beschreibungangebote = '';

    /**
     * pid
     *
     * @var int
     */
    protected $pid;

    /**
     * Sets the addressid value
     *
     * @param string $addressid
     */
    public function setAddressid($addressid)
    {
        $this->addressid = $addressid;
    }

    /**
     * Returns the addressid value
     *
     * @return string
     */
    public function getAddressid()
    {
        return $this->addressid;
    }


    /**
     * Returns the zip
     *
     * @return string
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
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }


    /**
     * Returns the stadt
     *
     * @return string
     */
    public function getStadt()
    {
        return $this->stadt;
    }

    /**
     * Sets the stadt
     *
     * @param string $stadt
     * @return void
     */
    public function setStadt(string $stadt)
    {
        $this->stadt = $stadt;
    }

    /**
     * Returns the land
     *
     * @return string
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * Sets the land
     *
     * @param string $land
     * @return void
     */
    public function setLand(string $land)
    {
        $this->land = $land;
    }

    /**
     * Returns the telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Sets the telefon
     *
     * @param string $telefon
     * @return void
     */
    public function setTelefon(string $telefon)
    {
        $this->telefon = $telefon;
    }

    /**
     * Returns the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the name
     *
     * @return string
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
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * Sets the userid value
     *
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * Returns the userid value
     *
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }


    /**
     * Sets the angeboteid value
     *
     * @param string $angeboteid
     */
    public function setAngeboteid($angeboteid)
    {
        $this->angeboteid = $angeboteid;
    }

    /**
     * Returns the angeboteid value
     *
     * @return string
     */
    public function getAngeboteid()
    {
        return $this->angeboteid;
    }


    /**
     * Sets the lebensalterid value
     *
     * @param string $lebensalterid
     */
    public function setLebensalterid($lebensalterid)
    {
        $this->lebensalterid = $lebensalterid;
    }

    /**
     * Returns the lebensalterid value
     *
     * @return string
     */
    public function getLebensalterid()
    {
        return $this->lebensalterid;
    }


    /**
     * Returns the namelebensalter
     *
     * @return string
     */
    public function getNamelebensalter()
    {
        return $this->namelebensalter;
    }

    /**
     * Sets the namelebensalter
     *
     * @param string $namelebensalter
     * @return void
     */
    public function setNamelebensalter(string $namelebensalter)
    {
        $this->namelebensalter = $namelebensalter;
    }

    /**
     * Returns the nameangebote
     *
     * @return string
     */
    public function getNameangebote()
    {
        return $this->nameangebote;
    }

    /**
     * Sets the nameangebote
     *
     * @param string $nameangebote
     * @return void
     */
    public function setNameangebote(string $nameangebote)
    {
        $this->nameangebote = $nameangebote;
    }


    /**
     * Returns the beschreibungangebote
     *
     * @return string
     */
    public function getBeschreibungangebote()
    {
        return $this->beschreibungangebote;
    }

    /**
     * Sets the beschreibungangebote
     *
     * @param string $beschreibungangebote
     * @return void
     */
    public function setBeschreibungangebote(string $beschreibungangebote)
    {
        $this->beschreibungangebote = $beschreibungangebote;
    }

    /**
     * Sets the dienstleistungenid value
     *
     * @param string $dienstleistungenid
     */
    public function setDienstleistungenid($dienstleistungenid)
    {
        $this->dienstleistungenid = $dienstleistungenid;
    }

    /**
     * Returns the dienstleistungenid value
     *
     * @return string
     */
    public function getDienstleistungenid()
    {
        return $this->dienstleistungenid;
    }

    /**
     * Sets the kantonesid value
     *
     * @param string $kantonesid
     */
    public function setKantonesid($kantonesid)
    {
        $this->kantonesid = $kantonesid;
    }

    /**
     * Returns the kantonesid value
     *
     * @return string
     */
    public function getKantonesid()
    {
        return $this->kantonesid;
    }

}
