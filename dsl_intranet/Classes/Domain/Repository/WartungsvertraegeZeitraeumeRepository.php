<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for WartungsvertraegeZeitraeumes
 */
class WartungsvertraegeZeitraeumeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'von' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(9, 25));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     * @param \DateTime $date
     */
    public function findByWartungsvertragForDate(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege = NULL, \DateTime $date = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('wartungsvertraege', $wartungsvertraege);
        $andConstraints[] = $query->logicalAnd(array($query->greaterThan('bis', $date->format('Y-m-d')), $query->lessThanOrEqual('von', $date->format('Y-m-d'))));
        //   $andConstraints[] = $query->equals('sichtbarkeit', 1);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        if (count($posts)) {
            return $posts->getFirst();
        }
        return false;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege
     */
    public function findByZeiteintraege(\DslFactory\DslIntranet\Domain\Model\Zeiteintraege $zeiteintraege = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->contains('zeiten', $zeiteintraege);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        //       \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        //return 999;
        $posts = $query->execute();
        if (count($posts)) {
            return $posts->getFirst();
        }
        return false;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege
     */
    public function findByWartungsvertrag(\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege $wartungsvertraege = NULL)
    {

        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('wartungsvertraege', $wartungsvertraege->getUid());
        //   $andConstraints[] = $query->equals('sichtbarkeit', 1);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
            //    \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        if (count($posts)) {
            return $posts;
        }
        return false;
    }

    public function findForNewInterval()
    {
        //where anzahl rechnungen =0
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('rechnungen', 0);
        //$query->equals('media.category', 'bar');
        //   $andConstraints[] = $query->equals('sichtbarkeit', 1);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        if (count($posts)) {
            return $posts;
        }
        return false;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen
     */
    public function findByRechnung(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen $wartungsvertraegeRechnungen = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->contains('rechnungen', $wartungsvertraegeRechnungen);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        //        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        if (count($posts)) {
            return $posts->getFirst();
        }
        return false;
    }

    public function findForMehraufwandNewStatusFaellig()
    {
        //$now = new \DateTime();
        //date_add($now, date_interval_create_from_date_string('2 months'));
        //echo $now->format('d.m.Y');
        //where anzahl rechnungen =0
        $query = $this->createQuery();
        $andConstraints = array();
        //$andConstraints[] = $query->lessThan('von', $now->format('Y-m-') . '01');
        $andConstraints[] = $query->equals('status', 0);
        $andConstraints[] = $query->equals('rechnungen.type', 20);
        //echo $now->format("Y-m-")."01";
        //$query->equals('media.category', 'bar');
        //   $andConstraints[] = $query->equals('sichtbarkeit', 1);
        if (count($andConstraints)) {
            //echo "ja";
            $query->matching($query->logicalAnd($andConstraints));
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        if (count($posts)) {
            return $posts;
        }
        return false;
    }

    /**
     * @param integer $status
     */
    public function findByStatus($status = 0)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('status', $status);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        if (count($posts)) {
            return $posts;
        }
        return false;
    }
}
