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
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * The repository for Sessions
 */
class SessionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);
    }


    /**
     *
     * @param  $venue
     *
     */
    public function haveVenue($venue)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('venue_id', $venue));
        return $query->execute()->count();

    }

    public function getStartFromSession($id)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('event_id', $id),
                $query->equals('is_visible', 1)
            )
        );
        $query->setOrderings(
            [
                'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            ]
        );
        return $query->execute()->getFirst();
    }

    /**
     *
     * @param  $event
     *
     */
    public function findEventSessions($event)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('event_id', $event),
                $query->equals('is_visible', 1)
            )
        );
        return $query->execute();

    }

    /**
     *
     * @param  $event
     *
     */
    public function findEventSessionsDate($event)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $event . ' GROUP BY DATE_FORMAT( FROM_UNIXTIME(start) , "%d %m %y" )');
        $resultat = $query->execute();
        return $resultat;

    }

    /**
     *
     * @param  $event
     *
     */
    public function findEnd($event)
    {
        $query = $this->createQuery();
        $query->setOrderings([
            'end' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
        ]);
        $query->matching($query->equals('event_id', $event));
        return $query->execute()->getFirst();

    }

    /**
     *
     * @param  $event
     *
     */
    public function findAllSessions($event)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('event_id', $event)
        );
        return $query->execute();

    }

    /**
     * @param \DateTime $start
     * @param $event
     *
     */
    public function findByStart($start, $event)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $event . ' and DATE_FORMAT( FROM_UNIXTIME(start) , "%d %m %Y" ) = "' . $start->format('d m Y') . '"ORDER BY start');
        $resultat = $query->execute();
        return $resultat;

    }

    /**
     * @param  $start
     * @param $event
     *
     */
    public function findtime($event, $start)
    {
        $query = $this->createQuery();
        $query->statement('SELECT  * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $event . ' and DATE_FORMAT( FROM_UNIXTIME(start) , "%Y-%m-%d" ) = "' . $start . '" GROUP BY DATE_FORMAT( FROM_UNIXTIME(start) , "%H:%i" )  ORDER BY start');
        $resultat = $query->execute();
        return $resultat;

    }

    /**
     * @param  $start
     * @param $event
     *
     */
    public function findBytime($event, $start)
    {
        $query = $this->createQuery();
        $query->statement('SELECT  * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $event . ' and DATE_FORMAT( FROM_UNIXTIME(start) , "%Y-%m-%d %H:%i" ) = "' . $start->format('Y-m-d H:i'). '"  ORDER BY venue_id');
        $resultat = $query->execute();
        return $resultat;

    }

    /**
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     *
     */
    public function findNextSession(\DLD\Dld\Domain\Model\Session $session)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $session->getEventId()->getUid() . ' and venue_id =' . $session->getVenueId()->getUid() . ' and DATE_FORMAT( FROM_UNIXTIME(start) , "%d %m %Y" ) = "' . $session->getStart()->format('d m Y') . '" and start > ' . $session->getStart()->getTimestamp() . ' ORDER BY start ');
        $resultat = $query->execute()->getFirst();
        return $resultat;

    }

    /**
     *
     * @param \DLD\Dld\Domain\Model\Session $session
     *
     */
    public function findPerviousSession(\DLD\Dld\Domain\Model\Session $session)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $session->getEventId()->getUid() . ' and venue_id =' . $session->getVenueId()->getUid() . ' and DATE_FORMAT( FROM_UNIXTIME(start) , "%d %m %Y" ) = "' . $session->getStart()->format('d m Y') . '" and start < ' . $session->getStart()->getTimestamp() . ' ORDER BY start  Desc');
        $resultat = $query->execute()->getFirst();
        return $resultat;

    }

    /**
     *
     * @param  $event
     *
     */
    public function findEventSessionsVenue($event)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_session WHERE  is_visible = 1 and event_id =' . $event . ' GROUP BY venue_id');
        $resultat = $query->execute();
        return $resultat;

    }
}
