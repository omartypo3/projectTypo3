<?php

namespace DLD\Dld\Domain\Repository;

use TYPO3\CMS\Core\Utility;

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
 * The repository for SessionPeoples
 */
class SessionPeopleRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);
    }

    public function findPeople($sessionUid)
    {
        $query = $this->createQuery();
        $query->matching($query->in('session_id', $sessionUid));
        return $query->execute();
    }

    public function delete($id)
    {
        $query = $this->createQuery();
        $query->statement('DELETE FROM  tx_dld_domain_model_sessionpeople WHERE', array('session_id', $id));
        $query->execute();
    }

    public function findAllT()
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals("is_speaker", 1)
            ));
        $query->setLimit(5);
        // $query->setLimit(20);

        return $query->execute();
    }

    /**
     *
     * @param int $event_id
     * @param string $company
     * @param string $name
     * @param int $limit
     * @param int $offset
     */
    public function getSpeakersByEventId($event_id, $company, $name, $lastnames, $limit = 21, $offset = 0)
    {

        if ($event_id == 0) {
            $query = $this->createQuery();
            $query->statement('SELECT DISTINCT * FROM tx_dld_domain_model_sessionpeople s Left join fe_users fe on fe.uid = s.people_id
    WHERE s.is_speaker = 1  and fe.deleted = 0 and fe.company like "%' . $company . '%" and fe.first_name like "%' . $name . '%" and fe.last_name like "%' . $lastnames . '%" GROUP By s.people_id LIMIT ' . $limit . ' OFFSET ' . $offset . ';');
            return $query->execute();
        } else {
            $query = $this->createQuery();
            $query->statement('SELECT DISTINCT * FROM tx_dld_domain_model_sessionpeople s Left join fe_users fe on fe.uid = s.people_id WHERE s.deleted=0 and session_id IN (SELECT uid FROM tx_dld_domain_model_session WHERE event_id =' . $event_id . ')  and fe.deleted = 0  and fe.company like "%' . $company . '%" and fe.first_name like "%' . $name . '%" and fe.last_name like "%' . $lastnames . '%" LIMIT ' . $limit .' OFFSET ' . $offset .'; ');
            return $query->execute();
        }

    }
}