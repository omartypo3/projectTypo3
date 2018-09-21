<?php

namespace Avonis\Theme\Domain\Repository;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Repository for Category models.
 *
 */

class CategoriesRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository {

	protected $defaultOrderings = array(
		'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Just find by uid
	 *
	 * @param string $uid
	 *
	 * @return object|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUid ( $uid ) {

		$query = $this->createQuery();

		return $query->matching($query->equals('uid', $uid))->execute()->getFirst();
	}

	/**
	 * Find by uid and / or sys_lang
	 *
	 * @param integer $uid
	 * @param integer $lang
	 *
	 * @return object|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUidAndLanguage ( $uid, $lang ) {

		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectSysLanguage(false);

		return ($lang) ?
			$query->matching(
				$query->logicalAnd(
					array(
						$query->equals('l10nParent', $uid),
						$query->equals('sysLanguageUid', $lang)
					)
				)
			)->execute()->getFirst()
			: $this->findByUid($uid);

	}
	public function findTitlePageByUidAndLanguage ( $uid, $lang ) {

		
		$query = $this->createQuery();
		$query->matching( $query->statement(
            "SELECT title
            FROM pages_language_overlay WHERE pid = '" . $uid . "' AND sys_language_uid = '" . $lang . "'"
        ));
       
		return $query->execute(TRUE);
		
	}


}