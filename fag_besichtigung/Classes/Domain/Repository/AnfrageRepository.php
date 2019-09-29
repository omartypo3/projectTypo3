<?php
namespace FRONTAL\FagBesichtigung\Domain\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/***
 *
 * This file is part of the "besichtigung" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * The repository for Anfrages
 */
class AnfrageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    public function findHiddenByUid($uid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
        return $query->matching($query->equals('uid', (int)$uid))->execute()->getFirst();
    }
}
