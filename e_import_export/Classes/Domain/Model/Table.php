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

/**
 * Table
 */
class Table extends AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * wheretext
	 *
	 * @var string
	 */
	protected $wheretext = '';

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
	 * Returns the wheretext
	 *
	 * @access public
	 * @return string $wheretext
	 */
	public function getWheretext() {
		return $this->wheretext;
	}

	/**
	 * Sets the wheretext
	 *
	 * @param string $wheretext
	 * @access public
	 * @return void
	 */
	public function setWheretext($wheretext) {
		$this->wheretext = $wheretext;
	}
	
	/**
	 * Get datas by executing the table where query
	 *
	 * @param string $arg an additionnal where clause
	 * @access public
	 * @return array|NULL Array of rows, or NULL in case of SQL error
	 */
	public function getDatas($arg = null){
		$table = $this->getName();
		$where = $this->getWheretext();
		
		if(!empty($arg)){
			$where = str_replace('###FIELD###', $arg, $where);
		}
		
		if(strpos($where, '###FIELD###') !== false){
			return array();
		}
		
		
		$content = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*',$table,$where);
                
                /// Je repasse en selectgetRows. QueryBuilder est trop restrictif, le $where contient des requêtes sql souple, après le where, donc ça inclu limit, group by, having, ect ect
                /// Ya pas de champs différent pour chaque type d'élément de query, et c'est pas le but, le but c'est d'avoir un bloc où on peut faire les requêtes sql qu'on veut.
                /////que ce soit assez souple. 
                /// Là ça génère des erreurs si on met des trucs de type "limit", ect.
                /// Soit on laisse un bloc de query souple, soit on met en place des trucs restrictif, mais ayant tout les type de champs possible pour faire les requêtes SQL que l'on veut.
                /*
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		$content = $queryBuilder
			->select('*')
			->from($table)
			->where(
				$where
			)
			->execute()
			->fetchAll();
		*/	
			
		return $content;
	}
}