<?php
namespace DslFactory\DslProdukte\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * The repository for Highlights
 */
class HighlightsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findByUids($uids) {

		$uidArray = explode(",", $uids);
	//	print_r($uidArray);
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->getQuerySettings()->setRespectSysLanguage(FALSE);

		foreach ($uidArray as $key => $value) {
			$constraints[] =  $query->equals('uid', $value);
		}

		$query->matching(
			$query->logicalAnd(
			$query->logicalOr(
				$constraints
			),
			//$query->equals('hidden', 0),
			$query->equals('deleted', 0)
			)
		);
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
		return $query->execute()->getFirst();

		
	}

	
}