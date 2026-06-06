<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Traits;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Trait QueryBuilderTrait
 *
 * @author Vladimir Cherednichenko <vova.cherednichenko.stratis@gmail.com>
 */
trait QueryBuilderTrait
{
    /**
     * @param string      $tableName
     * @param string|null $tableAlias
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilder(string $tableName, ?string $tableAlias = null): QueryBuilder
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder->select('*')->from($tableName, $tableAlias);
    }
}
