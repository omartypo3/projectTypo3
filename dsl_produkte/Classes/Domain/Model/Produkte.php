<?php
namespace DslFactory\DslProdukte\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Produkte
 */
class Produkte extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {




	/**
	 * @var integer
	 */
	protected $l10nParent;


	/**
	 * Status ob Artikel versteckt ist
	 * 
	 * @var int
	 */
	protected $hidden = 0;
	
	
	/**
	 * Timestamp
	 * 
	 * @var int
	 */
	protected $tstamp = '';

	/**
	 * Starttime
	 * 
	 * @var int
	 */
	protected $starttime = '';

	/**
	 * Crdate
	 * 
	 * @var int
	 */
	protected $crdate = '';
	
	/**
	 * sorting
	 * 
	 * @var string $sorting
	 */
	protected $sorting = NULL;

	/**
	 * Alias für Suchmaschinen
	 * 
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $alias = '';

	
	/**
	 * Produkttitel
	 * 
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $titel = '';

	/**
	 * Produktpreis Netto in EUR / ohne Preis -> Preis auf Anfrage
	 * 
	 * @var float
	 */
	protected $preis = 0.0;

	/**
	 * Kurzbeschreibung
	 * 
	 * @var string
	 */
	protected $teaser = '';

	/**
	 * Produktbeschreibung / Ausstattung
	 * 
	 * @var string
	 */
	protected $text = '';

	/**
	 * Technische Daten
	 * 
	 * @var string
	 */
	protected $technischedaten = '';

	/**
	 * Keywords für Suchmaschinen
	 * 
	 * @var string
	 */
	protected $keywords = '';

	/**
	 * bilder
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $bilder = NULL;

	/**
	 * Anlagen wie z.B. Datenblätter
	 * 
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $anlage = NULL;

	/**
	 * Auswahl der Anwendungsbereiche
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $anwendungsbereiche = NULL;
	
	/**
	 * Auswahl der Eigenschaften
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Eigenschaften>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $eigenschaften = NULL;

	/**
	 * Mögliche Zubehörprodukte
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Zubehoer>
	 */
	protected $zubehoer = NULL;

	/**
	 * Auswahl der Kategorien
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Kategorien>
	 */
	protected $kategorien = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
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
	protected function initStorageObjects() {
		$this->bilder = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->anwendungsbereiche = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->eigenschaften = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->zubehoer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->kategorien = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the Hidden
	 * 
	 * @return int $hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}
	
	/**
	 * Returns the L10n_parent
	 * 
	 * @return int $l10n_parent
	 */
	public function getLangParent() {
		return $this->l10n_parent;
	}


	/**
	 * Returns the Tstamp
	 * 
	 * @return int $tstamp
	 */
	public function getTstamp() {
		return $this->tstamp;
	}


	/**
	 * Returns the Crdate
	 * 
	 * @return int $crdate
	 */
	public function getCrdate() {
		return $this->crdate;
	}


	
	/**
	 * Returns the Starttime
	 * 
	 * @return int $starttime
	 */
	public function getStarttime() {
		return $this->starttime;
	}
	
	/**
	 * Sets the Starttime
	 * 
	 * @param string $int
	 * @return void
	 */
	public function setStarttime($starttime) {
		$this->starttime = $starttime;
	}		
	
		
	/**
	 * Returns the alias
	 * 
	 * @return string $alias
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * Sets the alias
	 * 
	 * @param string $alias
	 * @return void
	 */
	public function setAlias($alias) {
		$this->alias = $alias;
	}

	



	/**
	 * Returns the titel
	 * 
	 * @return string $titel
	 */
	public function getTitel() {
		return $this->titel;
	}

	/**
	 * Sets the titel
	 * 
	 * @param string $titel
	 * @return void
	 */
	public function setTitel($titel) {
		$this->titel = $titel;
	}

	/**
	 * Returns the preis
	 * 
	 * @return float $preis
	 */
	public function getPreis() {
		return $this->preis;
	}

	/**
	 * Sets the preis
	 * 
	 * @param float $preis
	 * @return void
	 */
	public function setPreis($preis) {
		$this->preis = $preis;
	}

	/**
	 * Returns the teaser
	 * 
	 * @return string $teaser
	 */
	public function getTeaser() {
		return $this->teaser;
	}

	/**
	 * Sets the teaser
	 * 
	 * @param string $teaser
	 * @return void
	 */
	public function setTeaser($teaser) {
		$this->teaser = $teaser;
	}

	/**
	 * Returns the keywords
	 * 
	 * @return string $keywords
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * Sets the keywords
	 * 
	 * @param string $keywords
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Adds a FileReference
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder
	 * @return void
	 */
	public function addBilder(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder) {
		$this->bilder->attach($bilder);
	}

	/**
	 * Removes a FileReference
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilderToRemove The FileReference to be removed
	 * @return void
	 */
	public function removeBilder(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bilderToRemove) {
		$this->bilder->detach($bilderToRemove);
	}

	/**
	 * Returns the bilder
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $bilder
	 */
	public function getBilder() {
		return $this->bilder;
	}

