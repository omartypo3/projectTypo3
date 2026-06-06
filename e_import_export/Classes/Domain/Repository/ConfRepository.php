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
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Confs
 */
class ConfRepository extends Repository {
	/**
	 * Returns all objects of this repository.
	 * 
	 * @access public
	 * @return QueryResultInterface|array
	 */
	public function findAll(){		
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query->execute();
	}
	
	/**
	 * Finds an object matching the given identifier.
	 * 
	 * @param int $uid The identifier of the object to find
	 * @access public
	 * @return object The matching object if found, otherwise NULL
	 */
	public function findByFieldUid($uid){
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$res = $query->matching($query->contains('fields', $uid))->setLimit(1)->execute();
		if($res->count()>0){
			return $res->getFirst();
		}
		return null;
	}
}