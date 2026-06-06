<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Domain\Repository\QueryBuilder;

use Doctrine\DBAL\Exception;
use Stratis\StratisSocialAuth\Traits\QueryBuilderTrait;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class BaseRepository
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
abstract class BaseRepository
{
    use QueryBuilderTrait;

    protected string $table;

    /**
     * BaseRepository constructor.
     */
    abstract public function __construct();

    /**
     * @param int $uid
     *
     * @return array|null
     * @throws Exception
     */
    public function findByUid(int $uid): ?array
    {
        $queryBuilder = $this->getQueryBuilder($this->table);

        return $queryBuilder
            ->select('*')
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->executeQuery()
            ->fetchAssociative() ?: null;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function fetchAll(): array
    {
        return $this->getQueryBuilder($this->table)
            ->select('*')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws Exception
     */
    public function fetchByParams(array $params = []): array
    {
        $query = $this->getQueryBuilder($this->table)
            ->select('*');

        foreach ($params as $key => $value) {
            $query->andWhere(
                $query->expr()->eq($key, $query->createNamedParameter($value, \PDO::PARAM_STR))
            );
        }

        return $query->executeQuery()
            ->fetchAllAssociative() ?: [];
    }

    /**
     * @param int   $uid
     * @param array $values
     */
    public function update(int $uid, array $values): void
    {
        $query = $this->getQueryBuilder($this->table)
            ->update($this->table);

        foreach ($values as $key => $value) {
            $query->set($key, $value);
        }

        $query->where(
            $query->expr()->eq('uid', $uid)
        )
            ->executeStatement();
    }

    /**
     * @param array $values
     *
     * @return int
     */
    public function create(array $values): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $queryBuilder
            ->insert($this->table)
            ->values($values)
            ->executeStatement();

        return (int)$queryBuilder->getConnection()->lastInsertId();
    }

    /**
     * @param int $uid
     */
    public function delete(int $uid): void
    {
        $queryBuilder = $this->getQueryBuilder($this->table);
        $queryBuilder
            ->delete($this->table)
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->executeStatement();
    }

    /**
     * @param int $uid
     *
     * @return bool
     * @throws Exception
     */
    public function exist(int $uid): bool
    {
        $queryBuilder = $this->getQueryBuilder($this->table);

        return $queryBuilder
            ->select('uid')
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->executeQuery()
            ->rowCount() > 0;
    }
}
