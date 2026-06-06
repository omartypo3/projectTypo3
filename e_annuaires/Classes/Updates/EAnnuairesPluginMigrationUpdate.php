<?php
declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;

#[UpgradeWizard('eAnnuairesPluginMigration')]
class EAnnuairesPluginMigrationUpdate implements UpgradeWizardInterface
{
    /**
     * Mapping from e_annuaires switchableControllerActions to new list_type
     */
    private const ACTION_TO_LIST_TYPE_MAPPING = [
        'Fiche->list' => 'eannuaires_pi1',
        'Fiche->show' => 'eannuaires_show',
        'Fiche->catmenu' => 'eannuaires_catmenu',
        'Fiche->search' => 'eannuaires_search',
        'Fiche->resultat' => 'eannuaires_resultat',
        'Editfe->manage' => 'eannuaires_gestion',
        'Fiche->sendMail' => 'eannuaires_sendmail',
    ];

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'eAnnuairesPluginMigration';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'EXT:e_annuaires - Migrate plugins to new structure';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'EXT:e_annuaires: Migrates old egestiondocs_gestiondocs plugin records with switchableControllerActions '
            . 'to new separate e_annuaires plugins (eannuaires_pi1, eannuaires_show, '
            . 'eannuaires_catmenu, eannuaires_search, eannuaires_resultat, eannuaires_gestion, eannuaires_sendmail) '
            . 'based on the selected action in the flexform. This wizard searches for plugins with list_type '
            . '"eannuaires_pi1" and updates them to the corresponding new plugin type.';
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
                // Update the list_type to new e_annuaires plugin
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
     * Get all tt_content records with old e_annuaires plugin signature
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
                    $queryBuilder->createNamedParameter('eannuaires_pi1')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Determine the new e_annuaires list_type based on the switchableControllerActions in flexform
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
        
        // Try to get switchableControllerActions from e_annuaires flexform
        $actions = $flexformData['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'] ?? null;
        
        if (empty($actions)) {
            // Fallback: if no action found, default to list
            return 'eannuaires_pi1';
        }
        
        // Extract the first action from the actions string (format: "Fiche->list;Fiche->show")
        $actionParts = GeneralUtility::trimExplode(';', $actions, true);
        $firstAction = $actionParts[0] ?? '';
        
        // Map the e_gestiondocs action to the new list_type
        foreach (self::ACTION_TO_LIST_TYPE_MAPPING as $actionKey => $listType) {
            if (str_starts_with($firstAction, $actionKey)) {
                return $listType;
            }
        }
        
        // Default fallback to list
        return 'eannuaires_pi1';
    }

    /**
     * @return ConnectionPool
     */
    protected function getConnectionPool(): ConnectionPool
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}

