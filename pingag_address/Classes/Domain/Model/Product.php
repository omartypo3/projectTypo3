<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */

/**
 * Map
 */
class Product extends \Extcode\CartProducts\Domain\Model\Product\Product
{

    /**
     * Szblindnummer
     *
     * @var string
     */
    protected $Szblindnummer = '';

    /**
     * Verfasser
     *
     * @var string
     */
    protected $Verfasser = '';

    /**
     * Verlag
     *
     * @var string
     */
    protected $Verlag = '';

    /**
     * Jahr
     *
     * @var string
     */
    protected $Jahr = '';

    /**
     * Seitenanzahl
     *
     * @var string
     */
    protected $Seitenanzahl = '';

    /**
     * Returns the Szblindnummer
     *
     * @return string
     */
    public function getSzblindnummer()
    {
        return $this->Szblindnummer;
    }

    /**
     * Sets the Szblindnummer
     *
     * @param string $Szblindnummer
     * @return void
     */
    public function setSzblindnummer(string $Szblindnummer)
    {
        $this->Szblindnummer = $Szblindnummer;
    }

    /**
     * Returns the Verfasser
     *
     * @return string
     */
    public function getVerfasser()
    {
        return $this->Verfasser;
    }

    /**
     * Sets the Verfasser
     *
     * @param string $Verfasser
     * @return void
     */
    public function setVerfasser(string $Verfasser)
    {
        $this->Verfasser = $Verfasser;
    }

    /**
     * Returns the Verlag
     *
     * @return string
     */
    public function getVerlag()
    {
        return $this->Verlag;
    }

    /**
     * Sets the Verlag
     *
     * @param string $Verlag
     * @return void
     */
    public function setVerlag(string $Verlag)
    {
        $this->Verlag = $Verlag;
    }

    /**
     * Returns the Jahr
     *
     * @return string
     */
    public function getJahr()
    {
        return $this->Jahr;
    }

    /**
     * Sets the Jahr
     *
     * @param string $Jahr
     * @return void
     */
    public function setJahr(string $Jahr)
    {
        $this->Jahr = $Jahr;
    }
    /**
     * Returns the Seitenanzahl
     *
     * @return string
     */
    public function getSeitenanzahl()
    {
        return $this->Seitenanzahl;
    }

    /**
     * Sets the Seitenanzahl
     *
     * @param string $Seitenanzahl
     * @return void
     */
    public function setSeitenanzahl(string $Seitenanzahl)
    {
        $this->Seitenanzahl = $Seitenanzahl;
    }
}
