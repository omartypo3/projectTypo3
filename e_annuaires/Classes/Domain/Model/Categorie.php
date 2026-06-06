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

if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Categorie'])) {
	foreach($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Categorie'] as $currentPathToAdditionalModel) {
		if (file_exists($currentPathToAdditionalModel)) {
			require_once($currentPathToAdditionalModel);
		}
	}
}

use TYPO3\CMS\Extbase\Domain\Model\Category;

/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

class Categorie extends Category {

	// Traits to allow third party extension to add element to the model
    use Traits\CategorieExtended;

	/**
	 * parentcategory
	 *
	 * @var \Emagineurs\EAnnuaires\Domain\Model\Categorie
	 */
	protected $parentcategory;
    
	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $images;
    
	/**
	 * Returns the parentcategory
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Categorie $parentcategory
	 */
	public function getParentcategory() {
		return $this->parentcategory;
	}

	/**
	 * Sets the parentcategory
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Categorie $parentcategory
	 * @return void
	 */
	public function setParentcategory(\Emagineurs\EAnnuaires\Domain\Model\Categorie $parentcategory) {
		$this->parentcategory = $parentcategory;
	}
    
	/**
	 * Returns the the children of the current cat
	 *
	 * @return array $children
	 */
	public function getChildren() {
        $catRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Emagineurs\EAnnuaires\Domain\Repository\CategorieRepository');
                
        $children = $catRepository->findChildren($this->getUid());
                
        return $children;
	}

	/**
	 * Returns the images
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Sets the images
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
	 * @return void
	 */
	public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images) {
		$this->images = $images;
	}

}
?>