<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * The repository for Mitarbeiters
 */
class MitarbeiterRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'initialien' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(7));
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param string $initialien
     */
    public function findByInitialien($initialien)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $constraints = array();
        $constraints[] = $query->equals('initialien', $initialien);
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute()->getFirst();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Fegroups $fegroup
     */
    public function findByGroup($fegroup)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->contains('usergroup', $fegroup);
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Fegroups> $fegroups
     */
    public function findByGroups($fegroups)
    {
        $query = $this->createQuery();
        $constraints = array();
        $orConstraints = array();
        foreach ($fegroups as $fegroup) {
            $orConstraints[] = $query->contains('usergroup', $fegroup);
        }
        if (count($orConstraints)) {
            $constraints[] = $query->logicalOr($orConstraints);
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }
}
