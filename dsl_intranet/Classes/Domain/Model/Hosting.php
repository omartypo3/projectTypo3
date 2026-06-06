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
 * Hosting
 */
class Hosting extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * benutzername
     *
     * @var string
     */
    protected $benutzername;

    /**
     * kennwort
     *
     * @var string
     */
    protected $kennwort;

    /**
     * statistik
     *
     * @var string
     */
    protected $statistik;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * kunde
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    protected $kunde;

    /**
     * hauptTarif
     *
     * @var \DslFactory\DslIntranet\Domain\Model\HostingDomains
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $hauptTarif;

    /**
     * zusatzLeistungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $zusatzLeistungen;

    /**
     * zusatzTarif
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingDomains>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $zusatzTarif;

    /**
     * Returns the benutzername
     *
     * @return string
     */
    public function getBenutzername()
    {
        return $this->benutzername;
    }

    /**
     * Sets the benutzername
     *
     * @param string $benutzername
     * @return void
     */
    public function setBenutzername(string $benutzername)
    {
        $this->benutzername = $benutzername;
    }

    /**
     * Returns the kennwort
     *
     * @return string
     */
    public function getKennwort()
    {
        return $this->kennwort;
    }

    /**
     * Sets the kennwort
     *
     * @param string $kennwort
     * @return void
     */
    public function setKennwort(string $kennwort)
    {
        $this->kennwort = $kennwort;
    }

    /**
     * Returns the statistik
     *
     * @return string
     */
    public function getStatistik()
    {
        return $this->statistik;
    }

    /**
     * Sets the statistik
     *
     * @param string $statistik
     * @return void
     */
    public function setStatistik(string $statistik)
    {
        $this->statistik = $statistik;
    }

    /**
     * Returns the oldid
     *
     * @return int
     */
    public function getOldid()
    {
        return $this->oldid;
    }

    /**
     * Sets the oldid
     *
     * @param int $oldid
     * @return void
     */
    public function setOldid(int $oldid)
    {
        $this->oldid = $oldid;
    }

    /**
     * Returns the notiz
     *
     * @return string
     */
    public function getNotiz()
    {
        return $this->notiz;
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz(string $notiz)
    {
        $this->notiz = $notiz;
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
        $this->zusatzLeistungen = $this->zusatzLeistungen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->zusatzTarif = $this->zusatzTarif ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the kunde
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden
     */
    public function getKunde()
    {
        return $this->kunde;
    }

    /**
     * Sets the kunde
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Kunden $kunde
     * @return void
     */
    public function setKunde(\DslFactory\DslIntranet\Domain\Model\Kunden $kunde)
    {
        $this->kunde = $kunde;
    }

    /**
     * Returns the hauptTarif
     *
     * @return \DslFactory\DslIntranet\Domain\Model\HostingDomains
     */
    public function getHauptTarif()
    {
        return $this->hauptTarif;
    }

    /**
     * Sets the hauptTarif
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $hauptTarif
     * @return void
     */
    public function setHauptTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $hauptTarif)
    {
        $this->hauptTarif = $hauptTarif;
    }

    public function clearHauptTarif()
    {
        $this->hauptTarif = NULL;
    }
	

    /**
     * Adds a HostingZusatzleistungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $zusatzLeistungen
     * @return void
     */
    public function addZusatzLeistungen(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $zusatzLeistungen)
    {
        $this->zusatzLeistungen->attach($zusatzLeistungen);
    }

    /**
     * Removes a HostingZusatzleistungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $zusatzLeistungenToRemove The HostingZusatzleistungen to be removed
     * @return void
     */
    public function removeZusatzLeistungen(\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen $zusatzLeistungenToRemove)
    {
        $this->zusatzLeistungen->detach($zusatzLeistungenToRemove);
    }

    /**
     * Returns the zusatzLeistungen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen>
     */
    public function getZusatzLeistungen()
    {
        return $this->zusatzLeistungen;
    }

    /**
     * Sets the zusatzLeistungen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen> $zusatzLeistungen
     * @return void
     */
    public function setZusatzLeistungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zusatzLeistungen)
    {
        $this->zusatzLeistungen = $zusatzLeistungen;
    }
	
	/**
     * Adds a zusatzTarif
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarif
     * @return void
     */
    public function addZusatzTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarif)
    {
        $this->zusatzTarif->attach($zusatzTarif);
    }

    /**
     * Removes a zusatzTarif
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarifToRemove The HostingDomains to be removed
     * @return void
     */
    public function removeZusatzTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarifToRemove)
    {
        $this->zusatzTarif->detach($zusatzTarifToRemove);
    }

    /**
     * Returns the zusatzTarif
     *
     * @return \DslFactory\DslIntranet\Domain\Model\HostingDomains
     */
    public function getZusatzTarif()
    {
        return $this->zusatzTarif;
    }

    /**
     * Sets the zusatzTarif
     *
     * @param \DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarif
     * @return void
     */
    public function setZusatzTarif(\DslFactory\DslIntranet\Domain\Model\HostingDomains $zusatzTarif)
    {
        $this->zusatzTarif = $zusatzTarif;
    }
}
