<?php
namespace Emagineurs\EImportExport\Domain\Repository;


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
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for every record tables, use TCA to map the values
 */
class GenericRepository implements SingletonInterface  {
	/**
	 * Add a new record into the database
	 *
	 * @param string $table The table name
	 * @param array $values Field values as key => value pairs. Values will be escaped internally. Typically you would fill an array like "$insertFields" with 'fieldname'=>'value' and pass it to this function as argument.
	 * @param boolean $useTCA set to true if you want to use TCA map to import the datas
	 * @static
	 * @access public
	 * @return int $uid The uid of the new record
	 */
	public function add($table, $values, $useTCA = true){
		if($useTCA) {
			//using simple db access
			$tcemainId = 'NEW' . uniqid();
			$data = array();
			$data[$table][$tcemainId] = $values;
			return $this->handleRecords($data, $tcemainId);
		} else {
			//the version without process_datamap :
			$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $values);
			$uid = $GLOBALS['TYPO3_DB']->sql_insert_id();
			return $uid;
		}
	}

	/**
	 * Update a new record into the database
	 *
	 * @param int $uid The uid of the recort that should be updated
	 * @param string $table The table name
	 * @param array $values Field values as key=>value pairs. Values will be escaped internally. Typically you would fill an array like "$insertFields" with 'fieldname'=>'value' and pass it to this function as argument.
	 * @param boolean $useTCA set to true if you want to use TCA map to import the datas
	 * @static
	 * @access public
	 * @return void
	 */
	public function update($uid, $table, $values, $useTCA = true){
		if($useTCA) {
			//using simple db access
			$data = array();
			$data[$table][$uid] = $values;

			$this->handleRecords($data);
		} else {
			//the version without process_datamap :
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, 'uid='.intval($uid), $values);
		}
	}

	/**
	 * Process database transformation with TCA datas, it use the \TYPO3\CMS\Core\DataHandling\DataHandler class from typo3 core, especialy process_datamap function
	 *
	 * @param array $datas Data to be modified or inserted in the database
	 * @param boolean $newUid
	 * @static
	 * @access private
	 * @return mixed : if $newUid is not false, return the uid of the new record, void otherwise
	 */
	public function handleRecords($datas, $newUid = false){
		$tce = GeneralUtility::makeInstance(DataHandler::class);
		$tce->stripslashes_values = 0;
		$tce->dontProcessTransformations = 1;
		$tce->start($datas, array());
		$tce->process_datamap();
		
		if($newUid) {
			return $tce->substNEWwithIDs[$newUid];
		} else {
			return null;
		}
	}

	/**
	 * Replace the stripped characters of a string by the associated characters
	 *
	 * @param string $table The table name
	 * @param array $array_key_value a array based on $key => $value, every entry will add a "[AND] $key = $value" to the where component of the request
	 * @param string $whereComp a where component, be carefu to secure your where request
	 * @static
	 * @access public
	 * @return boolean the uid of the record, false if the record was not found
	 */
	public function find($table, $array_key_value){
		$where = '';
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		
		foreach($array_key_value as $key => $value){
			if(empty($where)){
				$where = '`'.$key.'` = "'.$value.'"';
			}else{
				$where .= ' AND `'.$key.'` = "'.$value.'"';
			}
		}
		
		$res = $queryBuilder
			->select('uid')
			->from($table)
			->where(
				$where
			)
			->execute()
			->fetch();

		if(is_array($res) && count($res) > 0 && !empty($res['uid'])){
			return $res['uid'];
		}

		return false;
	}
	
	public function findDeletedAndHidden($table, $array_key_value) {
		$where = '';
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		// $queryBuilder
			// ->getRestrictions()
			// ->removeAll();
		foreach($array_key_value as $key => $value){
			if(empty($where)){
				$where = '`'.$key.'` = "'.$value.'"';
			}else{
				$where .= ' AND `'.$key.'` = "'.$value.'"';
			}
		}
		
		$res = $queryBuilder
			->select('*')
			->from($table)
			->where(
				$where
			)
			->execute()
			->fetch();

		return $res;
	}	
	
	public function findMultipleDeletedAndHidden($table, $array_key_value) {
		$where = '';
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		// $queryBuilder
			// ->getRestrictions()
			// ->removeAll();
		foreach($array_key_value as $key => $value){
			if(empty($where)){
				$where = '`'.$key.'` = "'.$value.'"';
			}else{
				$where .= ' AND `'.$key.'` = "'.$value.'"';
			}
		}
		
		$res = $queryBuilder
			->select('*')
			->from($table)
			->where(
				$where
			)
			->execute()
			->fetchAll();

		return $res;
	}
}