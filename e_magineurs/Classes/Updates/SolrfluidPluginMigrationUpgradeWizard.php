<?php

declare(strict_types=1);

namespace Emagineurs\EMagineurs\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('solrfluidPluginMigration')]
class SolrfluidPluginMigrationUpgradeWizard implements UpgradeWizardInterface
{
    public function getTitle(): string
    {
        return 'EXT:solrfluid - Migrate plugins to new structure';
    }

    public function getDescription(): string
    {
        return 'EXT:solrfluid: Migrates old solrfluid plugins to new solr structure. '
            . 'This wizard searches for plugins with list_type "solrfluid_pi_search" or "solrfluid_pi_result" and CType "list", '
            . 'and updates both CType and list_type to the new structure (solr_pi_search or solr_pi_results).';
    }

    public function executeUpdate(): bool
    {
        $connection = $this->getConnectionPool()->getConnectionForTable('tt_content');
        
        $records = $this->getOldPluginRecords();
        
        foreach ($records as $record) {
            $updateData = [];
            
            if ($record['list_type'] === 'solrfluid_pi_search') {
                $updateData['CType'] = 'solr_pi_search';
                $updateData['list_type'] = 'solr_pi_search';
            }
            elseif ($record['list_type'] === 'solrfluid_pi_result') {
                $updateData['CType'] = 'solr_pi_results';
                $updateData['list_type'] = 'solr_pi_results';
            }
            
            if (!empty($updateData)) {
                $connection->update(
                    'tt_content',
                    $updateData,
                    ['uid' => (int)$record['uid']]
                );
            }
        }
        
        return true;
    }

    public function updateNecessary(): bool
    {
        $records = $this->getOldPluginRecords();
        return count($records) > 0;
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    protected function getOldPluginRecords(): array
    {
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        
        return $queryBuilder
            ->select('uid', 'list_type', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq(
                        'CType',
                        $queryBuilder->createNamedParameter('list')
                    ),
                    $queryBuilder->expr()->or(
                        $queryBuilder->expr()->eq(
                            'list_type',
                            $queryBuilder->createNamedParameter('solrfluid_pi_search')
                        ),
                        $queryBuilder->expr()->eq(
                            'list_type',
                            $queryBuilder->createNamedParameter('solrfluid_pi_result')
                        )
                    )
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}

