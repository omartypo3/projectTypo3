<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:21
 */

namespace Pingag\PingagThurcom\Domain\Repository;

class ChannelPackageRepository extends BaseRepository
{
	
	public function findAll()
    {
        $q = $this->createQuery();
        $q->getQuerySettings()->setRespectStoragePage(false);
        return $q->execute();
    }

}