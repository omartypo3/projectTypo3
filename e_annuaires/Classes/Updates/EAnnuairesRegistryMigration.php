<?php
declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Updates;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Configuration\ConfigurationManager;

#[UpgradeWizard('eannuairesRegistryMigration')]
class EAnnuairesRegistryMigration implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'eannuairesRegistryMigration';
    }

    public function getTitle(): string
    {
        return 'Migrate tx_eannuaires registry values to TYPO3 13';
    }

    public function getDescription(): string
    {
        return 'Migrates old tx_eannuaires registry values (confAnnuaires & locallangPath) into ExtensionConfiguration for TYPO3 13.';
    }

    public function getPrerequisites(): array
    {
        return [DatabaseUpdatedPrerequisite::class];
    }

    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_registry');

        $schemaManager = $connection->createSchemaManager();
        if (!$schemaManager->tablesExist(['sys_registry'])) {
            return false;
        }

        $row = $connection->select(['entry_value'], 'sys_registry', [
            'entry_namespace' => 'tx_eannuaires',
        ])->fetchAssociative();

        return !empty($row); // migration needed if registry entries exist
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_registry');

        $conf = [];

        // Check if sys_registry table exists
        $schemaManager = $connection->createSchemaManager();
        if ($schemaManager->tablesExist(['sys_registry'])) {
            $row = $connection->select(['entry_value'], 'sys_registry', [
                'entry_namespace' => 'tx_eannuaires',
                'entry_key' => 'confAnnuaires',
            ])->fetchAssociative();
            $conf['confAnnuaires'] = $row ? @unserialize($row['entry_value']) : [];
          
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] = $conf;
       
        return true;
    }
}
