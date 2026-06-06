<?php

declare(strict_types=1);

namespace Emagineurs\EMagineurs\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('fixTextmediaImagePaths')]
class FixTextmediaImagePathsUpgradeWizard implements UpgradeWizardInterface
{
    public function getTitle(): string
    {
        return 'Fix Textmedia Image Paths';
    }

    public function getDescription(): string
    {
        return 'Fixes image paths in textmedia content elements: '
            . 'Transforms src="fileadmin/..." to src="/fileadmin/..." in img tags';
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
            $updatedBodytext = $this->fixImagePaths($record['bodytext']);
            
            if ($updatedBodytext !== $record['bodytext']) {
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

        $records = $queryBuilder
            ->select('uid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('textmedia')),
                $queryBuilder->expr()->like('bodytext', $queryBuilder->createNamedParameter('%<img%'))
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
        return (bool)preg_match('/<img[^>]+src=["\']fileadmin\//i', $bodytext);
    }

    protected function fixImagePaths(string $bodytext): string
    {
        
        $pattern = '/(<img[^>]+src=["\'])(fileadmin\/[^"\']*)(["\'])/i';
        
        $bodytext = preg_replace_callback($pattern, function ($matches) {
            $beforeSrc = $matches[1];  // <img ... src=" or <img ... src='
            $oldPath = $matches[2];    // fileadmin/...
            $afterSrc = $matches[3];   // " or '
            
            $newPath = '/' . $oldPath;
            
            return $beforeSrc . $newPath . $afterSrc;
        }, $bodytext);

        return $bodytext;
    }
}

