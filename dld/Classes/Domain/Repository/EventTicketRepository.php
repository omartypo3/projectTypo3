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
 * The repository for EventTicket
 */

class EventTicketRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);
    }
    /**
     * @param int $conferenceID
     * @param string $highriseSuffix
     * @return int
     */
    public function findEventTicket($conferenceID, $highriseSuffix){
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('highrise_tag_suffix',$highriseSuffix),
                $query->equals('conference_id',$conferenceID)
            )
        );
        return $query->execute()->count();
    }

    public function findConferenceId($confId){
        $query = $this->createQuery();
        $query->matching($query->equals('conference_id', $confId));
        return $query->execute();
    }
}