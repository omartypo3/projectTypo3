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
use Emagineurs\EImportExport\Handlers\AbstractHandlers;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Emagineurs\EImportExport\Domain\Model\Table;

/**
 * Conf
 */
class Conf extends AbstractEntity {

	
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;
	
	/**
	 * tag
	 *
	 * @var string
	 */
	protected $tag;
	
	/**
	 * type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * interaction
	 *
	 * @var integer
	 */
	protected $interaction = 0;

	/**
	 * interface
	 *
	 * @var string
	 */
	protected $interface = 0;
	
	/**
	 * url
	 *
	 * @var string
	 */
	protected $url;
	
	/**
	 * uniqfield
	 *
	 * @var string
	 */
	protected $uniqfield;
        
	/**
	 * forceadd
	 *
	 * @var integer
	 */
	protected $forceadd = 0;

	/**
	 * fields
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EImportExport\Domain\Model\Field>
	 */
	protected $fields = null;

	/**
	 * tables
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EImportExport\Domain\Model\Table>
	 */
	public $tables = null;

	
	/**
	 * __construct
	 * @access public
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @access public
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->tables = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->fields = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @access public
	 * @return string $title
	 */
	public function getTitle() {
		return strtoupper($this->title);
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @access public
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the uniqfield
	 *
	 * @access public
	 * @return string $uniqfield
	 */
	public function getUniqfield() {
		return strtoupper($this->uniqfield);
	}

	/**
	 * Sets the uniqfield
	 *
	 * @param string $uniqfield
	 * @access public
	 * @return void
	 */
	public function setUniqfield($uniqfield) {
		$this->uniqfield = $uniqfield;
	}
        
        /**
	 * Returns the forceadd
	 *
	 * @return integer $forceadd
	 */
	public function getForceadd() {
            return strtoupper($this->forceadd);
	}

	/**
	 * Sets the forceadd
	 *
	 * @param integer $forceadd
	 * @return void
	 */
	public function setForceadd($forceadd) {
		$this->forceadd = $forceadd;
	}

	/**
	 * Returns the tag
	 *
	 * @access public
	 * @return string $tag
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * Sets the tag
	 *
	 * @param string $tag
	 * @access public
	 * @return void
	 */
	public function setTag($tag) {
		$this->tag = $tag;
	}
	
	/**
	 * Returns the type
	 *
	 * @access public
	 * @return string $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @access public
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the interaction
	 *
	 * @access public
	 * @return integer $interaction
	 */
	public function getInteraction() {
		return ($this->interaction)?'import':'export';
	}

	/**
	 * Sets the interaction
	 *
	 * @param integer $interaction
	 * @access public
	 * @return void
	 */
	public function setInteraction($interaction) {
		$this->interaction = $interaction;
	}

	/**
	 * Returns the interface
	 *
	 * @access public
	 * @return array $interface
	 */
	public function getInterface() {
		return explode(',', $this->interface);
	}

	/**
	 * Sets the interface
	 *
	 * @param array $interface
	 * @access public
	 * @return void
	 */
	public function setInterface($interface) {
		$this->interface = implode(',', $interface);
	}

	/**
	 * Returns the url
	 *
	 * @access public
	 * @return string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param string $url
	 * @access public
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the tables
	 *
	 * @access public
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EImportExport\Domain\Model\Bite> $tables
	 */
	public function getTables() {
		return $this->tables;
	}

	/**
	 * Sets the tables
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EImportExport\Domain\Model\Bite> $tables contains Table objects
	 * @access public
	 * @return void
	 */
	public function setTables($tables) {
		$this->tables = $tables;
	}

	/**
	 * Returns the fields
	 *
	 * @access public
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $fields
	 */
	
	public function getFields() {
		/*$confQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_eimportexport_domain_model_conf');
		$res = $confQueryBuilder
			->select('fields')
			->from('tx_eimportexport_domain_model_conf')
			->where(
				$confQueryBuilder->expr()->eq('uid', (int)$this->getUid())
			)
			->execute()
			->fetchAll();
		
		$res = reset($res);
		$fieldsOrder = $res['fields'];
		
		$fields = explode(',', $fieldsOrder);
		$objTmp = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		foreach($fields as $uidOrder){
			foreach($this->fields as $k => $v){
				if($v->uid == $uidOrder){
					$objTmp->attach($v);
				}
			}
		}
		$this->fields = $objTmp;*/
		return $this->fields;
	}
	
	/**
	 * Get a field by uid
	 *
	 * @param int $uid
	 * @access public
	 * @return array|NULL Array of rows, or NULL in case of SQL error
	 */
	public function getFieldByUid($uid){
		$fieldQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_eimportexport_domain_model_field');
		$res = $fieldQueryBuilder
			->select('*')
			->from('tx_eimportexport_domain_model_field')
			->where(
                $fieldQueryBuilder->expr()->eq('uid', (int)$uid)
			)
			->execute()
			->fetchAll();
 
		return $res;
	}
	
	/**
	 * Sets the fields
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $fields contains Field objects
	 * @access public
	 * @return void
	 */
	public function setFields(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fields) {
		$this->fields = $fields;
	}
	
	/**
	 * Returns the all table fields
	 *
	 * @access public
	 * @return array $fields
	 */
	public function getAllFields(){
		$tables = $this->getTable();
		
		if(strpos($tables, ',')===false){
			$fields = $GLOBALS['TYPO3_DB']->admin_get_fields($tables);
			$ret = array_keys($fields);
			foreach($ret as $key => $val){
				$ret[$key] = $tables.'.'.$val;
			}
			return $ret;
		}
		
		return array();
	}
	
	/**
	 * Returns all the tables in the conf record
	 *
	 * @access public
	 * @return mixed $allTables all tables in the conf record, false if there is an error
	 */
	public function getTable(){
		$tables = $this->getTables();

		if(empty($tables))
			return false;
			
		$tablesStorage = $tables->toArray();
		$tables = array();
		foreach($tablesStorage as $table){
			$tables[] = $table->getName();
		}
		
		if(count($tables) < 1){
			return false;
		}
		
		$allTables = implode(',', $tables);
		
		return $allTables;
	}
	
	/**
	 * Returns the handler of the conf record
	 *
	 * @access public
	 * @return AbstractHandlers $handler the handler of the conf record, null if unidefined
	 */
	public function getHandler(){
		$type = $this->getType();		
		$interaction = $this->getInteraction();	
		if(!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers'][$interaction][$type])){
			$handler = GeneralUtility::makeInstance($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers'][$interaction][$type], $this);
			return $handler;
		}
		return null;
	}
	
	/**
	 * Returns the first of all the tables in the conf record
	 *
	 * @access public
	 * @return array $table the first of all the tables in the conf record
	 */
	public function getFirstTable() {
		$tables = $this->getTables()->toArray();
		$table = reset($tables);
		return $table;
	}
}