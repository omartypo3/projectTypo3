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
 * The repository for Events
 */
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
        $query->matching($query->logicalOr($query->like('name', '%' . $keyword . '%'),
            $query->like('start_date', '%' . $keyword . '%'),
            $query->like('end_date', '%' . $keyword . '%'),
            $query->like('place', '%' . $keyword . '%')));
        return $query->execute();
    }

    /**
     * @param $ids
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByUids($ids)
    {
        $query = $this->createQuery();
        $query->matching($query->in('uid', $ids));
        return $query->execute();
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findCurrentAndUpcoming()
    {
        $query = $this->createQuery();
        $query->matching($query->logicalOr($query->greaterThanOrEqual('start_date', date('Y-m-d')), $query->greaterThanOrEqual('end_date', date('Y-m-d'))));
        return $query->execute();
    }
}
