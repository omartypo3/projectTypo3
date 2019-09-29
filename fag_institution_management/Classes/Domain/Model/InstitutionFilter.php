<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Roland Kneubühler rk@frontal.ch>, Agentur Frontal AG
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
 *
 *
 * @package fag_institution_management
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class InstitutionFilter {

	/**
	 * [$searchFields description]
	 * @var array
	 */
	protected $searchFields =  array('title', 'last_name', 'city');

	/**
	 * fulltext search
	 * 
	 * @var string Search word(s)
	 */
	protected $searchString;
    
    /**
     * searchInstitution
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Institution
     */
    protected $searchInstitution;

	/**
	 * searchCategory1
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $searchCategory1;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $searchCategories1;
	
	/**
	 * searchCategory2
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $searchCategory2;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $searchCategories2;

	/**
	 * searchCategory3
	 * @var \TYPO3\CMS\Extbase\Domain\Model\Category
	 */
	protected $searchCategory3;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $searchCategories3;
	 
	/**
	 * allowedCategories
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	protected $allowedCategories;
	
	/**
	 * @var string
	 */
	protected $sorting;

	/**
	 * @var integer
	 */
	protected $limit;


	/**
	 * @var boolean
	 */
	private $countOnly;


	
	/**
	 * Getter for searchFields
	 *
	 * @return array
	 */
	public function getSearchFields() {
	    return $this->searchFields;
	}
	
	/**
	 * Setter for searchFields
	 *
	 * @param array $searchFields Value to set
	 * @return self
	 */
	public function setSearchFields(array $searchFields) {
	    $this->searchFields = $searchFields;
	}
	
	/**
	 * @return boolean
	 */
	public function getCountOnly() {
		return $this->countOnly;
	}

	/**
	 * @param boolean
	 */
	public function setCountOnly($value) {
		$this->countOnly = $value;
	}

	/**
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * @param integer
	 */
	public function setLimit($limit) {
		$this->limit = intval($limit);
	}


	/**
	 * @return string
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * @param string
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}

	
	/**
	 * set searchString
	 * @param string $searchString
	 */
	public function setSearchString($searchString){
		$this->searchString = $searchString;
	}

	/**
	 * get searchString
	 * @return string searchString
	 */
	public function getSearchString(){
		return $this->searchString;
	}
	

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	public function getAllowedCategories() {
		return $this->allowedCategories;
	}
	
	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	public function setAllowedCategories($allowedCategories) {
		$this->allowedCategories = $allowedCategories;
	}

	/**
	 *
	 *		MULTIPLE CATEGORY FILTERS, SO PARENT IDs OF CATEGORIES CAN BE USED
	 * 
	 */


	/*                       -1-						*/

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\Category 
	 */
	public function getSearchCategory1() {
		return $this->searchCategory1;
	}
	
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $searchCategory
	 */
	public function setSearchCategory1($searchCategory) {
		$this->searchCategory1 = $searchCategory;
	}
	
	/**
	 * set searchAddressType
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $searchCategories
	 * @return void
	 */
	public function setSearchCategories1($searchCategories){
		$this->searchCategories1 = $searchCategories;
	}

	/**
	 * get searchAddressType
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	public function getSearchCategories1(){
		return $this->searchCategories1;
	}
	

	/*                       -2-						*/

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\Category 
	 */
	public function getSearchCategory2() {
		return $this->searchCategory2;
	}
	
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $searchCategory
	 */
	public function setSearchCategory2($searchCategory) {
		$this->searchCategory2 = $searchCategory;
	}
	
	/**
	 * set searchAddressType
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $searchCategories
	 * @return void
	 */
	public function setSearchCategories2($searchCategories){
		$this->searchCategories2 = $searchCategories;
	}

	/**
	 * get searchAddressType
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	public function getSearchCategories2(){
		return $this->searchCategories2;
	}

	/*                       -3-						*/

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\Category 
	 */
	public function getSearchCategory3() {
		return $this->searchCategory3;
	}
	
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $searchCategory
	 */
	public function setSearchCategory3($searchCategory) {
		$this->searchCategory3 = $searchCategory;
    }

	/**
	 * @return \FRONTAL\FagInstitutionManagement\Domain\Model\Institution 
	 */
	public function getSearchInstitution() {
		return $this->searchInstitution;
	}
	
	/**
	 * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $searchInstitution
	 */
	public function setSearchInstitution($searchInstitution) {
		$this->searchInstitution = $searchInstitution;
	}

	/**
	 * set searchAddressType
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $searchCategories
	 * @return void
	 */
	public function setSearchCategories3($searchCategories){
		$this->searchCategories3 = $searchCategories;
	}

	/**
	 * get searchAddressType
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 */
	public function getSearchCategories3(){
		return $this->searchCategories3;
	}


	
	
	public function __sleep() {
		
		// replace objects with uids to save minimize the saved session data
		// the object will be restored by system from the uid in the _wakeup()-function
		if(is_object($this->searchCategory1)) $this->searchCategory1 = $this->searchCategory1->getUid();
		if(is_object($this->searchCategory2)) $this->searchCategory2 = $this->searchCategory2->getUid();
        if(is_object($this->searchCategory3)) $this->searchCategory3 = $this->searchCategory3->getUid();
        
		if(is_object($this->searchInstitution)) $this->searchInstitution = $this->searchInstitution->getUid();

		return array('searchString',
					 'searchCategory1',
					 'searchCategories1',
					 'searchCategory2',
					 'searchCategories2',
					 'searchCategory3',
                     'searchCategories3',
                     'searchInstitution');
	}
	 	
}
?>
