<?php
namespace Wng\WngCvciNews\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
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

/**
 * EventEmailRepository
 */
class EventEmailRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * Find EventEmail by a Event
     *
     * @param integer $id id de l'événement
     * @param string $sortby champ de trie
     * @param string $order ordre de trie
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    public function findByEventOrder($id='',$sortby='',$order='') {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('event', $id)
        );
        $order = ($order == 'desc') ? QueryInterface::ORDER_DESCENDING : QueryInterface::ORDER_ASCENDING;
        $query->setOrderings(
            array(
                $sortby => $order
            )
        );
        return $query->execute();
    }


    /**
     * Find EventEmail by a Event
     *
     * @param integer $id id de l'événement
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    public function findByEventShow($id='') {
        $query = $this->createQuery();

        // don't add the pid constraint
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        $query->matching(
            $query->logicalAnd(
                $query->equals('event', $id),
                $query->equals('apparaitre', 1)
            )
        );
        /** @var Typo3DbQueryParser $queryParser */
        /*$queryParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->parseQuery($query));*/
        return $query->execute();
    }
}
?>