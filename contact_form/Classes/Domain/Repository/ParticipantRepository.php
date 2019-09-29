<?php

namespace LeadGeneration\ContactForm\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/***
 *
 * This file is part of the "Lead Generation contact form" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * The repository for Participants
 */
class ParticipantRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * @param $keyword
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByKeyword($keyword)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalOr(
            $query->like('first_name', '%' . $keyword . '%'),
            $query->like('last_name', '%' . $keyword . '%'),
            $query->like('email', '%' . $keyword . '%')));
        return $query->execute();
    }

    /**
     * @param int $eventid
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByEvent($eventid)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('event.uid', $eventid));
        return $query->execute();
    }
}
