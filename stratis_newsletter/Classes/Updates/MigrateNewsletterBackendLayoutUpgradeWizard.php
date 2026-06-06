<?php

declare(strict_types=1);

namespace Stratis\StratisNewsletter\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('stratisNewsletterBackendLayoutMigration')]
class MigrateNewsletterBackendLayoutUpgradeWizard implements UpgradeWizardInterface
{
    public function getTitle(): string
    {
        return 'Migrate Stratis Newsletter Backend Layout';
    }

    public function getDescription(): string
    {
        return 'Migrates old fluidpages__grid backend layout references to the new StratisNewsletter backend layout.';
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

    
        $queryBuilder
            ->update('pages')
            ->set('backend_layout', 'pagets__StratisNewsletter')
            ->set('tx_fed_page_controller_action', '')
            ->where(
                $queryBuilder->expr()->eq('tx_fed_page_controller_action', $queryBuilder->createNamedParameter('Stratis.StratisNewsletter->newsletter')),
                $queryBuilder->expr()->neq('uid', $queryBuilder->createNamedParameter(1))
            )
            ->executeStatement();

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder
            ->update('pages')
            ->set('backend_layout_next_level', 'pagets__StratisNewsletter')
            ->set('tx_fed_page_controller_action_sub', '')
            ->where(
                $queryBuilder->expr()->eq('tx_fed_page_controller_action_sub', $queryBuilder->createNamedParameter('Stratis.StratisNewsletter->newsletter')),
                $queryBuilder->expr()->neq('uid', $queryBuilder->createNamedParameter(1))
            )
            ->executeStatement();

        return true;
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $count = $queryBuilder
            ->count('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq('tx_fed_page_controller_action', $queryBuilder->createNamedParameter('Stratis.StratisNewsletter->newsletter')),
                    $queryBuilder->expr()->eq('tx_fed_page_controller_action_sub', $queryBuilder->createNamedParameter('Stratis.StratisNewsletter->newsletter'))
                ),
                $queryBuilder->expr()->neq('uid', $queryBuilder->createNamedParameter(1))
            )
            ->executeQuery()
            ->fetchOne();

        return $count > 0;
    }

    public function getPrerequisites(): array
    {
        return [];
    }
}

