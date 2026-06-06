<?php
namespace DslFactory\DslImmo\Domain\Repository;

/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * The repository for Imports
 */
class ImportRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    // Ändern der QuerySettings im Repository eines Models
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);
        // neue Storage IDs
        //$querySettings->setStoragePageIds(array(9, 25));
        //$querySettings->setIgnoreEnableFields(true);
        //$querySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        $this->setDefaultQuerySettings($querySettings);
    }
}
