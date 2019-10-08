<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:21
 */

namespace Pingag\PingagThurcom\Domain\Repository;


class SubscriptionOptionRepository extends BaseRepository
{
    public function findAll()
    {
        $q = $this->createQuery();
        $q->getQuerySettings()->setRespectStoragePage(false);
        return $q->execute();
    }

    public function findByUids(array $uids)
    {
        $results = [];
        foreach ($uids as $uid) {
            $results[] = self::findByUid($uid);
        }
        return $results;
    }
}