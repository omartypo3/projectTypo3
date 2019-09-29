<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Repository;

/***
 *
 * This file is part of the "aaaaa" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 aaaaaa <chaari.ons93@gmail.com>
 *
 ***/

/**
 * The repository for Links
 */
class LinkevRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);

        $this->setDefaultQuerySettings($querySettings);
    }
}
