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
 * WartungsvertraegeZeitraeume
 */
class WartungsvertraegeZeitraeume extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * wartungsvertrag
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege
     */
    protected $wartungsvertrag;

    /**
     * von
     *
     * @var \DateTime
     */
    protected $von;

    /**
     * bis
     *
     * @var \DateTime
     */
    protected $bis;

    /**
     * status
     *
     * @var int
     */
    protected $status;

    /**
     * zeiten
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $zeiten;

    /**
     * rechnungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $rechnungen;

    /**
     * Returns the von
     *
     * @return \DateTime
     */
    public function getVon()
    {
        return $this->von;
    }

    /**
     * Sets the von
     *
     * @param \DateTime $von
     * @return void
     */
    public function setVon(\DateTime $von)
    {
        $this->von = $von;
    }

    /**
     * Returns the bis
     *
     * @return \DateTime
     */
    public function getBis()
    {
        return $this->bis;
    }

    /**
     * Sets the bis
     *
     * @param \DateTime $bis
     * @return void
     */
    public function setBis(\DateTime $bis)
    {
        $this->bis = $bis;
    }

    /**
     * Returns the status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
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
        $this->zeiten = $this->zeiten ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->rechnungen = $this->rechnungen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Zeiteintraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiten
     * @return void
     */
    public function addZeiten(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiten)
    {
        $this->zeiten->attach($zeiten);
    }

    /**
     * Removes a Zeiteintraege
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeitenToRemove The Zeiteintraege to be removed
     * @return void
     */
    public function removeZeiten(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeitenToRemove)
    {
        $this->zeiten->detach($zeitenToRemove);
    }

    /**
     * Returns the zeiten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege>
     */
    public function getZeiten()
    {
        return $this->zeiten;
    }

    /**
     * Sets the zeiten
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Zeiteintraege> $zeiten
     * @return void
     */
    public function setZeiten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zeiten)
    {
        $this->zeiten = $zeiten;
    }

    /**
     * Adds a WartungsvertraegeRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $rechnungen
     * @return void
     */
    public function addRechnungen(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $rechnungen)
    {
        $this->rechnungen->attach($rechnungen);
    }

    /**
     * Removes a WartungsvertraegeRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $rechnungenToRemove The WartungsvertraegeRechnungen to be removed
     * @return void
     */
    public function removeRechnungen(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $rechnungenToRemove)
    {
        $this->rechnungen->detach($rechnungenToRemove);
    }

    /**
     * Returns the rechnungen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen>
     */
    public function getRechnungen()
    {
        return $this->rechnungen;
    }

    /**
     * Sets the rechnungen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen> $rechnungen
     * @return void
     */
    public function setRechnungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rechnungen)
    {
        $this->rechnungen = $rechnungen;
    }

    /**
     * Returns the wartungsvertraege
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     * @return \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertrag
     */
    public function getWartungsvertrag()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $wartungsvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        if ($this->wartungsvertrag === NULL) {
            $this->wartungsvertrag = $wartungsvertraegeRepository->findByZeitraum($this);
        }
        return $this->wartungsvertrag;
    }
}
