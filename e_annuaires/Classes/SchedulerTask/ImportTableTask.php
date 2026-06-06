<?php
namespace Emagineurs\EAnnuaires\SchedulerTask;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
class ImportTableTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	
	/**
	 * Function execute from the Scheduler
	 *
	 * @return boolean TRUE on successful execution, FALSE on error
	 */
	public function execute(){
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable($this->table);
		$queryBuilder->getRestrictions()->removeAll()
			->add(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction::class));
		
		$query = $queryBuilder
			->select('*')
			->from($this->table)
			->where(
				$queryBuilder->expr()->eq('deleted', 0),
				$queryBuilder->expr()->eq('disable', 0)
			)
			->executeQuery()
			->fetchAllAssociative();
			
		if($query){
			foreach($query as $row){
				$conf = $this->parseConfiguration();
				$i = 0;
				$alreadyExists = false;
				$categoriesGestion = false;
				foreach($conf as $tableField => $annuaireField){
					if($i == 0){
						$alreadyExists = $this->checkIfAlreadyExists($annuaireField, $row[$tableField]);
						$fields_values = array($annuaireField => $row[$tableField]);
					} else {
						//Cas particulier des categories
						if($annuaireField == 'categories'){
							if(isset($row[$tableField]) && $row[$tableField] != ''){
								ob_start();
								var_dump($tableField);
								$debug = ob_get_contents();
								ob_end_clean();
								$GLOBALS['BE_USER']->simplelog($debug, 'tableField', 1);	
								$categoriesGestion = true;
								$categoryUid = $this->createCategory($row[$tableField]);
								$fields_values[$annuaireField] = 1;
							}
						}
						$fields_values[$annuaireField] = $row[$tableField];
					}
					$i++;
				}
				if($alreadyExists){
					$this->updateFiche('uid="'.$alreadyExists.'"', $fields_values);
					$ficheUid = $alreadyExists;
				} else {
					$ficheUid = $this->createFiche($fields_values);
				}
				if($categoriesGestion){
					$this->assignCategory($categoryUid, $ficheUid);
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function parseConfiguration(){
		$configuration = $this->configuration;
		$final_result = array();
		$array = explode(',', $configuration);
		foreach($array as $piece){
			$result = explode('=>', $piece);
			$final_result[trim($result[0])] = trim($result[1]);
		}
		return $final_result;
	}
	
	public function createFiche($fields_values){
		$fields_values['typeelement'] = $this->type;
		$fields_values['pid'] = $this->pid;
		
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$connection = $connectionPool->getConnectionForTable('tx_eannuaires_domain_model_fiche');
		$connection->insert('tx_eannuaires_domain_model_fiche', $fields_values);
		
		$queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
		$uid = $queryBuilder
			->select('uid')
			->from('tx_eannuaires_domain_model_fiche')
			->orderBy('uid', 'DESC')
			->setMaxResults(1)
			->executeQuery()
			->fetchAssociative();
		
		return $uid;
	}
	
	public function updateFiche($where, $fields_values){
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
		$queryBuilder->getRestrictions()->removeAll();
		
		$queryBuilder
			->update('tx_eannuaires_domain_model_fiche')
			->where($where)
			->executeStatement();
			
		foreach ($fields_values as $field => $value) {
			$queryBuilder->set($field, $value);
		}
		
		$queryBuilder->executeStatement();
	}
	
	public function checkIfAlreadyExists($field, $value){
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_fiche');
		
		$query = $queryBuilder
			->select('*')
			->from('tx_eannuaires_domain_model_fiche')
			->where(
				$queryBuilder->expr()->eq($field, $queryBuilder->createNamedParameter($value))
			)
			->executeQuery()
			->fetchAllAssociative();
			
		if($query){
			return $query[0]['uid'];
		} else {
			return false;
		}
	}	
	
	public function assignCategory($categoryUid, $ficheUid){
		//On supprime les autres catégories (une seule catégorie possible dans notre cas);
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		
		$deleteQueryBuilder = $connectionPool->getQueryBuilderForTable('sys_category_record_mm');
		$deleteQueryBuilder
			->delete('sys_category_record_mm')
			->where(
				$deleteQueryBuilder->expr()->eq('uid_foreign', $deleteQueryBuilder->createNamedParameter((int)$ficheUid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT)),
				$deleteQueryBuilder->expr()->eq('tablenames', $deleteQueryBuilder->createNamedParameter('tx_eannuaires_domain_model_fiche'))
			)
			->executeStatement();
			
		$fields_values = [];
		$fields_values['uid_local'] = $categoryUid;
		$fields_values['uid_foreign'] = $ficheUid;
		$fields_values['tablenames'] = 'tx_eannuaires_domain_model_fiche';
		$fields_values['fieldname'] = 'categories';
		$fields_values['sorting'] = 0;
		$fields_values['sorting_foreign'] = 1;
		
		$connection = $connectionPool->getConnectionForTable('sys_category_record_mm');
		$connection->insert('sys_category_record_mm', $fields_values);
	}
	
	public function createCategory($title){
		$connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('sys_category');
		
		$alreadyExists = $queryBuilder
			->select('uid')
			->from('sys_category')
			->where(
				$queryBuilder->expr()->eq('title', $queryBuilder->createNamedParameter($title))
			)
			->executeQuery()
			->fetchAllAssociative();
			
		if(!$alreadyExists){
			$fields_values = [];
			$fields_values['pid'] = $this->pidCat;
			if(isset($this->parentCat) &&  $this->parentCat != 0){
				$fields_values['parent'] = $this->parentCat;
			}
			$fields_values['title'] = $title;
			
			$connection = $connectionPool->getConnectionForTable('sys_category');
			$connection->insert('sys_category', $fields_values);
			
			$lastInsertId = $connection->lastInsertId('sys_category');
			
			$GLOBALS['BE_USER']->simplelog('Created category: ' . $lastInsertId, 'titleCat', 1);
			
			return $lastInsertId;
		} else {
			return $alreadyExists[0]['uid'];
		}
	}
	

}
