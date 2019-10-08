<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:21
 */

namespace Pingag\PingagThurcom\Domain\Repository;


use Pingag\PingagThurcom\Domain\Model\ServiceLocation;

class SimpleServiceLocationRepository extends BaseRepository
{
	
	protected $defaultOrderings = array(
		'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);

    /**
     * @param $term
     * @param int $limit
     * @return SimpleServiceLocation $object
     */
    public function findBySearchTerm($term)
    {
        $query = $this->createQuery();

        $constraint = $query->logicalOr(
            $query->equals('zip', $term),
            $query->like('city', '%'.$term.'%', false)
            //$query->like('title', '%'.$term.'%', false)
        );
        $query->matching($constraint);

        return $query->execute();
    }
	
	public function findAll()
    {
        $q = $this->createQuery();
        $q->getQuerySettings()->setRespectStoragePage(false);
        return $q->execute();
    }
}