<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:21
 */

namespace Pingag\PingagThurcom\Domain\Repository;

class ProductRepository extends BaseRepository
{
    /**
     * @param $categories
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByCategories($categories)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $categoryConstraint = $this->createCategoryConstraint($query, $categories, 'or');
        $query->matching($categoryConstraint);

        return $query->execute();
    }
	public function findByCategory($categories)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $categoryConstraint = $this->createCategoryConstraint($query, $categories, 'and');
        $query->matching($categoryConstraint);

        return $query->execute();
    }
	public function findAll()
    {
        $q = $this->createQuery();
        $q->getQuerySettings()->setRespectStoragePage(false);
        return $q->execute();
    }
	protected $defaultOrderings = array( 
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        // ::ORDER_DESCENDING = Absteigende Sortierung
    );
}