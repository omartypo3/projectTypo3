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
 * Kategorien
 */
class Kategorien extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Name der Kategorie
	 * 
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $titel = '';

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
	 * Sorting
	 * 
	 * @var int
	 */
	protected $sorting = '';

	/**
	 * Returns the titel
	 * 
	 * @return int $sorting
	 */
	public function getSorting() {
		return $this->sorting;
	}

}