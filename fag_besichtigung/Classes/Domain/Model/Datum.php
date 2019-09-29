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
 * Datum
 */
class Datum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * date
     * 
     * @var \DateTime
     */
    protected $date = null;

    /**
     * startTime
     * 
     * @var int
     */
    protected $startTime = 0;

    /**
     * endTime
     * 
     * @var int
     */
    protected $endTime = 0;

    /**
     * status
     * 
     * @var string
     */
    protected $status = '';

    /**
     * teilnehmerMax
     * 
     * @var int
     */
    protected $teilnehmerMax = 0;

    /**
     * anfrage
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Anfrage>
     * @cascade remove
     */
    protected $anfrage = null;

    /**
     * gruppenFuhrer
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer
     */
    protected $gruppenFuhrer = null;

    /**
     * gruppentyp
     * 
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp
     */
    protected $gruppentyp = null;

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
        $this->anfrage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the startTime
     * 
     * @return int $startTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Sets the startTime
     * 
     * @param int $startTime
     * @return void
     */
    public function setStartTime(int $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * Returns the endTime
     * 
     * @return int $endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Sets the endTime
     * 
     * @param int $endTime
     * @return void
     */
    public function setEndTime(int $endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * Returns the status
     * 
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     * 
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the teilnehmerMax
     * 
     * @return int $teilnehmerMax
     */
    public function getTeilnehmerMax()
    {
        return $this->teilnehmerMax;
    }

    /**
     * Sets the teilnehmerMax
     * 
     * @param int $teilnehmerMax
     * @return void
     */
    public function setTeilnehmerMax($teilnehmerMax)
    {
        $this->teilnehmerMax = $teilnehmerMax;
    }

    /**
     * Adds a Anfrage
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage
     * @return void
     */
    public function addAnfrage(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrage)
    {
        $this->anfrage->attach($anfrage);
    }

    /**
     * Removes a Anfrage
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrageToRemove The Anfrage to be removed
     * @return void
     */
    public function removeAnfrage(\FRONTAL\FagBesichtigung\Domain\Model\Anfrage $anfrageToRemove)
    {
        $this->anfrage->detach($anfrageToRemove);
    }

    /**
     * Returns the anfrage
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Anfrage> $anfrage
     */
    public function getAnfrage()
    {
        return $this->anfrage;
    }

    /**
     * Sets the anfrage
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagBesichtigung\Domain\Model\Anfrage> $anfrage
     * @return void
     */
    public function setAnfrage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $anfrage)
    {
        $this->anfrage = $anfrage;
    }

    /**
     * Returns the gruppenFuhrer
     * 
     * @return \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     */
    public function getGruppenFuhrer()
    {
        return $this->gruppenFuhrer;
    }

    /**
     * Sets the gruppenFuhrer
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer
     * @return void
     */
    public function setGruppenFuhrer(\FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer $gruppenFuhrer)
    {
        $this->gruppenFuhrer = $gruppenFuhrer;
    }

    /**
     * Returns the gruppentyp
     * 
     * @return \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     */
    public function getGruppentyp()
    {
        return $this->gruppentyp;
    }

    /**
     * Sets the gruppentyp
     * 
     * @param \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp
     * @return void
     */
    public function setGruppentyp(\FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp $gruppentyp)
    {
        $this->gruppentyp = $gruppentyp;
    }

}
