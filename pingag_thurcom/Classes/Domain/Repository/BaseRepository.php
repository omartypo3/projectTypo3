<?php

namespace Pingag\PingagThurcom\Domain\Repository;
use GeorgRinger\News\Service\CategoryService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 16:45
 */
abstract class BaseRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param array $uids
     * @return array
     */
    public function findByUids(array $uids)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('uid', $uids));
        return $query->execute()->toArray();
    }

    /**
     * Returns a category constraint created by
     * a given list of categories and a junction string
     *
     * @param QueryInterface $query
     * @param  array $categories
     * @param  string $conjunction
     * @param  bool $includeSubCategories
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface|null
     */
    protected function createCategoryConstraint(
        QueryInterface $query,
        $categories,
        $conjunction,
        $includeSubCategories = false
    ) {
        $constraint = null;
        $categoryConstraints = [];

        // If "ignore category selection" is used, nothing needs to be done
        if (empty($conjunction)) {
            return $constraint;
        }

        if (!is_array($categories)) {
            $categories = GeneralUtility::intExplode(',', $categories, true);
        }
        foreach ($categories as $category) {
            if ($includeSubCategories) {
                $subCategories = GeneralUtility::trimExplode(',',
                    CategoryService::getChildrenCategories($category, 0, '', true), true);
                $subCategoryConstraint = [];
                $subCategoryConstraint[] = $query->contains('categories', $category);
                if (count($subCategories) > 0) {
                    foreach ($subCategories as $subCategory) {
                        $subCategoryConstraint[] = $query->contains('categories', $subCategory);
                    }
                }
                if ($subCategoryConstraint) {
                    $categoryConstraints[] = $query->logicalOr($subCategoryConstraint);
                }
            } else {
                $categoryConstraints[] = $query->contains('categories', $category);
            }
        }

        if ($categoryConstraints) {
            switch (strtolower($conjunction)) {
                case 'or':
                    $constraint = $query->logicalOr($categoryConstraints);
                    break;
                case 'notor':
                    $constraint = $query->logicalNot($query->logicalOr($categoryConstraints));
                    break;
                case 'notand':
                    $constraint = $query->logicalNot($query->logicalAnd($categoryConstraints));
                    break;
                case 'and':
                default:
                    $constraint = $query->logicalAnd($categoryConstraints);
            }
        }

        return $constraint;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult
     * @param bool $explainOutput
     */
    public function debugQuery(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult, $explainOutput = FALSE)
    {
        $GLOBALS['TYPO3_DB']->debugOutput = 2;
        if ($explainOutput) {
            $GLOBALS['TYPO3_DB']->explainOutput = true;
        }
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;
        $queryResult->toArray();
        DebuggerUtility::var_dump($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);

        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = false;
        $GLOBALS['TYPO3_DB']->explainOutput = false;
        $GLOBALS['TYPO3_DB']->debugOutput = false;
    }
}