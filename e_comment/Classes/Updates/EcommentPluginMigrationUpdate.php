<?php
declare(strict_types=1);

namespace Emagineurs\EComment\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;


#[UpgradeWizard('eCommentPluginMigration')]
class EcommentPluginMigrationUpdate implements UpgradeWizardInterface
{
    /**
     * Mapping from ecomment switchableControllerActions to new list_type
     */
    private const ACTION_TO_LIST_TYPE_MAPPING = [
        'Comment->comment' => 'ecomment_comment',
        'Comment->search' => 'ecomment_search',
        'Comment->list' => 'ecomment_list',
        'Comment->add' => 'ecomment_add',
        'Comment->validate' => 'ecomment_validate',
    ];

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'ecommentPluginMigration';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'EXT:e_comment - Migrate plugins to new structure';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'EXT:e_comment: Migrates old ecomment_comment plugin records with switchableControllerActions '
            . 'to new separate e_comment plugins (ecomment_comment, ecomment_search, '
            . 'ecomment_list, ecomment_add, ecomment_validate) '
            . 'based on the selected action in the flexform. This wizard searches for plugins with list_type '
            . '"ecomment_comment" and updates them to the corresponding new plugin type.';
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
                // Update the list_type to new ecomment plugin
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
     * Get all tt_content records with old ecomment plugin signature
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
                    $queryBuilder->createNamedParameter('ecomment_comment')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Determine the new ecomment list_type based on the switchableControllerActions in flexform
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
            return 'ecomment_comment';
        }
        
        $actionParts = GeneralUtility::trimExplode(';', $actions, true);
        $firstAction = $actionParts[0] ?? '';
        
        foreach (self::ACTION_TO_LIST_TYPE_MAPPING as $actionKey => $listType) {
            if (str_starts_with($firstAction, $actionKey)) {
                return $listType;
            }
        }
        
        return 'ecomment_comment';
    }

    /**
     * @return ConnectionPool
     */
    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}
