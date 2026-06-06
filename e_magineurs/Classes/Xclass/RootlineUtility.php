<?php
namespace Emagineurs\EMagineurs\Xclass;

use Doctrine\DBAL\DBALException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A utility resolving and Caching the Rootline generation
 */
class RootlineUtility extends \TYPO3\CMS\Core\Utility\RootlineUtility
{
    protected function enrichWithRelationFields(int $uid, array $pageRecord): array
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        // @todo Remove this special interpretation of relations by consequently using RelationHandler
        foreach ($GLOBALS['TCA']['pages']['columns'] as $column => $configuration) {
            // Ensure that only fields defined in $rootlineFields (and "addRootLineFields") are actually evaluated
            if (array_key_exists($column, $pageRecord) && $this->columnHasRelationToResolve($configuration)) {
                $configuration = $configuration['config'];
                if (!empty($configuration['MM'])) {
                    /** @var $loadDBGroup \TYPO3\CMS\Core\Database\RelationHandler */
                    $loadDBGroup = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\RelationHandler::class);
                    $loadDBGroup->start(
                        $pageRecord[$column],
                        // @todo That depends on the type (group, select, inline)
                        isset($configuration['allowed']) ? $configuration['allowed'] : $configuration['foreign_table'],
                        $configuration['MM'],
                        $uid,
                        'pages',
                        $configuration
                    );
                    $relatedUids = isset($loadDBGroup->tableArray[$configuration['foreign_table']])
                        ? $loadDBGroup->tableArray[$configuration['foreign_table']]
                        : [];
                } else {
                    // @todo The assumption is wrong, since group can be used without "MM", but having "allowed"
                    $table = $configuration['foreign_table'];

                    $queryBuilder = $connectionPool->getQueryBuilderForTable($table);
                    $queryBuilder->getRestrictions()->removeAll()
                        ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
                        ->add(GeneralUtility::makeInstance(HiddenRestriction::class));
                    $queryBuilder->select('uid')
                        ->from($table)
                        ->where(
                            $queryBuilder->expr()->eq(
                                $configuration['foreign_field'],
                                $queryBuilder->createNamedParameter(
                                    $uid,
                                    \PDO::PARAM_INT
                                )
                            )
                        );

                    if (isset($configuration['foreign_match_fields']) && is_array($configuration['foreign_match_fields'])) {
                        foreach ($configuration['foreign_match_fields'] as $field => $value) {
                            $queryBuilder->andWhere(
                                $queryBuilder->expr()->eq(
                                    $field,
                                    $queryBuilder->createNamedParameter($value, \PDO::PARAM_STR)
                                )
                            );
                        }
                    }
                    if (isset($configuration['foreign_table_field'])) {
                        $queryBuilder->andWhere(
                            $queryBuilder->expr()->eq(
                                trim($configuration['foreign_table_field']),
                                $queryBuilder->createNamedParameter(
                                    (int)$this->languageUid > 0 ? 'pages_language_overlay' : 'pages',
                                    \PDO::PARAM_STR
                                )
                            )
                        );
                    }

                    if ($GLOBALS['TCA'] [$table]['ctrl']['versioningWS'] ?? false) {
                        if($this->getWsid() > 0) {
                            $queryBuilder->andWhere(
                                $queryBuilder->expr()->or(
                                    $queryBuilder->expr()->eq(
                                        't3ver_wsid',
                                        $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                                    ),
                                    $queryBuilder->expr()->eq(
                                        't3ver_wsid',
                                        $queryBuilder->createNamedParameter($this->getWsid(), \PDO::PARAM_INT)
                                    )
                                )
                            );
                        } else {
                            $queryBuilder->andWhere(
                                $queryBuilder->expr()->eq(
                                    't3ver_wsid',
                                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                                )
                            );
                        }
                    }

                    if (isset($configuration['foreign_sortby'])) {
                        $queryBuilder->orderBy($configuration['foreign_sortby']);
                    }
                    try {
                        $statement = $queryBuilder->executeQuery();
                        $relatedUids = [];
                        while ($row = $statement->fetchAssociative()) {
                            $relatedUids[] = $row['uid'];
                        }
                    } catch (DBALException | \Doctrine\DBAL\Exception $e) {
                        $relatedUids = [];
                    }
                }
                $pageRecord[$column] = implode(',', $relatedUids);
            }
        }
        return $pageRecord;
    }

    protected function getWsid(): int
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        $queryParams = $request ? $request->getQueryParams() : [];
        
        if (($queryParams['previewWS'] ?? null) === 'live' || ($queryParams['workspacePreview'] ?? null) === 'live') {
            return 0;
        }

        if (isset($queryParams['previewWS'])) {
            return (int)$queryParams['previewWS'];
        }

        if (isset($queryParams['workspacePreview'])) {
            return (int)$queryParams['workspacePreview'];
        }

        if (isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER'] !== null && is_object($GLOBALS['BE_USER']) && isset($GLOBALS['BE_USER']->workspaceRec) && is_array($GLOBALS['BE_USER']->workspaceRec)) {
            return (int)$GLOBALS['BE_USER']->workspaceRec['uid'];
        }

        return 0;
    }
}
