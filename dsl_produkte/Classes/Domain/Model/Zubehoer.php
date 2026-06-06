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
 * Zubehoer
 */
class Zubehoer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


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
	 * Auswahl der Anwendungsbereiche
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
	 */
	protected $anwendungsbereiche = NULL;

	/**
	 * Auswahl der Kategorien
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Kategorien>
	 */
	protected $kategorien = NULL;

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
	 * Artikelnummer
	 * 
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $artikelnummer = '';

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
	 * Verknüpfte Produkte für welche dieses Zubehör Teil geeignet ist
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Produkte>
	 */
	protected $produkte = NULL;

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
		$this->produkte = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the artikelnummer
	 * 
	 * @return string $artikelnummer
	 */
	public function getArtikelnummer() {
		return $this->artikelnummer;
	}

	/**
	 * Sets the artikelnummer
	 * 
	 * @param string $artikelnummer
	 * @return void
	 */
	public function setArtikelnummer($artikelnummer) {
		$this->artikelnummer = $artikelnummer;
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
	 * Adds a Produkte
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Produkte $produkte
	 * @return void
	 */
	public function addProdukte(\DslFactory\DslProdukte\Domain\Model\Produkte $produkte) {
		$this->produkte->attach($produkte);
	}

	/**
	 * Removes a Produkte
	 * 
	 * @param \DslFactory\DslProdukte\Domain\Model\Produkte $produkteToRemove The Produkte to be removed
	 * @return void
	 */
	public function removeProdukte(\DslFactory\DslProdukte\Domain\Model\Produkte $produkteToRemove) {
		$this->produkte->detach($produkteToRemove);
	}

	/**
	 * Returns the produkte
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Produkte> $produkte
	 */
	public function getProdukte() {
		return $this->produkte;
	}

	/**
	 * Sets the produkte
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Produkte> $produkte
	 * @return void
	 */
	public function setProdukte(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $produkte) {
		$this->produkte = $produkte;
	}

	/**
	 * Returns the anwendungsbereiche
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Anwendungsbereiche> $anwendungsbereiche
	 */
	public function getAnwendungsbereiche() {
		$resArr = array();
		foreach ($this->getProdukte() as $produkt) {
			foreach ($produkt->getAnwendungsbereiche() as $k => $anwendungsbereich) {
				if (!$resArr[$k]) {
					$resArr[$k] = $anwendungsbereich;
				}
			}
		}
		$this->anwendungsbereiche = $resArr;
		return $this->anwendungsbereiche;
	}

	/**
	 * Returns the kategorien
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslProdukte\Domain\Model\Kategorien> $kategorien
	 */
	public function getKategorien() {
		$resArr = array();
		foreach ($this->getProdukte() as $produkt) {
			foreach ($produkt->getKategorien() as $k => $kategorie) {
				if (!$resArr[$k]) {
					$resArr[$k] = $kategorie;
				}
			}
		}
		$this->kategorien = $resArr;
		return $this->kategorien;
	}

	/**
	 * Returns the kategorien
	 * 
	 * @return string
	 */
	public function getProduktart() {
		return 'zubehoer';
	}

	/**
	 * Getter for sorting
	 * 
	 * @return string sorting
	 */
	public function getSorting() {
		return $this->sorting + 10000000;
	}

}