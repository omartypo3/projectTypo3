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
 * The repository for Aufgabens
 */
class AufgabenRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $mitarbeiterRepository = NULL;

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        //$querySettings->setRespectStoragePage(FALSE);
        // neue Storage IDs
        $querySettings->setStoragePageIds(array(9));
        $this->setDefaultQuerySettings($querySettings);
    }

	    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag
     */
    public function findByAuftrag($auftrag){
		 $query = $this->createQuery();
		 $query->matching($query->equals('auftrag', $auftrag));
		 $posts = $query->execute();
        
         return $posts;
	}
		
		
	
    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @param \DateTime $begin
     * @param \DateTime $end
     */
    public function findByDateFilter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL, \DateTime $begin = NULL, \DateTime $end = NULL)
    {
		$this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');

        $query = $this->createQuery();
        $constraints = array();
        if ($mitarbeiter !== NULL) {
            $orConstraints = array();
            $settings = $mitarbeiter->getSettingsAufgaben();
			/*if(isset($settings['aufgabenmitarbeiters'])){
				foreach ($settings['aufgabenmitarbeiters'] as $mitarbeiterUid) {
					if ($ma = $this->mitarbeiterRepository->findByUid($mitarbeiterUid)) {
						$orConstraints[] = $query->equals('mitarbeiter', $ma);
					}
				}

			}else{
                if ($ma = $this->mitarbeiterRepository->findByUid((int)$settings)) {
                    $orConstraints[] = $query->equals('mitarbeiter', $ma);
                }
            }*/
			
			if($settings){
				$settings = explode(",", $settings);

				foreach ($settings as $mitarbeiterUid) {
					if ($ma = $this->mitarbeiterRepository->findByUid($mitarbeiterUid)) {
						$orConstraints[] = $query->equals('mitarbeiter', $ma);
					}
				}

			}

            if (count($orConstraints)) {
                $constraints[] = $query->logicalOr($orConstraints);
            } else {
                return false;
            }
        }
        if ($begin !== NULL) {
            $constraints[] = $query->greaterThanOrEqual('begin', $begin);
        }
        if ($end !== NULL) {
            $constraints[] = $query->lessThanOrEqual('end', $end);
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @param \DateTime $begin
     * @param \DateTime $end
     */
    public function findByMitarbeiterDateFilter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter = NULL, \DateTime $begin = NULL, \DateTime $end = NULL)
    {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('mitarbeiter', $mitarbeiter);
        if ($begin !== NULL) {
            $constraints[] = $query->greaterThanOrEqual('begin', $begin);
        }
        if ($end !== NULL) {
            $constraints[] = $query->lessThanOrEqual('end', $end);
        }
        if (count($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }
        $posts = $query->execute();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        return $posts;
    }
}
