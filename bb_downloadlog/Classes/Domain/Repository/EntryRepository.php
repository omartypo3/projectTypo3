<?php
namespace BravoBuero\BbDownloadlog\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
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
 * The repository for Entries
 */
class EntryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'zeitpunkt' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );
    
    /**
     * @param int $fileUid
     * @param string $userGroup
     */
    public function findByFileUid($fileUid, $userGroup = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->equals('file', $fileUid);
		
		
/*		
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $groupRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenFegroupsRepository');
        //$groupUidForKundenLogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('groupUidForKundenLogin');
		$groupUidForKundenLogin = 2;
        $userGroup = $groupRepository->findByUid($groupUidForKundenLogin);
		$andConstraints[] = $query->contains('feusergroups', $userGroup);
*/		
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }

}