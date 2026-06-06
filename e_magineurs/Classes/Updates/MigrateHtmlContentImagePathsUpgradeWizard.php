<?php

declare(strict_types=1);

namespace Emagineurs\EMagineurs\Updates;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('migrateHtmlContentImagePaths')]
class MigrateHtmlContentImagePathsUpgradeWizard implements UpgradeWizardInterface
{
    public function getTitle(): string
    {
        return 'Migrate HTML Content Image Paths';
    }

    public function getDescription(): string
    {
        return 'Migrates paths in HTML content elements: '
            . '1. Image src paths from typo3conf/ext/ to fileadmin/emagineurs/ + filename, '
            . '2. Background-image URLs from /typo3conf/ext to /fileadmin/emagineurs/, ';
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    public function updateNecessary(): bool
    {
        return $this->checkIfWizardIsRequired();
    }

    public function executeUpdate(): bool
    {
        return $this->performMigration();
    }

    protected function checkIfWizardIsRequired(): bool
    {
        $records = $this->getRecordsToMigrate();
        return count($records) > 0;
    }

    protected function performMigration(): bool
    {
        $records = $this->getRecordsToMigrate();
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        foreach ($records as $record) {
            $updatedBodytext = $this->migrateImagePaths($record['bodytext']);
            
            if ($updatedBodytext !== $record['bodytext']) {
                // Create a new query builder for each update
                $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
                $queryBuilder
                    ->update('tt_content')
                    ->set('bodytext', $updatedBodytext)
                    ->where(
                        $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($record['uid'], Connection::PARAM_INT))
                    )
                    ->executeStatement();
            }
        }

        return true;
    }

    protected function getRecordsToMigrate(): array
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $orConditions = CompositeExpression::or(
            $queryBuilder->expr()->like('bodytext', $queryBuilder->createNamedParameter('%typo3conf/ext/%')),
            $queryBuilder->expr()->like('bodytext', $queryBuilder->createNamedParameter('%style="background-image: url(/typo3conf/ext%')),
            $queryBuilder->expr()->like('bodytext', $queryBuilder->createNamedParameter('%href="/qui-sommes-nous%'))
        );

        $records = $queryBuilder
            ->select('uid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('html')),
                $orConditions
            )
            ->executeQuery()
            ->fetchAllAssociative();

        $filteredRecords = [];
        foreach ($records as $record) {
            if ($this->needsMigration($record['bodytext'])) {
                $filteredRecords[] = $record;
            }
        }

        return $filteredRecords;
    }

    protected function needsMigration(string $bodytext): bool
    {
        return (bool)(
            preg_match('/<img[^>]+src=["\']([^"\']*typo3conf\/ext\/[^"\']*)["\']/i', $bodytext) ||
            preg_match('/style=["\']background-image:\s*url\([^)]*\/typo3conf\/ext/i', $bodytext) ||
            preg_match('/href=["\']\/qui-sommes-nous/i', $bodytext)
        );
    }

    protected function migrateImagePaths(string $bodytext): string
    {
        $pattern = '/(<img[^>]+src=["\'])([^"\']*typo3conf\/ext\/[^"\']*)(["\'])/i';
        $bodytext = preg_replace_callback($pattern, function ($matches) {
            $beforeSrc = $matches[1]; 
            $oldPath = $matches[2];  
            $afterSrc = $matches[3];  
            
            $pathWithoutParams = parse_url($oldPath, PHP_URL_PATH);
            if ($pathWithoutParams === null) {
                $pathWithoutParams = $oldPath;
            }
            
            $filename = basename($pathWithoutParams);
            
            // Only proceed if we have a valid filename
            if (empty($filename)) {
                return $matches[0]; 
            }
            
            $newPath = '/fileadmin/emagineurs/' . $filename;
            
            return $beforeSrc . $newPath . $afterSrc;
        }, $bodytext);

        $bodytext = preg_replace_callback(
            '/style=["\']background-image:\s*url\(([^)]*\/typo3conf\/ext[^)]*)\)/i',
            function ($matches) {
                $oldPath = $matches[1]; 
                
                // Remove query parameters and fragments if any
                $pathWithoutParams = parse_url($oldPath, PHP_URL_PATH);
                if ($pathWithoutParams === null) {
                    $pathWithoutParams = $oldPath;
                }
                
                // Extract filename from path (everything after the last slash)
                $filename = basename($pathWithoutParams);
                
                // Only proceed if we have a valid filename
                if (empty($filename)) {
                    return $matches[0]; 
                }
                
                $newPath = '/fileadmin/emagineurs/' . $filename;
                
                return 'style="background-image: url(' . $newPath . ')';
            },
            $bodytext
        );

        $bodytext = preg_replace(
            '/href=["\']\/qui-sommes-nous/i',
            'href="/institution/qui-sommes-nous',
            $bodytext
        );

        return $bodytext;
    }
}

