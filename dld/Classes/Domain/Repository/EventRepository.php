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
 * The repository for Events
 */
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setIgnoreEnableFields(true);
        $defaultQuerySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        $this->setDefaultQuerySettings($defaultQuerySettings);

    }

    public function findVisibleEvents()
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0)
            )
        );
        return $query->execute();

    }


    public function getLatestEvents()
    {
        $query = $this->createQuery();

        $query->matching(
            $query->equals('is_visible', 1)
        );

        $query->setOrderings(['uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING]);
        return $query->execute()->getFirst();
    }

    /**
     * @param int $modeluid
     */
    public function removeFileRefrence($modeluid)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder
            ->delete('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($modeluid, \PDO::PARAM_INT))
            )
            ->execute();
    }

    /**
     * @param int $eventId
     */
    public function resetStart($eventId)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dld_domain_model_event');
        $queryBuilder
            ->update('tx_dld_domain_model_event')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($eventId, \PDO::PARAM_INT))
            )
            ->set('start', '0')
            ->execute();
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


    public function findUpcomingEvents($city = "")
    {

        $query = $this->createQuery();
        $constraint = $query->greaterThanOrEqual('uid', 1);
        if ($city) {

            $constraint = $query->equals('venueId.city', $city);

        }
        $query->matching(
            $query->logicalAnd(
                $query->greaterThan('start', 0),
                $query->greaterThanOrEqual('start', new \DateTime()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0),
                $constraint
            )

        );
        return $query->execute();

    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findPastEvents($offset = 0, $limit = 10, $city = "")
    {


        $query = $this->createQuery();
        $constraint = $query->greaterThanOrEqual('uid', 1);
        if ($city) {

            $constraint = $query->equals('venueId.city', $city);

        }
        $query->matching(
            $query->logicalAnd(
                $query->greaterThan('start', 0),
                $query->lessThan('start', new \DateTime()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0),
                $constraint
            ));
        $query->setOrderings(
            [
                'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,

            ]
        );
        $query->setOffset($offset);
        if ($limit >= 0) {
            $query->setLimit($limit);
        } elseif ($limit > 10) {
            $query->setLimit(10);
        }
        return $query->execute();

    }

    public function countPastEvents($city = "")
    {

        $query = $this->createQuery();
        $constraint = $query->greaterThanOrEqual('uid', 1);
        if ($city) {

            $constraint = $query->equals('venueId.city', $city);

        }
        $query->matching(
            $query->logicalAnd(
                $query->greaterThan('start', 0),
                $query->lessThan('start', new \DateTime()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0),
                $constraint
            ));

        return $query->execute()->count();
    }

    /**
     * @param string $order
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findEvents($order = "")
    {
        $date = new \DateTime('midnight');
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($date->getTimestamp());die();
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->greaterThan('start', $date->getTimestamp()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0)
            )
        );
        if ($order == 'DESC') {
            $query->setOrderings(
                [
                    'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
                ]
            );
        } else {
            $query->setOrderings(
                [
                    'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                ]
            );
        }

        $query->setLimit(3);


        return $query->execute();


    }

    /**
     * @param int $old
     * @param int $new
     * @return array
     */
    public function mainSlider($old = 2, $new = 3)
    {
        $date = new \DateTime('midnight');
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($date->getTimestamp());die();
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->lessThan('start', $date->getTimestamp()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0)
            )
        );

        $query->setOrderings(
            [
                'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            ]
        );
        $query->setLimit($old);
        $totalold = $query->execute();



        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->greaterThanOrEqual('start', $date->getTimestamp()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0)
            )
        );
        $query->setOrderings(
            [
                'start' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            ]
        );
        $query->setLimit($new);
        $totalnew = $query->execute();

        $res = array();
        $res1 = array();

        foreach ($totalnew as $item)
            $res[] = $item;
        foreach ($totalold as $item)
            $res1[] = $item;
        $res1 = array_reverse($res1);

        return array_merge($res,$res1);


    }

    /**
     * @param int $contenttId
     */
    public function getContent($contenttId)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        return $queryBuilder
            ->select('pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($contenttId, \PDO::PARAM_INT))
            )
            ->execute()->fetch();
    }

    /**
     * @param int $contenttId
     * @param string $flexform
     */
    public function setContent($contenttId, $flexform)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder
            ->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($contenttId, \PDO::PARAM_INT))
            )
            ->set('pi_flexform', $flexform)
            ->execute();
    }

    /**
     * @param int $pageId
     */
    public function getPageTitle($pageId)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        return $queryBuilder
            ->select('title')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($pageId, \PDO::PARAM_INT))
            )
            ->execute()->fetch();
    }

    /**
     * @param int $pageId
     * @param string $title
     */
    public function setPagetitle($pageId, $title)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder
            ->update('pages')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($pageId, \PDO::PARAM_INT))
            )
            ->set('title', $title)
            ->execute();
    }

    public function findByXing()
    {
        $query = $this->createQuery();
        $query->matching($query->greaterThan('xing_event_id', 0));
        return $query->execute();

    }

    public function findNextUpcoming()
    {

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->greaterThan('start', 0),
                $query->greaterThanOrEqual('start', new \DateTime()),
                $query->equals('is_visible', 1),
                $query->equals('showPage.hidden', 0)
            )

        );
        return $query->execute()->getFirst();

    }

    public function getTagPrefix()
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_event WHERE tag_prefix !="" ');
        $resultat = $query->execute();
        return $resultat;
    }

}
