<?php

namespace NITSAN\NsRevolutionSlider\Slots;

use Doctrine\DBAL\Exception\TableNotFoundException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Schema\SchemaMigrator;
use TYPO3\CMS\Core\Database\Schema\SqlReader;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Setup
 */
class InstallUtility
{

    /**
     * @var AppPath
     */
    protected $appPath;

    public function executeOnSignal($extname = null)
    {
        if ($extname == 'ns_revolution_slider') {
            $dbConnection = GeneralUtility::makeInstance(ConnectionPool::class);
            $queryBuilder = $dbConnection->getQueryBuilderForTable('wp_options');
            $tableNotExist = false;
            $rows = [];
            try {
                $rows = $queryBuilder
                    ->select('*')
                    ->from('wp_options')
                    ->execute()
                    ->fetchAll();
            } catch (TableNotFoundException $e) {
                $tableNotExist = true;
            }
            if (count($rows) === 0 && $tableNotExist) {
                $this->updateDatabase();
            }
        }
        return;
    }

    /**
     * Executes all safe database statements.
     * Tables and fields are created and altered. Nothing gets deleted or renamed here.
     */
    public function updateDatabase()
    {
        // Instances
        $sqlReader = GeneralUtility::makeInstance(SqlReader::class);
        $schemaMigrator = GeneralUtility::makeInstance(SchemaMigrator::class);
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('*');

        $sqlAlterStatements = [];
        $sqlAlterStatements[] = file_get_contents(GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/wp-dump/structure.sql'));
        $sqlAlterStatements = $sqlReader->getStatementArray(implode(LF . LF, array_filter($sqlAlterStatements)));
        foreach ($sqlAlterStatements as $sqlStatement) {
            $statement = $connectionPool->prepare($sqlStatement);
            $statement->execute();
        }

        $sqlInsertStatements = [];
        $sqlInsertStatements[] = file_get_contents(GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/wp-dump/data.sql'));
        $sqlInsertStatements = $sqlReader->getStatementArray(implode(LF . LF, array_filter($sqlInsertStatements)));
        $schemaMigrator->importStaticData($sqlInsertStatements);
    }

    /**
     * Executes all safe database statements.
     * Tables and fields are created and altered. Nothing gets deleted or renamed here.
     */
    public function schemaUpdate()
    {
        // Instances
        if ( file_exists(GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/wp-dump/update.sql')) ) {
            $sqlReader = GeneralUtility::makeInstance(SqlReader::class);
            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('*');

            $sqlAlterStatements = [];
            $sqlAlterStatements[] = file_get_contents(GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/wp-dump/update.sql'));
            $sqlAlterStatements = $sqlReader->getStatementArray(implode(LF . LF, array_filter($sqlAlterStatements)));
            foreach ($sqlAlterStatements as $sqlStatement) {
                $statement = $connectionPool->prepare($sqlStatement);
                $statement->execute();
            }
        }
    }
}
