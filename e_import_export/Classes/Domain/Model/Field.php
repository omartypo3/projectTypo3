<?php
namespace Emagineurs\EImportExport\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
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

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Field
 */
class Field extends AbstractEntity {

	/**
	 * type
	 *
	 * @var integer
	 */
	protected $type = 0;

	/**
	 * ifempty
	 *
	 * @var integer
	 */
	protected $ifempty = 0;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * format
	 *
	 * @var string
	 */
	protected $format = '';

	/**
	 * tablefield
	 *
	 * @var string
	 */
	protected $tablefield = '';

	/**
	 * stdwrap
	 *
	 * @var string
	 */
	protected $stdwrap = '';

		/**
	 * userpost
	 *
	 * @var string
	 */
	protected $userpost = '';
		
	/**
	 * arrcheck
	 *
	 * @var boolean
	 */
	protected $arrcheck = 0;
		
	/**
	 * isunique
	 *
	 * @var boolean
	 */
	protected $isunique = 0;
		
	/**
	 * forcefield
	 *
	 * @var boolean
	 */
	protected $forcefield = 0;

	/**
	 * multiple
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EImportExport\Domain\Model\Field>
	 */
	protected $multiple = NULL;

	/**
	 * relation
	 *
	 * @var \Emagineurs\EImportExport\Domain\Model\Table
	 */
	protected $relation = NULL;

	/**
	 * Returns the type
	 *
	 * @access public
	 * @return integer $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @access public
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the name
	 *
	 * @access public
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @access public
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the format
	 *
	 * @access public
	 * @return string $format
	 */
	public function getFormat() {
		return $this->format;
	}

	/**
	 * Sets the format
	 *
	 * @param string $format
	 * @access public
	 * @return void
	 */
	public function setFormat($format) {
		$this->format = $format;
	}

	/**
	 * Returns the tablefield
	 *
	 * @access public
	 * @return string $tablefield
	 */
	public function getTablefield() {
		return $this->tablefield;
	}

	/**
	 * Sets the tablefield
	 *
	 * @param string $tablefield
	 * @access public
	 * @return void
	 */
	public function setTablefield($tablefield) {
		$this->tablefield = $tablefield;
	}

	/**
	 * Returns the stdwrap
	 *
	 * @access public
	 * @return string $stdwrap
	 */
	public function getStdwrap() {
		return $this->stdwrap;
	}

	/**
	 * Sets the stdwrap
	 *
	 * @param string $stdwrap
	 * @access public
	 * @return void
	 */
	public function setStdwrap($stdwrap) {
		$this->stdwrap = $stdwrap;
	}
	
	/**
	 * Returns the userpost
	 *
	 * @access public
	 * @return string $userpost
	 */
	public function getUserpost() {
		return $this->userpost;
	}

	/**
	 * Sets the userpost
	 *
	 * @param string $userpost
	 * @access public
	 * @return void
	 */
	public function setUserpost($userpost) {
		$this->userpost = $userpost;
	}
	/**
	 * Returns the arrcheck
	 *
	 * @access public
	 * @return string $arrcheck
	 */
	public function getArrcheck() {
		return $this->arrcheck;
	}

	/**
	 * Sets the arrcheck
	 *
	 * @param string $arrcheck
	 * @access public
	 * @return void
	 */
	public function setArrcheck($arrcheck) {
		$this->arrcheck = $arrcheck;
	}
	
	/**
	 * Returns the forcefield
	 *
	 * @access public
	 * @return string $forcefield
	 */
	public function getForcefield() {
		return $this->forcefield;
	}

	/**
	 * Sets the forcefield
	 *
	 * @param string $forcefield
	 * @access public
	 * @return void
	 */
	public function setForcefield($forcefield) {
		$this->forcefield = $forcefield;
	}

	/**
	 * Returns the multiple
	 *
	 * @access public
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $multiple
	 */
	public function getMultiple() {
		//JETER UN COUP D'OEUIL ! PEUT SUREMENT ETRE REMPLACE PAR UN SIMPLE GETTER

		$fieldQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_eimportexport_domain_model_field');
		$res = $fieldQueryBuilder
			->select('multiple')
			->from('tx_eimportexport_domain_model_field')
			->where(
				$fieldQueryBuilder->expr()->eq('uid', (int)$this->getUid())
			)
			->execute()
			->fetchAll();

		$res = reset($res);
		$fieldsOrder = $res['multiple'];  
		
		$fields = explode(',', $fieldsOrder);
		$objTmp = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		foreach ($fields as $uidOrder){
			foreach ($this->multiple as $k => $v){
				if($v->uid==$uidOrder){
					$objTmp->attach($v);
				}
			}
		}
		
		$this->multiple = $objTmp;
		return $this->multiple;
	}

	/**
	 * Sets the multiple
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $multiple contain Field objects
	 * @access public
	 * @return void
	 */
	public function setMultiple(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $multiple) {
		$this->multiple = $multiple;
	}

	/**
	 * Returns the relation
	 *
	 * @access public
	 * @return Table $relation
	 */
	public function getRelation() {
		return $this->relation;
	}

	/**
	 * Sets the relation
	 *
	 * @param Table $relation
	 * @access public
	 * @return void
	 */
	public function setRelation(Table $relation) {
		$this->relation = $relation;
	}
	
	/**
	 * Returns all the table name of the field entry
	 *
	 * @access public
	 * @return string the table name of the field entry
	 */
	public function getTable(){
		$table = $this->getRelation();
		if(empty($table))
			return false;
			
		return $table->getName();
	}
	
	/**
	 * Returns the all table fields
	 *
	 * @access public
	 * @return array $fields
	 */
	public function getAllFields(){
		$table = $this->getTable();
		$fields = $GLOBALS['TYPO3_DB']->admin_get_fields($table);
		$ret = array_keys($fields);
		foreach($ret as $key => $val){
			$ret[$key] = $table.'.'.$val;
		}
		$ret[$key] = $table.'.'.$table;

		return $ret;
	}

	/**
	 * Returns the ifempty
	 *
	 * @access public
	 * @return integer $ifempty
	 */
	public function getIfempty() {
		return $this->ifempty;
		}

	/**
	 * Sets the ifempty
	 *
	 * @param integer $ifempty
	 * @access public
	 * @return void
	 */
	public function setIfempty($ifempty) {
		$this->ifempty = $ifempty;
	}
}