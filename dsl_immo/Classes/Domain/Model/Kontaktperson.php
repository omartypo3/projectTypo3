<?php
namespace DslFactory\DslImmo\Domain\Model;

/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * Kontaktperson
 */
class Kontaktperson extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * emailzentrale
     * 
     * @var string
     */
    protected $emailzentrale = '';

    /**
     * telzentrale
     * 
     * @var string
     */
    protected $telzentrale = '';

    /**
     * telfax
     * 
     * @var string
     */
    protected $telfax = '';

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * vorname
     * 
     * @var string
     */
    protected $vorname = '';

    /**
     * firma
     * 
     * @var string
     */
    protected $firma = '';

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
     * url
     * 
     * @var string
     */
    protected $url = '';

    /**
     * Returns the emailzentrale
     * 
     * @return string $emailzentrale
     */
    public function getEmailzentrale()
    {
        return $this->emailzentrale;
    }

    /**
     * Sets the emailzentrale
     * 
     * @param string $emailzentrale
     * @return void
     */
    public function setEmailzentrale($emailzentrale)
    {
        $this->emailzentrale = $emailzentrale;
    }

    /**
     * Returns the telzentrale
     * 
     * @return string $telzentrale
     */
    public function getTelzentrale()
    {
        return $this->telzentrale;
    }

    /**
     * Returns the telzentrale
     * 
     * @return string $telzentrale
     */
    public function getTelzentraleFormatiert()
    {
        $telArr = explode('-', $this->telzentrale);
        if (count($telArr) > 1) {
            $nummer = '';
            for ($x = 0; $x < strlen($telArr[1]); $x++) {
                $nummer .= $telArr[1][$x];
                if ($x % 2 != 0) {
                    $nummer .= ' ';
                }
            }
            return '+49 ' . ltrim($telArr[0], '0') . ' - ' . $nummer;
        }
        return $this->telzentrale;
    }

    /**
     * Sets the telzentrale
     * 
     * @param string $telzentrale
     * @return void
     */
    public function setTelzentrale($telzentrale)
    {
        $this->telzentrale = $telzentrale;
    }

    /**
     * Returns the telfax
     * 
     * @return string $telfax
     */
    public function getTelfax()
    {
        return $this->telfax;
    }

    /**
     * Sets the telfax
     * 
     * @param string $telfax
     * @return void
     */
    public function setTelfax($telfax)
    {
        $this->telfax = $telfax;
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
     * Returns the vorname
     * 
     * @return string $vorname
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Sets the vorname
     * 
     * @param string $vorname
     * @return void
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * Returns the firma
     * 
     * @return string $firma
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Sets the firma
     * 
     * @param string $firma
     * @return void
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;
    }

    /**
     * Returns the strasse
     * 
     * @return string $strasse
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
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

    /**
     * Returns the plz
     * 
     * @return string $plz
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
    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    /**
     * Returns the ort
     * 
     * @return string $ort
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
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

    /**
     * Returns the url
     * 
     * @return string $url
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
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the VornameName
     * 
     * @return string vornameName
     */
    public function getVornameName()
    {
        if ($this->vorname) {
            return $this->vorname . ' ' . $this->name;
        }
        return $this->name;
    }
}
