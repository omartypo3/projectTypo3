<?php
namespace Emagineurs\Emagineurs\ImportExport;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Marvin Marchand <mmarchand@e-magineurs.com>, E-magineurs
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class ImportCsvHandlers extends \Emagineurs\EImportExport\Handlers\Import\CsvHandlers {
	
	/**
	 * Import the input file (from the conf url) to the database
	 * 
	 * @access public
	 * @return string
	 */
	public function import($url="") {

		//If tag == 1 means that we want to delete records before import
		if($this->conf->getTag() == "1"){
			foreach($this->conf->getTables() as $oneTable){
				$tableName = $oneTable->getName();
			}
			foreach($this->conf->getFields() as $oneField){
				//Get pid for records
				if(strpos($oneField->getTableField(), ".pid") != false){
					$tableFieldPid = $oneField->getTableField();
					$pid = $oneField->getName();
				}
				// get annuaire typeelement to be more accurate in the deletion
				if(strpos($oneField->getTableField(), ".typeelement") != false){
					$tableFieldTypeelement = $oneField->getTableField(); 
					$typeelement = $oneField->getName();
				}
			}
			//deletion of records
			if(($tableName != '') && ($pid != '')){
				$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
				$queryBuilder->delete($tableName)
					->where(
						$queryBuilder->expr()->eq($tableFieldPid, intval($pid))
					);
					
				if(($typeelement != '') && ($tableFieldTypeelement != '')){
					$queryBuilder->andWhere(
						$queryBuilder->expr()->eq($tableFieldTypeelement, intval($typeelement))
					);
				}
				$queryBuilder->execute();
			}
		}

		$this->prepare();
		
		$inputHandle = $this->openFile($this->conf->getUrl());
		
		$this->read($inputHandle);
		$this->format();

		$return = $this->insert();
		
		fclose($inputHandle);
		
		return $return;
	}

}