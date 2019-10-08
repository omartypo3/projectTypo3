<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:21
 */

namespace Pingag\PingagThurcom\Domain\Repository;


use Pingag\PingagThurcom\Domain\Model\City;

class CityRepository extends BaseRepository
{

    /**
     * @param $term
     * @param int $limit
     * @return City $object
     */
    public function findBySearchTerm($term, $limit = 1)
    {
        $query = $this->createQuery();

        $constraint = $query->logicalOr(
            $query->equals('zip', $term),
            $query->like('title', '%'.$term.'%', false),
			$query->like('additional_zips', '%'.$term.'%', false)
            //$query->like('title', '%'.$term.'%', false)
        );
        $query->matching($constraint);
        $query->setLimit($limit);

        if($limit === 1){
            return $query->execute()->getFirst();
        } else{
            return $query->execute();
        }
    }
	public function findAll()
    {
        $q = $this->createQuery();
        $q->getQuerySettings()->setRespectStoragePage(false);
        return $q->execute();
    }
}