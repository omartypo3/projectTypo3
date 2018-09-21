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
 * Anlagenelemente
 */
class Anlagenelemente extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * anlagen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Prozessanlage>
     */
    protected $anlagen = null;

    /**
     * maschinerel
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine>
     */
    protected $maschinerel = null;

    /**
     * ansatzgroesse
     *
     * @var string
     */
    protected $ansatzgroesse = '';

    /**
     * anwendungsbereich
     *
     * @var string
     */
    protected $anwendungsbereich = '';

    /**
     * automatisierungsgrad
     *
     * @var string
     */
    protected $automatisierungsgrad = '';

    /**
     * autor
     *
     * @var string
     */
    protected $autor = '';

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
     * branche
     *
     * @var string
     */
    protected $branche = '';

    /**
     * branchenicon
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $branchenicon = null;

    /**
     * endprodukte
     *
     * @var string
     */
    protected $endprodukte = '';

    /**
     * fuellstoffanteil
     *
     * @var string
     */
    protected $fuellstoffanteil = '';

    /**
     * kapazitaet
     *
     * @var string
     */
    protected $kapazitaet = '';

    /**
     * linkespalte
     *
     * @var string
     */
    protected $linkespalte = '';

    /**
     * platzbedarf
     *
     * @var string
     */
    protected $platzbedarf = '';

    /**
     * portraitbild
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $portraitbild = null;

    /**
     * pulverzufuehrung
     *
     * @var string
     */
    protected $pulverzufuehrung = '';

    /**
     * rechtespalte
     *
     * @var string
     */
    protected $rechtespalte = '';

    /**
     * reinigungsfaehigkeit
     *
     * @var string
     */
    protected $reinigungsfaehigkeit = '';

    /**
     * zitat
     *
     * @var string
     */
    protected $zitat = '';

    /**
     * ueberschrift
     *
     * @var string
     */
    protected $ueberschrift = '';

    /**
     * weitereanforderungrepeater
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\WeitereAnforderungen>
     * @cascade remove
     */
    protected $weitereanforderungrepeater = null;

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
        $this->weitereanforderungrepeater = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the anlagen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Prozessanlage> $anlagen
     * @return $anlagen
     */
    public function getAnlagen()
    {
        return $this->anlagen;
    }

    /**
     * Sets the anlagen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Prozessanlage> $anlagen
     * @return void
     */
    public function setAnlagen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $anlagen)
    {
        $this->anlagen = $anlagen;
    }

    /**
     * Returns the maschinerel
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine> $maschinerel
     * @return $maschinerel
     */
    public function getMaschinerel()
    {
        return $this->maschinerel;
    }

    /**
     * Sets the maschinerel
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschine> $maschinerel
     * @return void
     */
    public function setMaschinerel(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $anlagen)
    {
        $this->maschinerel = $maschinerel;
    }

    /**
     * Returns the ansatzgroesse
     *
     * @return string $ansatzgroesse
     */
    public function getAnsatzgroesse()
    {
        return $this->ansatzgroesse;
    }

    /**
     * Sets the ansatzgroesse
     *
     * @param string $ansatzgroesse
     * @return void
     */
    public function setAnsatzgroesse($ansatzgroesse)
    {
        $this->ansatzgroesse = $ansatzgroesse;
    }

    /**
     * Returns the anwendungsbereich
     *
     * @return string $anwendungsbereich
     */
    public function getAnwendungsbereich()
    {
        return $this->anwendungsbereich;
    }

    /**
     * Sets the anwendungsbereich
     *
     * @param string $anwendungsbereich
     * @return void
     */
    public function setAnwendungsbereich($anwendungsbereich)
    {
        $this->anwendungsbereich = $anwendungsbereich;
    }

    /**
     * Returns the automatisierungsgrad
     *
     * @return string $automatisierungsgrad
     */
    public function getAutomatisierungsgrad()
    {
        return $this->automatisierungsgrad;
    }

    /**
     * Sets the automatisierungsgrad
     *
     * @param string $automatisierungsgrad
     * @return void
     */
    public function setAutomatisierungsgrad($automatisierungsgrad)
    {
        $this->automatisierungsgrad = $automatisierungsgrad;
    }

    /**
     * Returns the autor
     *
     * @return string $autor
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Sets the autor
     *
     * @param string $autor
     * @return void
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
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
     * Returns the branche
     *
     * @return string $branche
     */
    public function getBranche()
    {
        return $this->branche;
    }

    /**
     * Sets the branche
     *
     * @param string $branche
     * @return void
     */
    public function setBranche($branche)
    {
        $this->branche = $branche;
    }

    /**
     * Returns the branchenicon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $branchenicon
     */
    public function getBranchenicon()
    {
        return $this->branchenicon;
    }

    /**
     * Sets the branchenicon
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $branchenicon
     * @return void
     */
    public function setBranchenicon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $branchenicon)
    {
        $this->branchenicon = $branchenicon;
    }

    /**
     * Returns the endprodukte
     *
     * @return string $endprodukte
     */
    public function getEndprodukte()
    {
        return $this->endprodukte;
    }

    /**
     * Sets the endprodukte
     *
     * @param string $endprodukte
     * @return void
     */
    public function setEndprodukte($endprodukte)
    {
        $this->endprodukte = $endprodukte;
    }

    /**
     * Returns the fuellstoffanteil
     *
     * @return string $fuellstoffanteil
     */
    public function getFuellstoffanteil()
    {
        return $this->fuellstoffanteil;
    }

    /**
     * Sets the fuellstoffanteil
     *
     * @param string $fuellstoffanteil
     * @return void
     */
    public function setFuellstoffanteil($fuellstoffanteil)
    {
        $this->fuellstoffanteil = $fuellstoffanteil;
    }

    /**
     * Returns the kapazitaet
     *
     * @return string $kapazitaet
     */
    public function getKapazitaet()
    {
        return $this->kapazitaet;
    }

    /**
     * Sets the kapazitaet
     *
     * @param string $kapazitaet
     * @return void
     */
    public function setKapazitaet($kapazitaet)
    {
        $this->kapazitaet = $kapazitaet;
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
     * Returns the platzbedarf
     *
     * @return string $platzbedarf
     */
    public function getPlatzbedarf()
    {
        return $this->platzbedarf;
    }

    /**
     * Sets the platzbedarf
     *
     * @param string $platzbedarf
     * @return void
     */
    public function setPlatzbedarf($platzbedarf)
    {
        $this->platzbedarf = $platzbedarf;
    }

    /**
     * Returns the portraitbild
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $portraitbild
     */
    public function getPortraitbild()
    {
        return $this->portraitbild;
    }

    /**
     * Sets the portraitbild
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $portraitbild
     * @return void
     */
    public function setPortraitbild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $portraitbild)
    {
        $this->portraitbild = $portraitbild;
    }

    /**
     * Returns the pulverzufuehrung
     *
     * @return string $pulverzufuehrung
     */
    public function getPulverzufuehrung()
    {
        return $this->pulverzufuehrung;
    }

    /**
     * Sets the pulverzufuehrung
     *
     * @param string $pulverzufuehrung
     * @return void
     */
    public function setPulverzufuehrung($pulverzufuehrung)
    {
        $this->pulverzufuehrung = $pulverzufuehrung;
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
     * Returns the reinigungsfaehigkeit
     *
     * @return string $reinigungsfaehigkeit
     */
    public function getReinigungsfaehigkeit()
    {
        return $this->reinigungsfaehigkeit;
    }

    /**
     * Sets the reinigungsfaehigkeit
     *
     * @param string $reinigungsfaehigkeit
     * @return void
     */
    public function setReinigungsfaehigkeit($reinigungsfaehigkeit)
    {
        $this->reinigungsfaehigkeit = $reinigungsfaehigkeit;
    }

    /**
     * Returns the zitat
     *
     * @return string $zitat
     */
    public function getZitat()
    {
        return $this->zitat;
    }

    /**
     * Sets the zitat
     *
     * @param string $zitat
     * @return void
     */
    public function setZitat($zitat)
    {
        $this->zitat = $zitat;
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
     * Adds a WeitereAnforderungen
     *
     * @param \J77\J77products\Domain\Model\WeitereAnforderungen $weitereanforderungrepeater
     * @return void
     */
    public function addWeitereanforderungrepeater(\J77\J77products\Domain\Model\WeitereAnforderungen $weitereanforderungrepeater)
    {
        $this->weitereanforderungrepeater->attach($weitereanforderungrepeater);
    }

    /**
     * Removes a WeitereAnforderungen
     *
     * @param \J77\J77products\Domain\Model\WeitereAnforderungen $weitereanforderungrepeaterToRemove The WeitereAnforderungen to be removed
     * @return void
     */
    public function removeWeitereanforderungrepeater(\J77\J77products\Domain\Model\WeitereAnforderungen $weitereanforderungrepeaterToRemove)
    {
        $this->weitereanforderungrepeater->detach($weitereanforderungrepeaterToRemove);
    }

    /**
     * Returns the weitereanforderungrepeater
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\WeitereAnforderungen> $weitereanforderungrepeater
     */
    public function getWeitereanforderungrepeater()
    {
        return $this->weitereanforderungrepeater;
    }

    /**
     * Sets the weitereanforderungrepeater
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\WeitereAnforderungen> $weitereanforderungrepeater
     * @return void
     */
    public function setWeitereanforderungrepeater(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $weitereanforderungrepeater)
    {
        $this->weitereanforderungrepeater = $weitereanforderungrepeater;
    }
}
