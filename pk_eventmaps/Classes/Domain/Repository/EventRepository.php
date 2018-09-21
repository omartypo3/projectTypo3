<?php

namespace EventMaps\PkEventmaps\Domain\Repository;

/***
 *
 * This file is part of the "EventMaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Patrick Kudla, Avonis
 *
 ***/

/**
 * The repository for Events
 */
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * action findSorted
     *
     * @return void
     */
    public function findSorted()
    {
        $query = $this->createQuery();
        $query->setOrderings(
            array(
                'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
            )
        );

        return $query->execute();
    }

}
