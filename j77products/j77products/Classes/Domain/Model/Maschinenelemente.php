<?php
namespace J77\J77products\Domain\Model;

/***
 *
 * This file is part of the "Produkte" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * Maschinenelemente
 */
class Maschinenelemente extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * element
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * element
     *
     * @var int
     */
    protected $element = 0;

    /**
     * beschreibungstext
     *
     * @var string
     */
    protected $beschreibungstext = '';

    /**
     * bild
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $bild = null;

    /**
     * chargengroesse
     *
     * @var string
     */
    protected $chargengroesse = '';

    /**
     * dichtung
     *
     * @var string
     */
    protected $dichtung = '';

    /**
     * dispergierkammer
     *
     * @var string
     */
    protected $dispergierkammer = '';

    /**
     * drehzahl
     *
     * @var string
     */
    protected $drehzahl = '';

    /**
     * durchsatzfluessigkeit
     *
     * @var string
     */
    protected $durchsatzfluessigkeit = '';

    /**
     * einsaugleistungpulver
     *
     * @var string
     */
    protected $einsaugleistungpulver = '';

    /**
     * funktionsbild1
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $funktionsbild1 = null;

    /**
     * funktionsbild2
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $funktionsbild2 = null;

    /**
     * hauptbild
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $hauptbild = null;

    /**
     * icon
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $icon = null;

    /**
     * lagerflansch
     *
     * @var string
     */
    protected $lagerflansch = '';

    /**
     * leistung
     *
     * @var string
     */
    protected $leistung = '';

    /**
     * linkespalte
     *
     * @var string
     */
    protected $linkespalte = '';

    /**
     * maschinenvariante
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine>
     * @cascade remove
     */
    protected $maschinenvariante = '';

    /**
     * maximaleviskositaet
     *
     * @var string
     */
    protected $maximaleviskositaet = '';

    /**
     * optionen
     *
     * @var string
     */
    protected $optionen = '';

    /**
     * rechtespalte
     *
     * @var string
     */
    protected $rechtespalte = '';

    /**
     * schergeschwindigkeit
     *
     * @var string
     */
    protected $schergeschwindigkeit = '';

    /**
     * spannung
     *
     * @var string
     */
    protected $spannung = '';

    /**
     * tauchteil
     *
     * @var string
     */
    protected $tauchteil = '';

    /**
     * titel
     *
     * @var string
     */
    protected $titel = '';

    /**
     * umfangsgeschwindigkeit
     *
     * @var string
     */
    protected $umfangsgeschwindigkeit = '';

    /**
     * werkzeugschaft
     *
     * @var string
     */
    protected $werkzeugschaft = '';

    /**
     * ueberschrift
     *
     * @var string
     */
    protected $ueberschrift = '';

    /**
     * downloadrepeater
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Download>
     * @cascade remove
     */
    protected $downloadrepeater = null;

    /**
     * iconrepeater
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Icon>
     * @cascade remove
     */
    protected $iconrepeater = null;

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
        $this->downloadrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->iconrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * Returns the element
     *
     * @return int $element
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Sets the element
     *
     * @param int $element
     * @return void
     */
    public function setElement($element)
    {
        $this->element = $element;
    }

    /**
     * Returns the beschreibungstext
     *
     * @return string $beschreibungstext
     */
    public function getBeschreibungstext()
    {
        return $this->beschreibungstext;
    }

    /**
     * Sets the beschreibungstext
     *
     * @param string $beschreibungstext
     * @return void
     */
    public function setBeschreibungstext($beschreibungstext)
    {
        $this->beschreibungstext = $beschreibungstext;
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
     * Returns the chargengroesse
     *
     * @return string $chargengroesse
     */
    public function getChargengroesse()
    {
        return $this->chargengroesse;
    }

    /**
     * Sets the chargengroesse
     *
     * @param string $chargengroesse
     * @return void
     */
    public function setChargengroesse($chargengroesse)
    {
        $this->chargengroesse = $chargengroesse;
    }

    /**
     * Returns the dichtung
     *
     * @return string $dichtung
     */
    public function getDichtung()
    {
        return $this->dichtung;
    }

    /**
     * Sets the dichtung
     *
     * @param string $dichtung
     * @return void
     */
    public function setDichtung($dichtung)
    {
        $this->dichtung = $dichtung;
    }

    /**
     * Returns the dispergierkammer
     *
     * @return string $dispergierkammer
     */
    public function getDispergierkammer()
    {
        return $this->dispergierkammer;
    }

    /**
     * Sets the dispergierkammer
     *
     * @param string $dispergierkammer
     * @return void
     */
    public function setDispergierkammer($dispergierkammer)
    {
        $this->dispergierkammer = $dispergierkammer;
    }

    /**
     * Returns the drehzahl
     *
     * @return string $drehzahl
     */
    public function getDrehzahl()
    {
        return $this->drehzahl;
    }

    /**
     * Sets the drehzahl
     *
     * @param string $drehzahl
     * @return void
     */
    public function setDrehzahl($drehzahl)
    {
        $this->drehzahl = $drehzahl;
    }

    /**
     * Returns the durchsatzfluessigkeit
     *
     * @return string $durchsatzfluessigkeit
     */
    public function getDurchsatzfluessigkeit()
    {
        return $this->durchsatzfluessigkeit;
    }

    /**
     * Sets the durchsatzfluessigkeit
     *
     * @param string $durchsatzfluessigkeit
     * @return void
     */
    public function setDurchsatzfluessigkeit($durchsatzfluessigkeit)
    {
        $this->durchsatzfluessigkeit = $durchsatzfluessigkeit;
    }

    /**
     * Returns the einsaugleistungpulver
     *
     * @return string $einsaugleistungpulver
     */
    public function getEinsaugleistungpulver()
    {
        return $this->einsaugleistungpulver;
    }

    /**
     * Sets the einsaugleistungpulver
     *
     * @param string $einsaugleistungpulver
     * @return void
     */
    public function setEinsaugleistungpulver($einsaugleistungpulver)
    {
        $this->einsaugleistungpulver = $einsaugleistungpulver;
    }

    /**
     * Returns the funktionsbild1
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild1
     */
    public function getFunktionsbild1()
    {
        return $this->funktionsbild1;
    }

    /**
     * Sets the funktionsbild1
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild1
     * @return void
     */
    public function setFunktionsbild1(\TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild1)
    {
        $this->funktionsbild1 = $funktionsbild1;
    }

    /**
     * Returns the funktionsbild2
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild2
     */
    public function getFunktionsbild2()
    {
        return $this->funktionsbild2;
    }

    /**
     * Sets the funktionsbild2
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild2
     * @return void
     */
    public function setFunktionsbild2(\TYPO3\CMS\Extbase\Domain\Model\FileReference $funktionsbild2)
    {
        $this->funktionsbild2 = $funktionsbild2;
    }

    /**
     * Returns the hauptbild
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $hauptbild
     */
    public function getHauptbild()
    {
        return $this->hauptbild;
    }

    /**
     * Sets the hauptbild
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $hauptbild
     * @return void
     */
    public function setHauptbild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $hauptbild)
    {
        $this->hauptbild = $hauptbild;
    }

    /**
     * Returns the icon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     * @return void
     */
    public function setIcon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icon)
    {
        $this->icon = $icon;
    }

    /**
     * Returns the lagerflansch
     *
     * @return string $lagerflansch
     */
    public function getLagerflansch()
    {
        return $this->lagerflansch;
    }

    /**
     * Sets the lagerflansch
     *
     * @param string $lagerflansch
     * @return void
     */
    public function setLagerflansch($lagerflansch)
    {
        $this->lagerflansch = $lagerflansch;
    }

    /**
     * Returns the leistung
     *
     * @return string $leistung
     */
    public function getLeistung()
    {
        return $this->leistung;
    }

    /**
     * Sets the leistung
     *
     * @param string $leistung
     * @return void
     */
    public function setLeistung($leistung)
    {
        $this->leistung = $leistung;
    }

    /**
     * Returns the linkespalte
     *
     * @return string $linkespalte
     */
    public function getLinkespalte()
    {
        return $this->linkespalte;
    }

    /**
     * Sets the linkespalte
     *
     * @param string $linkespalte
     * @return void
     */
    public function setLinkespalte($linkespalte)
    {
        $this->linkespalte = $linkespalte;
    }

    /**
     * Adds a Maschine
     *
     * @param $maschinenvariante
     * @return void
     */
    public function addMaschinenvariante(\J77\J77products\Domain\Model\Maschine $maschinenvariante)
    {
        $this->maschinenvariante->attach($maschinenvariante);
    }

    /**
     * Removes a Maschine
     *
     * @param \J77\J77products\Domain\Model\Maschine $maschinenvarianteToRemove The Maschine to be removed
     * @return void
     */
    public function removeMaschinenvariante(\J77\J77products\Domain\Model\Maschine $maschinenvarianteToRemove)
    {
        $this->maschinenvariante->detach($iconrepeaterToRemove);
    }

    /**
     * Returns the maschinenvariante
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine> $maschinenvariante
     */
    public function getMaschinenvariante()
    {
        return $this->maschinenvariante;
    }

    /**
     * Sets the maschinenvariante
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine> $maschinenvariante
     * @return void
     */
    public function setMaschinenvariante(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $maschinenvariante)
    {
        $this->maschinenvariante = $maschinenvariante;
    }

    /**
     * Returns the maximaleviskositaet
     *
     * @return string $maximaleviskositaet
     */
    public function getMaximaleviskositaet()
    {
        return $this->maximaleviskositaet;
    }

    /**
     * Sets the maximaleviskositaet
     *
     * @param string $maximaleviskositaet
     * @return void
     */
    public function setMaximaleviskositaet($maximaleviskositaet)
    {
        $this->maximaleviskositaet = $maximaleviskositaet;
    }

    /**
     * Returns the optionen
     *
     * @return string $optionen
     */
    public function getOptionen()
    {
        return $this->optionen;
    }

    /**
     * Sets the optionen
     *
     * @param string $optionen
     * @return void
     */
    public function setOptionen($optionen)
    {
        $this->optionen = $optionen;
    }

    /**
     * Returns the rechtespalte
     *
     * @return string $rechtespalte
     */
    public function getRechtespalte()
    {
        return $this->rechtespalte;
    }

    /**
     * Sets the rechtespalte
     *
     * @param string $rechtespalte
     * @return void
     */
    public function setRechtespalte($rechtespalte)
    {
        $this->rechtespalte = $rechtespalte;
    }

    /**
     * Returns the schergeschwindigkeit
     *
     * @return string $schergeschwindigkeit
     */
    public function getSchergeschwindigkeit()
    {
        return $this->schergeschwindigkeit;
    }

    /**
     * Sets the schergeschwindigkeit
     *
     * @param string $schergeschwindigkeit
     * @return void
     */
    public function setSchergeschwindigkeit($schergeschwindigkeit)
    {
        $this->schergeschwindigkeit = $schergeschwindigkeit;
    }

    /**
     * Returns the spannung
     *
     * @return string $spannung
     */
    public function getSpannung()
    {
        return $this->spannung;
    }

    /**
     * Sets the spannung
     *
     * @param string $spannung
     * @return void
     */
    public function setSpannung($spannung)
    {
        $this->spannung = $spannung;
    }

    /**
     * Returns the tauchteil
     *
     * @return string $tauchteil
     */
    public function getTauchteil()
    {
        return $this->tauchteil;
    }

    /**
     * Sets the tauchteil
     *
     * @param string $tauchteil
     * @return void
     */
    public function setTauchteil($tauchteil)
    {
        $this->tauchteil = $tauchteil;
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
     * Returns the umfangsgeschwindigkeit
     *
     * @return string $umfangsgeschwindigkeit
     */
    public function getUmfangsgeschwindigkeit()
    {
        return $this->umfangsgeschwindigkeit;
    }

    /**
     * Sets the umfangsgeschwindigkeit
     *
     * @param string $umfangsgeschwindigkeit
     * @return void
     */
    public function setUmfangsgeschwindigkeit($umfangsgeschwindigkeit)
    {
        $this->umfangsgeschwindigkeit = $umfangsgeschwindigkeit;
    }

    /**
     * Returns the werkzeugschaft
     *
     * @return string $werkzeugschaft
     */
    public function getWerkzeugschaft()
    {
        return $this->werkzeugschaft;
    }

    /**
     * Sets the werkzeugschaft
     *
     * @param string $werkzeugschaft
     * @return void
     */
    public function setWerkzeugschaft($werkzeugschaft)
    {
        $this->werkzeugschaft = $werkzeugschaft;
    }

    /**
     * Returns the ueberschrift
     *
     * @return string $ueberschrift
     */
    public function getUeberschrift()
    {
        return $this->ueberschrift;
    }

    /**
     * Sets the ueberschrift
     *
     * @param string $ueberschrift
     * @return void
     */
    public function setUeberschrift($ueberschrift)
    {
        $this->ueberschrift = $ueberschrift;
    }

    /**
     * Adds a Download
     *
     * @param \J77\J77products\Domain\Model\Download $downloadrepeater
     * @return void
     */
    public function addDownloadrepeater(\J77\J77products\Domain\Model\Download $downloadrepeater)
    {
        $this->downloadrepeater->attach($downloadrepeater);
    }

    /**
     * Removes a Download
     *
     * @param \J77\J77products\Domain\Model\Download $downloadrepeaterToRemove The Download to be removed
     * @return void
     */
    public function removeDownloadrepeater(\J77\J77products\Domain\Model\Download $downloadrepeaterToRemove)
    {
        $this->downloadrepeater->detach($downloadrepeaterToRemove);
    }

    /**
     * Returns the downloadrepeater
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Download> $downloadrepeater
     */
    public function getDownloadrepeater()
    {
        return $this->downloadrepeater;
    }

    /**
     * Sets the downloadrepeater
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Download> $downloadrepeater
     * @return void
     */
    public function setDownloadrepeater(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $downloadrepeater)
    {
        $this->downloadrepeater = $downloadrepeater;
    }

    /**
     * Adds a Icon
     *
     * @param \J77\J77products\Domain\Model\Icon $iconrepeater
     * @return void
     */
    public function addIconrepeater(\J77\J77products\Domain\Model\Icon $iconrepeater)
    {
        $this->iconrepeater->attach($iconrepeater);
    }

    /**
     * Removes a Icon
     *
     * @param \J77\J77products\Domain\Model\Icon $iconrepeaterToRemove The Icon to be removed
     * @return void
     */
    public function removeIconrepeater(\J77\J77products\Domain\Model\Icon $iconrepeaterToRemove)
    {
        $this->iconrepeater->detach($iconrepeaterToRemove);
    }

    /**
     * Returns the iconrepeater
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Icon> $iconrepeater
     */
    public function getIconrepeater()
    {
        return $this->iconrepeater;
    }

    /**
     * Sets the iconrepeater
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Icon> $iconrepeater
     * @return void
     */
    public function setIconrepeater(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $iconrepeater)
    {
        $this->iconrepeater = $iconrepeater;
    }
}
