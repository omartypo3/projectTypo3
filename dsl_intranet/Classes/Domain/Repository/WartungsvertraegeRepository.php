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
 * The repository for Wartungsvertraeges
 */
class WartungsvertraegeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(25));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param integer $oldid
     */
    public function findByOldid($oldid)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('oldid', $oldid)));
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    public function findAllActive()
    {
        //$querySettings = $this->getDefaultQuerySettings($querySettings);
        //$querySettings->setIgnoreEnableFields(false);
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(false);
        return $query->execute();
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     */
    public function findByZeitraum(\DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->contains('zeitraeume', $wartungsvertraegeZeitraeume);
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
     * @param array $settings
     */
    public function findByFilter($settings)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        foreach ($settings as $key => $value) {
            //echo "<br>".$key.":".print_r($value,1);
            if (is_array($value)) {
                $orConstraints = array();
                switch ($key) {
                    case 'kundens':    foreach ($value as $wert) {
                            $orConstraints[] = $query->equals('kunde', $wert);
                        }
                        break;
                }
                if (count($orConstraints)) {
                    $andConstraints[] = $query->logicalOr($orConstraints);
                }
            }
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        //$query->matching($query->logicalAnd($query->equals('oldid', $oldid)));
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    public function anzahlByKunde()
    {
        $query = $this->createQuery();
        $query->statement('SELECT kunde, count(kunde) as anzahl FROM tx_dslintranet_domain_model_auftraege WHERE deleted=0 AND hidden=0 AND FIND_IN_SET(pid,\'25\') GROUP BY kunde');
        $anzahlByKunde = $query->execute(TRUE);
        $resArr = array();
        foreach ($anzahlByKunde as $value) {
            $resArr[$value['kunde']] = $value['anzahl'];
        }
        return $resArr;
    }
}
