<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Service;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AppSettingsStorage
{
    private const TABLE = 'tx_stratismobileapp_domain_model_appsettings';

    public function fetch(): ?array
    {
        $queryBuilder = $this->getConnection()->createQueryBuilder();
        $row = $queryBuilder
            ->select('*')
            ->from(self::TABLE)
            ->orderBy('uid', 'ASC')
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $row ?: null;
    }

    public function save(string $version, ?int $uid): array
    {
        $connection = $this->getConnection();
        $timestamp = time();

        if ($uid !== null) {
            $connection->update(
                self::TABLE,
                [
                    'version' => $version,
                    'tstamp' => $timestamp,
                ],
                ['uid' => $uid]
            );

            return $this->fetchByUid($uid);
        }

        $connection->insert(
            self::TABLE,
            [
                'pid' => 0,
                'crdate' => $timestamp,
                'tstamp' => $timestamp,
                'version' => $version,
            ]
        );

        $newUid = (int)$connection->lastInsertId(self::TABLE);
        if ($newUid === 0) {
            $row = $this->fetch();
            if ($row) {
                return $row;
            }
        } else {
            $row = $this->fetchByUid($newUid);
            if ($row) {
                return $row;
            }
        }

        return [
            'uid' => $newUid,
            'pid' => 0,
            'version' => $version,
            'crdate' => $timestamp,
            'tstamp' => $timestamp,
        ];
    }

    private function fetchByUid(int $uid): ?array
    {
        $queryBuilder = $this->getConnection()->createQueryBuilder();
        $row = $queryBuilder
            ->select('*')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $row ?: null;
    }

    private function getConnection(): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::TABLE);
    }
}

