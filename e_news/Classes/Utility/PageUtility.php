<?php

namespace Emagineurs\ENews\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;


class PageUtility
{
    /**
     * Extend PID list by including child pages recursively
     * This replaces the removed extendPidListByChildren() method from GeorgRinger\News\Utility\Page
     *
     * @param string $pidList Comma-separated list of page IDs
     * @param int $recursiveLevel Number of levels to traverse (0 = no recursion, -1 = unlimited)
     * @return string Comma-separated list of extended page IDs
     */
    public static function extendPidListByChildren($pidList, $recursiveLevel = 0): string
    {
        if (empty($pidList)) {
            return '';
        }

        $pidArray = GeneralUtility::intExplode(',', $pidList, true);
        $finalPidList = $pidArray;

        if ($recursiveLevel === 0) {
            return implode(',', $finalPidList);
        }

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $processedPids = [];
        $toProcess = $pidArray;
        $currentLevel = 0;

        while (!empty($toProcess) && ($recursiveLevel === -1 || $currentLevel < $recursiveLevel)) {
            $currentPid = (int)array_shift($toProcess);
            if (in_array($currentPid, $processedPids)) {
                continue;
            }
            $processedPids[] = $currentPid;

            $queryBuilder = $connectionPool->getQueryBuilderForTable('pages');
            $queryBuilder->getRestrictions()->removeAll();

            $childQuery = $queryBuilder
                ->select('uid')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($currentPid)),
                    $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0))
                );

            try {
                $childResults = $childQuery->executeQuery()->fetchAllAssociative();
            } catch (\Exception $e) {
                return $pidList;
            }

            foreach ($childResults as $child) {
                $childUid = (int)$child['uid'];
                if (!in_array($childUid, $finalPidList)) {
                    $finalPidList[] = $childUid;
                    if ($recursiveLevel === -1 || $currentLevel < $recursiveLevel - 1) {
                        $toProcess[] = $childUid;
                    }
                }
            }

            // Increment level and check limit
            if (!empty($childResults)) {
                $currentLevel++;
            }

            // Limit recursion if specified
            if ($recursiveLevel > 0 && $currentLevel >= $recursiveLevel) {
                break;
            }
        }

        return implode(',', array_unique($finalPidList));
    }
}

