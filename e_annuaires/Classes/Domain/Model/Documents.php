<?php
namespace Emagineurs\EAnnuaires\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
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

if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Documents'])) {
	foreach($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Documents'] as $currentPathToAdditionalModel) {
		if (file_exists($currentPathToAdditionalModel)) {
			require_once($currentPathToAdditionalModel);
		}
	}
}

/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Documents extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	// Traits to allow third party extension to add element to the model
    use Traits\DocumentsExtended;
	
	/**
	 * fichier
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference>
	 */
	protected $fichier;
	
	/**
	 * fichier
	 *
	 * @var string
	 */
	protected $typedisplay;

	/**
	 * __construct
	 *
	 * @return Fiche
	 */
	public function __construct() {
		$conf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] ?? [];
		$this->typeDisplayArray = explode(',', $conf['typedisplay'] ?? '');
	}

	/**
	 * Returns the fichier
	 *
	 * @return TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $fichier
	 */
	public function getFichier() {
		return $this->fichier;
	}

	/**
	 * Sets the fichier
	 *
	 * @param TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $fichier
	 * @return void
	 */
	public function setFichier(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fichier) {
		$this->fichier = $fichier;
	}

	/**
	 * Returns the fichier
	 *
	 * @return string $typedisplay
	 */
	public function getTypedisplay() {
		return $this->typeDisplayArray[$this->typedisplay];
	}

	/**
	 * Sets the typedisplay
	 *
	 * @param string $typedisplay
	 * @return void
	 */
	public function setTypedisplay($typedisplay) {
		$this->typedisplay = $typedisplay;
	}

}
?>