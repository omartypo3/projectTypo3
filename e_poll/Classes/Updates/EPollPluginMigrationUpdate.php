<?php
declare(strict_types=1);

namespace Emagineurs\EPoll\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;


#[UpgradeWizard('ePollPluginMigration')]
class EPollPluginMigrationUpdate implements UpgradeWizardInterface
{
    
    private const ACTION_TO_LIST_TYPE_MAPPING = [
        'Poll->show' => 'epoll_pollsingle',
        'Poll->list' => 'epoll_polllist',
        'Poll->result' => 'epoll_pollresult',
    ];

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'ePollPluginMigration';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'EXT:e_poll - Migrate plugins to new structure';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'EXT:e_poll: Migrates old epoll_poll plugin records with switchableControllerActions '
            . 'to new separate e_poll plugins (epoll_pollsingle, epoll_polllist, epoll_pollresult) '
            . 'based on the selected action in the flexform. This wizard searches for plugins with list_type '
            . '"epoll_poll" and updates them to the corresponding new plugin type.';
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $connection = $this->getConnectionPool()->getConnectionForTable('tt_content');
        
        $records = $this->getOldPluginRecords();
        
        foreach ($records as $record) {
            $newListType = $this->determineNewListType($record['pi_flexform'] ?? '');
            
            if ($newListType !== null) {
                // Update the list_type to new e_poll plugin
                $connection->update(
                    'tt_content',
                    ['list_type' => $newListType],
                    ['uid' => (int)$record['uid']]
                );
            }
        }
        
        return true;
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $records = $this->getOldPluginRecords();
        return count($records) > 0;
    }

    /**
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    /**
     * Get all tt_content records with old e_poll plugin signature
     *
     * @return array
     */
    protected function getOldPluginRecords(): array
    {
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        
        return $queryBuilder
            ->select('uid', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('epoll_poll')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Determine the new e_poll list_type based on the switchableControllerActions in flexform
     *
     * @param string $flexformXml
     * @return string|null
     */
    protected function determineNewListType(string $flexformXml): ?string
    {
        if (empty($flexformXml)) {
            return null;
        }
        
        $flexformData = GeneralUtility::xml2array($flexformXml);
        
        if (!is_array($flexformData)) {
            return null;
        }
        
        $actions = $flexformData['data']['general']['lDEF']['switchableControllerActions']['vDEF'] ?? null;
        
        if (empty($actions)) {
            return 'epoll_pollsingle';
        }
        
        $actionParts = GeneralUtility::trimExplode(';', $actions, true);
        $firstAction = $actionParts[0] ?? '';
        
        foreach (self::ACTION_TO_LIST_TYPE_MAPPING as $actionKey => $listType) {
            if (str_starts_with($firstAction, $actionKey)) {
                return $listType;
            }
        }
        
        return 'epoll_pollsingle';
    }

    /**
     * @return ConnectionPool
     */
    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}

