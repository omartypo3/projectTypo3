<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
/***
 *
 * This file is part of the "FRONTAL / Institutionen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Roland Kneubühler <rk@frontal.ch>, Agentur Frontal AG
 *
 ***/

/**
 * The repository for Institutions
 */
class RoleRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject() {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);

        $this->setDefaultQuerySettings($querySettings);
    }

    public function deleteByUserAndInstitution($user, $institution)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $affectedRows = $queryBuilder
            ->delete('tx_faginstitutionmanagement_domain_model_role')
            ->where(
                $queryBuilder->expr()->gt('user', $queryBuilder->createNamedParameter($user, \PDO::PARAM_INT)),
                $queryBuilder->expr()->gt('institution', $queryBuilder->createNamedParameter($institution, \PDO::PARAM_INT))
            )
            ->execute();
    }

    public function findByUserAndInstitution($user, $institution)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $affectedRows = $queryBuilder->select('*')->from('tx_faginstitutionmanagement_domain_model_role')
            ->where(
                $queryBuilder->expr()->eq('user', $queryBuilder->createNamedParameter($user, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('institution', $queryBuilder->createNamedParameter($institution, \PDO::PARAM_INT))
            )
            ->execute()->fetch();
        return $affectedRows;
    }
    public function userIsAdmin($user)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $affectedRows = $queryBuilder->count('*')->from('tx_faginstitutionmanagement_domain_model_role')
            ->where(
                $queryBuilder->expr()->eq('user', $queryBuilder->createNamedParameter($user, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('isadmin', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
            )
            ->execute()->fetch();
        return $affectedRows;
    }
    public function userIsAdminByInstitution($user, $institution)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $affectedRows = $queryBuilder->count('*')->from('tx_faginstitutionmanagement_domain_model_role')
            ->where(
                $queryBuilder->expr()->eq('user', $queryBuilder->createNamedParameter($user, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('institution', $queryBuilder->createNamedParameter($institution, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('isadmin', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))

            )
            ->execute()->fetch();
        return $affectedRows;
    }

    public function userByInstitution($user)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $affectedRows = $queryBuilder->select('institution')->from('tx_faginstitutionmanagement_domain_model_role')
            ->where(
                $queryBuilder->expr()->eq('user', $queryBuilder->createNamedParameter((int)$user, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('hidden', 0),
                $queryBuilder->expr()->eq('deleted', 0)

            )
            ->execute();
        return $affectedRows;
    }
}
