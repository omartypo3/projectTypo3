<?php
namespace Emagineurs\EPoll\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Le Sommer Léo-Robin <llesommer@e-magineurs.com>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Emagineurs\EPoll\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
|
| * @package e_poll
| * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
| *
| */
class PollRepository extends Repository {
    
    /**
     * @var string
     */
    protected $objectType = \Emagineurs\EPoll\Domain\Model\Poll::class;
    
    public function __construct(
        protected readonly CategoryRepository $categoryRepository
    ) {
    }

    /**
     * @param array $settings
     * @return QueryResultInterface
     */
    public function findBySettings(array $settings): QueryResultInterface {
        $query = $this->createQuery();

        $constraints = [];

        //Categories
        if(!empty($settings['categories'])) {
            $categoryQuery = $this->categoryRepository->createQuery();
            $categoryQuery->matching($categoryQuery->in('uid', explode(',', $settings['categories'])));

            $result = $categoryQuery->execute();
            $objectStorage = $this->fillObjectStorageFromQueryResult($result);

            $constraints[] = $query->contains('categories', $objectStorage);
        }

        //Storage pid
        if(!empty($settings['storagePid'])) {
            $query->getQuerySettings()->setRespectStoragePage(false);
            $constraints[] = $query->in('pid', explode(',', $settings['storagePid']));
        }

        if(!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        //Ordering
        if(!empty($settings['orderBy'])) {
            $query->setOrderings([
                $settings['orderBy'] => (($settings['orderDirection'] ?? '') != 'desc') 
                    ? QueryInterface::ORDER_ASCENDING 
                    : QueryInterface::ORDER_DESCENDING
            ]);
        }

        return $query->execute();
    }

    /**
     * Fill objectStorage from QueryResult
     *
     * @param QueryResultInterface|null $queryResult
     * @return ObjectStorage
     */
    protected function fillObjectStorageFromQueryResult(?QueryResultInterface $queryResult = null): ObjectStorage {
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);

        if ($queryResult !== null) {
            foreach($queryResult as $object) {
                $objectStorage->attach($object);
            }
        }

        return $objectStorage;
    }
}