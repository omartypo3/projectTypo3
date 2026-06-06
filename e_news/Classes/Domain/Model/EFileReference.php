<?php
namespace Emagineurs\ENews\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Xavier Ley <xley@e-maginuers.com>, e-magineurs
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
 * Enews
 */
 
class EFileReference extends \GeorgRinger\News\Domain\Model\FileReference {

	/**
	 * copyright
	 *
	 * @var string
	 */
	protected $copyright;

	/**
	 * hauteur
	 *
	 * @var string
	 */
	protected $hauteur = '';

	/**
	 * largeur
	 *
	 * @var string
	 */
	protected $largeur = '';
      
    
	/**
	 * Returns the copyright
	 *
	 * @return string $copyright
	 */
	public function getCopyright() {
		return $this->copyright !== NULL ? $this->copyright : $this->getOriginalResource()->getCopyright();
	}

	/**
	 * Sets the copyright
	 *
	 * @param string $copyright
	 * @return void
	 */
	public function setCopyright($copyright) {
		$this->copyright = $copyright;
	}

	/**
	 * Returns the hauteur
	 *
	 * @return string $hauteur
	 */
	public function getHauteur() {
		return $this->hauteur;
	}

	/**
	 * Sets the hauteur
	 *
	 * @param string $hauteur
	 * @return void
	 */
	public function setHauteur($hauteur) {
		$this->hauteur = $hauteur;
	}

	/**
	 * Returns the largeur
	 *
	 * @return string $largeur
	 */
	public function getLargeur() {
		return $this->largeur;
	}

	/**
	 * Sets the largeur
	 *
	 * @param string $largeur
	 * @return void
	 */
	public function setLargeur($largeur) {
		$this->largeur = $largeur;
	}
}