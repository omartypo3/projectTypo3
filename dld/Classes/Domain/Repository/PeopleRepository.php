<?php

namespace DLD\Dld\Domain\Repository;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * The repository for Peoples
 */
class PeopleRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings = array(
        'amazing_speaker_sort_order' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);


    }

    public function getPeoples()
    {
        $query = $this->createQuery();
        return $query->execute();

    }

    public function getAmazingSpeakers()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('is_amazing_speaker', 1));
        return $query->execute();

    }

    /**
     * @param array $list
     * @param string $order
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getDldteam($list, $order = "")
    {
        $query = $this->createQuery();
        $query->matching($query->in('uid', $list));
        if ($order == 'DESC') {
            $query->setOrderings(
                [
                    'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
                ]
            );
        } else {
            $query->setOrderings(
                [
                    'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                ]
            );
        }
        return $query->execute();

    }

    public function GetByNewCreatedAt()
    {
        $t = new \DateTime('NOW');
        $searchTime = $t->modify('-1 minutes');
//        \TYPO3\CMS\Core\Utility\DebugUtility::debug($searchTime);die();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->greaterThanOrEqual('crdate', $searchTime),
                    $query->equals('highrise_person_id', 0)

                ]
            )
        );
        return $query->execute();
    }

    public function getByUpdatedPeople()
    {
        $t = new \DateTime('NOW');
        $searchTime = $t->modify('-1 minutes');
        $query = $this->createQuery();
        $query->matching($query->greaterThanOrEqual('tstamp', $searchTime)
        );
        return $query->execute();
    }


    public function getByDeletedPeople()
    {
        $t = new \DateTime('NOW');
        $searchTime = $t->modify('-1 minutes');
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setIncludeDeleted(True);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('deleted', 1),
                    $query->greaterThanOrEqual('tstamp', $searchTime),
                ]
            )
        );
        return $query->execute();

    }

    /**
     * @param string $eventprefix
     * @return int
     */

    public function getCountAppliedPeopleByEvent($eventprefix)
    {
        $query = $this->createQuery();
        $query->matching($query->like('tags', $eventprefix));
        return $query->execute()->count();

    }

    /**
     * @param string $eventprefix
     * @return int
     */

    public function getCountInvitedPeopleByEvent($eventprefix)
    {
        $query = $this->createQuery();
        $query->matching($query->like('tags', $eventprefix));
        return $query->execute()->count();

    }

//    /**
//     * @param int $offset
//     * @param int $limit
//     * @return int
//     */
//    public function getYoutubeVideos( $offset = 0, $limit = 10)
//    {
//        $query = $this->createQuery();
//        $const = $query->greaterThanOrEqual('uid', 1);
//        if ($speaker != 0) {
//            $const = $query->equals('uid', $speaker);
//        }
//        $query->matching(
//            $query->logicalAnd(
//                $query->like('company', '%' . $company . '%'),
//                $query->logicalNot($query->equals('youtubevideos', null)),
//                $const
//            )
//        );
//        return $query->execute();
//
//    }
    /**
     * @param int $limit
     * @param int $offset
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getAllspeakersWithLimit($limit = 21, $offset = 0)
    {
        $query = $this->createQuery();
        $query->statement("SELECT fe.uid , fe.first_name , fe.last_name, fe.youtubevideos, fe.company FROM  fe_users fe Left join tx_dld_domain_model_sessionpeople s on fe.uid = s.people_id WHERE s.is_speaker = 1 and fe.youtubevideos!= '' GROUP By s.people_id  LIMIT " . $limit . " OFFSET " . $offset . ";");
        return $query->execute();
    }

/**

     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getAllspeakers()
    {
        $query = $this->createQuery();
        $query->statement("SELECT fe.uid , fe.first_name , fe.last_name ,  fe.youtubevideos , fe.company FROM  fe_users fe Left join tx_dld_domain_model_sessionpeople s on fe.uid = s.people_id WHERE s.is_speaker = 1 and fe.youtubevideos != '' GROUP By s.people_id");
        return $query->execute();
    }
}