	/**
	 * Sets the bilder
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $bilder
	 * @return void
	 */
	public function setBilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $bilder) {
		$this->bilder = $bilder;
	}

	/**
	 * Returns the anlage
	 * 
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $anlage
	 */
	public function getAnlage() {
		return $this->anlage;
	}

	/**
	 * Sets the anlage
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $anlage
	 * @return void
	 */
	public function setAnlage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $anlage) {
		$this->anlage = $anlage;
	}

	/**
	 * Returns the text
	 * 
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets the text
	 * 
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * Returns the technischedaten
	 * 
	 * @return string $technischedaten
	 */
	public function getTechnischedaten() {
		
		if($this->technischedaten) return explode("\n",$this->technischedaten);

		return false;
	}

	/**
	 * Sets the technischedaten
	 * 
	 * @param string $technischedaten
	 * @return void
	 */
	public function setTechnischedaten($technischedaten) {
		$this->technischedaten = $technischedaten;
	}

	/**
	 * Adds a Anwendungsbereiche
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche $anwendungsbereiche
	 * @return void
	 */
	public function addAnwendungsbereiche(\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche $anwendungsbereiche) {
		$this->anwendungsbereiche->attach($anwendungsbereiche);
	}
	
	

	/**
	 * Removes a Anwendungsbereiche
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche $anwendungsbereicheToRemove The Anwendungsbereiche to be removed
	 * @return void
	 */
	public function removeAnwendungsbereiche(\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche $anwendungsbereicheToRemove) {
		$this->anwendungsbereiche->detach($anwendungsbereicheToRemove);
	}

	/**
	 * Returns the anwendungsbereiche
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche> $anwendungsbereiche
	 */
	public function getAnwendungsbereiche() {
		return $this->anwendungsbereiche;
	}

	/**
	 * Sets the anwendungsbereiche
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche> $anwendungsbereiche
	 * @return void
	 */
	public function setAnwendungsbereiche(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $anwendungsbereiche) {
		$this->anwendungsbereiche = $anwendungsbereiche;
	}
	
	


	/**
	 * Adds a Eigenschaften
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Eigenschaften $eigenschaften
	 * @return void
	 */
	public function addEigenschaften(\DslFactory\DslProdukte\Domain\Model\Eigenschaften $eigenschaften) {
		$this->eigenschaften->attach($eigenschaften);
	}
	
	

	/**
	 * Removes a Eigenschaft
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Eigenschaften $eigenschaftenToRemove The Eigenschaften to be removed
	 * @return void
	 */
	public function removeEigenschaften(\DslFactory\DslProdukte\Domain\Model\Eigenschaften $eigenschaftenToRemove) {
		$this->eigenschaften->detach($eigenschaftenToRemove);
	}

	/**
	 * Returns the Eigenschaften
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Eigenschaften> $eigenschaften
	 */
	public function getEigenschaften() {
		return $this->eigenschaften;
	}

	/**
	 * Sets the Eigenschaften
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Eigenschaften> $eigenschaften
	 * @return void
	 */
	public function setEigenschaften(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eigenschaften) {
		$this->eigenschaften = $eigenschaften;
	}
	

	/**
	 * Adds a Zubehoer
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer
	 * @return void
	 */
	public function addZubehoer(\DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer) {
		$this->zubehoer->attach($zubehoer);
	}

	/**
	 * Removes a Zubehoer
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoerToRemove The Zubehoer to be removed
	 * @return void
	 */
	public function removeZubehoer(\DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoerToRemove) {
		$this->zubehoer->detach($zubehoerToRemove);
	}

	/**
	 * Returns the zubehoer
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Zubehoer> $zubehoer
	 */
	public function getZubehoer() {
		return $this->zubehoer;
	}

	/**
	 * Sets the zubehoer
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Zubehoer> $zubehoer
	 * @return void
	 */
	public function setZubehoer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zubehoer) {
		$this->zubehoer = $zubehoer;
	}

	/**
	 * Adds a Kategorien
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Kategorien $kategorien
	 * @return void
	 */
	public function addKategorien(\DslFactory\DslProdukte\Domain\Model\Kategorien $kategorien) {
		$this->kategorien->attach($kategorien);
	}

	/**
	 * Removes a Kategorien
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Kategorien $kategorienToRemove The Kategorien to be removed
	 * @return void
	 */
	public function removeKategorien(\DslFactory\DslProdukte\Domain\Model\Kategorien $kategorienToRemove) {
		$this->kategorien->detach($kategorienToRemove);
	}

	/**
	 * Returns the kategorien
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Kategorien> $kategorien
	 */
	public function getKategorien() {
		return $this->kategorien;
	}

	/**
	 * Sets the kategorien
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Kategorien> $kategorien
	 * @return void
	 */
	public function setKategorien(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $kategorien) {
		$this->kategorien = $kategorien;
	}

	/**
	 * Returns the kategorien
	 * 
	 * @return string
	 */
	public function getProduktart() {
		return 'produkt';
	}

	/**
	 * Getter for sorting
	 * 
	 * @return string sorting
	 */
	public function getSorting() {
		return $this->sorting;
	}


	/**
	 * Set sys language
	 *
	 * @param int $sysLanguageUid
	 * @return void
	 */
	public function setSysLanguageUid($sysLanguageUid) {
		$this->_languageUid = $sysLanguageUid;
	}

	/**
	 * Get sys language
	 *
	 * @return int
	 */
	public function getSysLanguageUid() {
		return $this->_languageUid;
	}

	/**
	 * Set l10n parent
	 *
	 * @param int $l10nParent
	 * @return void
	 */
	public function setL10nParent($l10nParent) {
		$this->l10nParent = $l10nParent;
	}

	/**
	 * Get l10n parent
	 *
	 * @return int
	 */
	public function getL10nParent() {
		return $this->l10nParent;
	}

	/**
	 * Get localized uid
	 *
	 * @return int
	 */
	public function getLocalizedUid() {
		return $this->_localizedUid;
	}

}