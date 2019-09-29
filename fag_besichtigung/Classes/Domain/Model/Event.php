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
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * titel
     * 
     * @var string
     */
    protected $titel = '';

    /**
     * untertitel
     * 
     * @var string
     */
    protected $untertitel = '';

    /**
     * bild
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @validate NotEmpty
     * @cascade remove
     */
    protected $bild = null;

    /**
     * text
     * 
     * @var string
     */
    protected $text = '';

    /**
     * zusatztext
     * 
     * @var string
     */
    protected $zusatztext = '';

    /**
     * preishinweis
     * 
     * @var string
     */
    protected $preishinweis = '';
    /**
     * textEmail
     *
     * @var string
     */
    protected $textEmail = '';

    /**
     * treffpunkt
     *
     * @var string
     */
    protected $treffpunkt = '';
    /**
     * datum
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Datum>
     * @cascade remove
     */
    protected $datum = null;

    /**
     * gruppenFuhrer
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer>
     * @cascade remove
     */
    protected $gruppenFuhrer = null;

    /**
     * sendemail
     *
     * @var string
     */
    protected $sendemail = '';

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->datum = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->gruppenFuhrer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the titel
     * 
     * @return string $titel
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Sets the titel
     * 
     * @param string $titel
     * @return void
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * Returns the untertitel
     * 
     * @return string $untertitel
     */
    public function getUntertitel()
    {
        return $this->untertitel;
    }

    /**
     * Sets the untertitel
     * 
     * @param string $untertitel
     * @return void
     */
    public function setUntertitel($untertitel)
    {
        $this->untertitel = $untertitel;
    }

    /**
     * Returns the bild
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * Sets the bild
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
     * @return void
     */
    public function setBild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bild)
    {
        $this->bild = $bild;
    }

    /**
     * Returns the text
     * 
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     * 
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the zusatztext
     * 
     * @return string $zusatztext
     */
    public function getZusatztext()
    {
        return $this->zusatztext;
    }

    /**
     * Sets the zusatztext
     * 
     * @param string $zusatztext
     * @return void
     */
    public function setZusatztext($zusatztext)
    {
        $this->zusatztext = $zusatztext;
    }

    /**
     * Returns the preishinweis
     * 
     * @return string $preishinweis
     */
    public function getPreishinweis()
    {
        return $this->preishinweis;
    }

    /**
     * Sets the preishinweis
     * 
     * @param string $preishinweis
     * @return void
     */
    public function setPreishinweis($preishinweis)
    {
        $this->preishinweis = $preishinweis;
    }

    /**
     * Returns the textEmail
     *
     * @return string $textEmail
     */
    public function getTextEmail()
    {
        return $this->textEmail;
    }

    /**
     * Sets the textEmail
     *
     * @param string $textEmail
     * @return void
     */
    public function setTextEmail($textEmail)
    {
        $this->textEmail = $textEmail;
    }

    /**
     * Returns the treffpunkt
     *
     * @return string $treffpunkt
     */
    public function getTreffpunkt()
    {
        return $this->treffpunkt;
    }

    /**
     * Sets the treffpunkt
     *
     * @param string $treffpunkt
     * @return void
     */
    public function setTreffpunkt($treffpunkt)
    {
        $this->treffpunkt = $treffpunkt;
    }
    /**
     * Adds a Datum
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datum
     * @return void
     */
    public function addDatum(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datum)
    {
        $this->datum->attach($datum);
    }

    /**
     * Removes a Datum
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Datum $datumToRemove The Datum to be removed
     * @return void
     */
    public function removeDatum(\FRONTAL\FagBesichtigung\Domain\Model\Datum $datumToRemove)
    {
        $this->datum->detach($datumToRemove);
    }

    /**
     * Returns the datum
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Datum> $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Sets the datum
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Datum> $datum
     * @return void
     */
    public function setDatum(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $datum)
    {
        $this->datum = $datum;
    }

    /**
     * Adds a GruppenFuhrer
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @return void
     */
    public function addGruppenFuhrer(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->gruppenFuhrer->attach($gruppenFuhrer);
    }

    /**
     * Removes a GruppenFuhrer
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrerToRemove The GruppenFuhrer to be removed
     * @return void
     */
    public function removeGruppenFuhrer(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrerToRemove)
    {
        $this->gruppenFuhrer->detach($gruppenFuhrerToRemove);
    }

    /**
     * Returns the gruppenFuhrer
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer> $gruppenFuhrer
     */
    public function getGruppenFuhrer()
    {
        return $this->gruppenFuhrer;
    }

    /**
     * Sets the gruppenFuhrer
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer> $gruppenFuhrer
     * @return void
     */
    public function setGruppenFuhrer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $gruppenFuhrer)
    {
        $this->gruppenFuhrer = $gruppenFuhrer;
    }

    /**
     * Returns the sendemail
     *
     * @return string $sendemail
     */
    public function getSendEmail()
    {
        return $this->sendemail;
    }

    /**
     * Sets the sendemail
     *
     * @param string $sendemail
     * @return void
     */
    public function setSendEmail($sendemail)
    {
        $this->sendemail = $sendemail;
    }
}
