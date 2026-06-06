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
 * weiterestandorte
 */
class Weiterestandorte extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * strasse
     *
     * @var string
     */
    protected $strasse = '';

    /**
     * plz
     *
     * @var string
     */
    protected $plz = '';

    /**
     * ort
     *
     * @var string
     */
    protected $ort = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * telefon
     *
     * @var string
     */
    protected $telefon = '';

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * breitengrad
     *
     * @var string
     */
    protected $breitengrad = '';

    /**
     * beschreibung
     *
     * @var string
     */
    protected $beschreibung = '';

    /**
     * laungengrad
     *
     * @var string
     */
    protected $laungengrad = '';

    /**
     * kantone
     *
     * @var string
     */
    protected $kantone = '';

    /**
     * Returns the strasse
     *
     * @return string
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * Sets the strasse
     *
     * @param string $strasse
     * @return void
     */
    public function setStrasse(string $strasse)
    {
        $this->strasse = $strasse;
    }

    /**
     * Returns the plz
     *
     * @return string
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * Sets the plz
     *
     * @param string $plz
     * @return void
     */
    public function setPlz(string $plz)
    {
        $this->plz = $plz;
    }

    /**
     * Returns the ort
     *
     * @return string
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * Sets the ort
     *
     * @param string $ort
     * @return void
     */
    public function setOrt(string $ort)
    {
        $this->ort = $ort;
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
     * Returns the url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Returns the breitengrad
     *
     * @return string
     */
    public function getBreitengrad()
    {
        return $this->breitengrad;
    }

    /**
     * Sets the breitengrad
     *
     * @param string $breitengrad
     * @return void
     */
    public function setBreitengrad(string $breitengrad)
    {
        $this->breitengrad = $breitengrad;
    }

    /**
     * Returns the laungengrad
     *
     * @return string
     */
    public function getLaungengrad()
    {
        return $this->laungengrad;
    }

    /**
     * Sets the laungengrad
     *
     * @param string $laungengrad
     * @return void
     */
    public function setLaungengrad(string $laungengrad)
    {
        $this->laungengrad = $laungengrad;
    }

    /**
     * Returns the kantone
     *
     * @return string
     */
    public function getKantone()
    {
        return $this->kantone;
    }

    /**
     * Sets the kantone
     *
     * @param string $kantone
     * @return void
     */
    public function setKantone(string $kantone)
    {
        $this->kantone = $kantone;
    }

    /**
     * _languageUid
     * @var int
     */
    protected $_languageUid;

    /**
     * @param int $_languageUid
     * @return void
     */
    public function set_languageUid($_languageUid) {
        $this->_languageUid = $_languageUid;
    }

    /**
     * @return int
     */
    public function get_languageUid() {
        return $this->_languageUid;
    }

    /**
     * Returns the beschreibung
     *
     * @return string
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * Sets the beschreibung
     *
     * @param string $beschreibung
     * @return void
     */
    public function setBeschreibung(string $beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }
}
