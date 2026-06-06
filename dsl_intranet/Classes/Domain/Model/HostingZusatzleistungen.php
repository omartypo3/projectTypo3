<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * HostingZusatzleistungen
 */
class HostingZusatzleistungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * anzahl
     *
     * @var int
     */
    protected $anzahl;

    /**
     * sonderpreisMonatlich
     *
     * @var float
     */
    protected $sonderpreisMonatlich;

    /**
     * gekuendigt
     *
     * @var bool
     */
    protected $gekuendigt;

    /**
     * vertragsbegin
     *
     * @var \DateTime
     */
    protected $vertragsbegin;

    /**
     * bezahltbis
     *
     * @var \DateTime
     */
    protected $bezahltbis;

    /**
     * sonderlaufzeit
     *
     * @var int
     */
    protected $sonderlaufzeit;

    /**
     * zusatzleistung
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen
     */
    protected $zusatzleistung;

    /**
     * rechnungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $rechnungen;

    /**
     * Returns the anzahl
     *
     * @return int
     */
    public function getAnzahl()
    {
        return $this->anzahl;
    }

    /**
     * Sets the anzahl
     *
     * @param int $anzahl
     * @return void
     */
    public function setAnzahl(int $anzahl)
    {
        $this->anzahl = $anzahl;
    }

    /**
     * Returns the sonderpreisMonatlich
     *
     * @return float
     */
    public function getSonderpreisMonatlich()
    {
        return $this->sonderpreisMonatlich;
    }

    /**
     * Sets the sonderpreisMonatlich
     *
     * @param float $sonderpreisMonatlich
     * @return void
     */
    public function setSonderpreisMonatlich(float $sonderpreisMonatlich)
    {
        $this->sonderpreisMonatlich = $sonderpreisMonatlich;
    }

    /**
     * Returns the gekuendigt
     *
     * @return bool
     */
    public function getGekuendigt()
    {
        return $this->gekuendigt;
    }

    /**
     * Sets the gekuendigt
     *
     * @param bool $gekuendigt
     * @return void
     */
    public function setGekuendigt(bool $gekuendigt)
    {
        $this->gekuendigt = $gekuendigt;
    }

    /**
     * Returns the boolean state of gekuendigt
     *
     * @return bool
     */
    public function isGekuendigt()
    {
        return $this->gekuendigt;
    }

    /**
     * Returns the vertragsbegin
     *
     * @return \DateTime
     */
    public function getVertragsbegin()
    {
        return $this->vertragsbegin;
    }

    /**
     * Sets the vertragsbegin
     *
     * @param \DateTime $vertragsbegin
     * @return void
     */
    public function setVertragsbegin(\DateTime $vertragsbegin)
    {
        $this->vertragsbegin = $vertragsbegin;
    }

    /**
     * Returns the bezahltbis
     *
     * @return \DateTime
     */
    public function getBezahltbis()
    {
        return $this->bezahltbis;
    }

    /**
     * Sets the bezahltbis
     *
     * @param \DateTime $bezahltbis
     * @return void
     */
    public function setBezahltbis(\DateTime $bezahltbis)
    {
        $this->bezahltbis = $bezahltbis;
    }

    /**
     * Returns the sonderlaufzeit
     *
     * @return int
     */
    public function getSonderlaufzeit()
    {
        return $this->sonderlaufzeit;
    }

    /**
     * Sets the sonderlaufzeit
     *
     * @param int $sonderlaufzeit
     * @return void
     */
    public function setSonderlaufzeit(int $sonderlaufzeit)
    {
        $this->sonderlaufzeit = $sonderlaufzeit;
    }

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->rechnungen = $this->rechnungen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the zusatzleistung
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen
     */
    public function getZusatzleistung()
    {
        return $this->zusatzleistung;
    }

    /**
     * Sets the zusatzleistung
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistung
     * @return void
     */
    public function setZusatzleistung(\DslFactory\DslIntranet\Domain\Model\Zusatzleistungen $zusatzleistung)
    {
        $this->zusatzleistung = $zusatzleistung;
    }

    /**
     * Adds a HostingTarifRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungen
     * @return void
     */
    public function addRechnungen(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungen)
    {
        $this->rechnungen->attach($rechnungen);
    }

    /**
     * Removes a HostingTarifRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungenToRemove The HostingTarifRechnungen to be removed
     * @return void
     */
    public function removeRechnungen(\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen $rechnungenToRemove)
    {
        $this->rechnungen->detach($rechnungenToRemove);
    }

    /**
     * Returns the rechnungen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen>
     */
    public function getRechnungen()
    {
        return $this->rechnungen;
    }

    /**
     * Sets the rechnungen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen> $rechnungen
     * @return void
     */
    public function setRechnungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rechnungen)
    {
        $this->rechnungen = $rechnungen;
    }
}
