<?php
namespace DentNetSearch\Dentnetsearch\Domain\Repository;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***
 *
 * This file is part of the "DentNetSearch" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
/**
 * The repository for Dentists
 */
class DentistRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setIgnoreEnableFields(true);
        $defaultQuerySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }
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
}
