<?php
namespace DslFactory\DslProdukte\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * Highlights
 */
class Highlights extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Bezeichnung für die interne Verwendung
	 * 
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $titel = '';

	/**
	 * Auswahl der Produkte
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
		$this->produkte = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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

}