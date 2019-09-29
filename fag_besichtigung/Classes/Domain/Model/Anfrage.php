<?php
namespace FRONTAL\FagBesichtigung\Domain\Model;

/***
 *
 * This file is part of the "besichtigung" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * Anfrage
 */
class Anfrage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var boolean
     */
    protected $hidden;

    /**
     * anrede
     * 
     * @var string
     */
    protected $anrede = '';

    /**
     * vorname
     * 
     * @var string
     */
    protected $vorname = '';

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * funktion
     * 
     * @var string
     */
    protected $funktion = '';

    /**
     * strasse
     * 
     * @var string
     */
    protected $strasse = '';

    /**
     * ortPLZ
     * 
     * @var string
     */
    protected $ortPLZ = '';

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
     * bemerkung
     * 
     * @var string
     */
    protected $bemerkung = '';

    /**
     * gruppenname
     * 
     * @var string
     */
    protected $gruppenname = '';

    /**
     * durchschnittsalter
     * 
     * @var string
     */
    protected $durchschnittsalter = '';

    /**
     * teilnehmeraktuell
     * 
     * @var int
     */
    protected $teilnehmeraktuell = 0;

    /**
     * @return boolean $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * @return boolean $hidden
     */
    public function isHidden() {
        return $this->getHidden();
    }

    /**
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }

    /**
     * Returns the anrede
     * 
     * @return string $anrede
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * Sets the anrede
     * 
     * @param string $anrede
     * @return void
     */
    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
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
     * Returns the funktion
     * 
     * @return string $funktion
     */
    public function getFunktion()
    {
        return $this->funktion;
    }

    /**
     * Sets the funktion
     * 
     * @param string $funktion
     * @return void
     */
    public function setFunktion($funktion)
    {
        $this->funktion = $funktion;
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
     * Returns the ortPLZ
     * 
     * @return string $ortPLZ
     */
    public function getOrtPLZ()
    {
        return $this->ortPLZ;
    }

    /**
     * Sets the ortPLZ
     * 
     * @param string $ortPLZ
     * @return void
     */
    public function setOrtPLZ($ortPLZ)
    {
        $this->ortPLZ = $ortPLZ;
    }

    /**
     * Returns the email
     * 
     * @return string $email
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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the telefon
     * 
     * @return string $telefon
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
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
    }

    /**
     * Returns the bemerkung
     * 
     * @return string $bemerkung
     */
    public function getBemerkung()
    {
        return $this->bemerkung;
    }

    /**
     * Sets the bemerkung
     * 
     * @param string $bemerkung
     * @return void
     */
    public function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
    }

    /**
     * Returns the gruppenname
     * 
     * @return string $gruppenname
     */
    public function getGruppenname()
    {
        return $this->gruppenname;
    }

    /**
     * Sets the gruppenname
     * 
     * @param string $gruppenname
     * @return void
     */
    public function setGruppenname($gruppenname)
    {
        $this->gruppenname = $gruppenname;
    }

    /**
     * Returns the durchschnittsalter
     * 
     * @return string $durchschnittsalter
     */
    public function getDurchschnittsalter()
    {
        return $this->durchschnittsalter;
    }

    /**
     * Sets the durchschnittsalter
     * 
     * @param string $durchschnittsalter
     * @return void
     */
    public function setDurchschnittsalter($durchschnittsalter)
    {
        $this->durchschnittsalter = $durchschnittsalter;
    }

    /**
     * Returns the teilnehmeraktuell
     * 
     * @return int $teilnehmeraktuell
     */
    public function getTeilnehmeraktuell()
    {
        return $this->teilnehmeraktuell;
    }

    /**
     * Sets the teilnehmeraktuell
     * 
     * @param int $teilnehmeraktuell
     * @return void
     */
    public function setTeilnehmeraktuell($teilnehmeraktuell)
    {
        $this->teilnehmeraktuell = $teilnehmeraktuell;
    }
    /**
     * Sets the datum
     *
     * @param string $datum
     * @return void
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    /**
     * Returns the datum
     *
     * @return string $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }
}
