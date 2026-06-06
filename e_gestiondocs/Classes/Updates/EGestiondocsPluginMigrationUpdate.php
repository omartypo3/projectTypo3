<?php
declare(strict_types=1);

namespace Emagineurs\EGestiondocs\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;


#[UpgradeWizard('eGestiondocsPluginMigration')]
class EGestiondocsPluginMigrationUpdate implements UpgradeWizardInterface
{
    /**
     * Mapping from e_gestiondocs switchableControllerActions to new list_type
     */
    private const ACTION_TO_LIST_TYPE_MAPPING = [
        'Document->list' => 'egestiondocs_list',
        'Document->search' => 'egestiondocs_search',
        'Document->listNew' => 'egestiondocs_listnew',
        'Document->browse' => 'egestiondocs_browse',
        'Document->listSelected' => 'egestiondocs_listselected',
    ];

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'eGestiondocsPluginMigration';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'EXT:e_gestiondocs - Migrate plugins to new structure';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'EXT:e_gestiondocs: Migrates old egestiondocs_gestiondocs plugin records with switchableControllerActions '
            . 'to new separate e_gestiondocs plugins (egestiondocs_list, egestiondocs_search, '
            . 'egestiondocs_listnew, egestiondocs_browse, egestiondocs_listselected) '
            . 'based on the selected action in the flexform. This wizard searches for plugins with list_type '
            . '"egestiondocs_gestiondocs" and updates them to the corresponding new plugin type.';
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
                // Update the list_type to new e_gestiondocs plugin
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
     * Get all tt_content records with old e_gestiondocs plugin signature
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
                    $queryBuilder->createNamedParameter('egestiondocs_gestiondocs')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Determine the new e_gestiondocs list_type based on the switchableControllerActions in flexform
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
        
        // Try to get switchableControllerActions from e_gestiondocs flexform
        $actions = $flexformData['data']['general']['lDEF']['switchableControllerActions']['vDEF'] ?? null;
        
        if (empty($actions)) {
            // Fallback: if no action found, default to list
            return 'egestiondocs_list';
        }
        
        // Extract the first action from the actions string (format: "Document->list;Document->search")
        $actionParts = GeneralUtility::trimExplode(';', $actions, true);
        $firstAction = $actionParts[0] ?? '';
        
        // Map the e_gestiondocs action to the new list_type
        foreach (self::ACTION_TO_LIST_TYPE_MAPPING as $actionKey => $listType) {
            if (str_starts_with($firstAction, $actionKey)) {
                return $listType;
            }
        }
        
        // Default fallback to list
        return 'egestiondocs_list';
    }

    /**
     * @return ConnectionPool
     */
    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}

