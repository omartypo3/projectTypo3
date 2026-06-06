<?php
declare(strict_types=1);

namespace Emagineurs\ENews\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('enewsAdvancedViewsPluginMigration')]
class EnewsAdvancedViewsPluginMigrationUpdate implements UpgradeWizardInterface
{
    /**
     * Mapping from e_news advanced view switchableControllerActions to new list_type
     */
    private const ACTION_TO_LIST_TYPE_MAPPING = [
        'News->filterToday' => 'enews_filtertoday',
        'News->filterWeekend' => 'enews_filterweekend',
        'News->filterWeek' => 'enews_filterweek',
        'News->filterMonth' => 'enews_filtermonth',
        'News->create;News->add;News->validate' => 'enews_createnews',
        'News->delete' => 'enews_deletenews',
        'News->validate' => 'enews_validatenews',
    ];

    public function getIdentifier(): string
    {
        return 'enewsAdvancedViewsPluginMigration';
    }

    public function getTitle(): string
    {
        return 'EXT:e_news - Migrate advanced views to new plugins';
    }

    public function getDescription(): string
    {
        return 'EXT:e_news: Migrates old news_pi1 plugin records with advanced view switchableControllerActions '
            . '(filterToday, filterWeekend, filterWeek, filterMonth, create, delete, validate) '
            . 'to new separate e_news plugins. This wizard searches for plugins with list_type "news_pi1" '
            . 'and specific advanced view actions, and updates them to the corresponding new plugin types.';
    }

    public function executeUpdate(): bool
    {
        $connection = $this->getConnectionPool()->getConnectionForTable('tt_content');
        
        $records = $this->getOldPluginRecords();
        
        foreach ($records as $record) {
            $newListType = $this->determineNewListType($record['pi_flexform'] ?? '');
            
            if ($newListType !== null) {
                // Update the list_type to new e_news plugin
                $connection->update(
                    'tt_content',
                    ['list_type' => $newListType],
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
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    /**
     * Get all tt_content records with old news_pi1 plugin that have advanced view actions
     *
     * @return array
     */
    protected function getOldPluginRecords(): array
    {
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        
        $records = $queryBuilder
            ->select('uid', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('news_pi1')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
        
        // Filter only records that have advanced view actions
        $filteredRecords = [];
        foreach ($records as $record) {
            if (empty($record['pi_flexform'])) {
                continue;
            }
            
            $flexformData = GeneralUtility::xml2array($record['pi_flexform']);
            if (!is_array($flexformData)) {
                continue;
            }
            
            $actions = $flexformData['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'] ?? '';
            
            // Check if this record has any of our advanced view actions
            foreach (array_keys(self::ACTION_TO_LIST_TYPE_MAPPING) as $actionKey) {
                if (str_starts_with($actions, $actionKey)) {
                    $filteredRecords[] = $record;
                    break;
                }
            }
        }
        
        return $filteredRecords;
    }

    /**
     * Determine the new e_news list_type based on the switchableControllerActions in flexform
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
        
        // Try to get switchableControllerActions from e_news flexform
        $actions = $flexformData['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'] ?? null;
        
        if (empty($actions)) {
            return null;
        }
        
        // Extract the first action from the actions string
        $actionParts = GeneralUtility::trimExplode(';', $actions, true);
        $firstAction = implode(';', $actionParts); // Reconstruct the full action string
        
        // Map the e_news action to the new list_type
        foreach (self::ACTION_TO_LIST_TYPE_MAPPING as $actionKey => $listType) {
            if (str_starts_with($firstAction, $actionKey)) {
                return $listType;
            }
        }
        
        return null;
    }

    /**
     * @return ConnectionPool
     */
    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}

