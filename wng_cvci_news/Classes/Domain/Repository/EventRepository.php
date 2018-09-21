<?php
namespace Wng\WngCvciNews\Domain\Repository;

    /***************************************************************
     *
     *  Copyright notice
     *
     *  (c) 2014
     *
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/

/**
 * EventRepository
 */
class EventRepository extends \GeorgRinger\News\Domain\Repository\NewsRepository {

    /**
     * Returns the constraint to determine if a news event is active or not (archived)
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface|null $constraint
     */
    protected function createIsActiveConstraint(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query) {
        /** @var $constraint \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface */
        $constraint = NULL;
        $timestamp  = time(); // + date('Z');

        $constraint = $query->logicalOr(
            // future events:
            $query->greaterThan('tx_wngcvcinews_start_date + tx_wngcvcinews_start_time', $timestamp),
            // current multiple day events:
            $query->logicalAnd(
                $query->lessThan('tx_wngcvcinews_start_date + tx_wngcvcinews_start_time', $timestamp),
                $query->greaterThan('tx_wngcvcinews_end_date + tx_wngcvcinews_end_time', $timestamp)
            ),
            // current single day events:
            $query->logicalAnd(
                $query->lessThan('tx_wngcvcinews_start_date + tx_wngcvcinews_start_time', $timestamp),
                $query->greaterThan('tx_wngcvcinews_start_date + tx_wngcvcinews_end_time', $timestamp),
                $query->equals('tx_wngcvcinews_end_date', 0)
            ),
            // current single day event without time:
            $query->logicalAnd(
				$query->greaterThan('tx_wngcvcinews_start_date + 86399', $timestamp),
				$query->equals('tx_wngcvcinews_start_time', 0),
				$query->equals('tx_wngcvcinews_end_date', 0),
				$query->equals('tx_wngcvcinews_end_time', 0)
			)
        );

        return $constraint;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \GeorgRinger\News\Domain\Model\DemandInterface $demand
     * @return array
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \GeorgRinger\News\Domain\Model\DemandInterface $demand) {
        $constraints    = array();

        if ($demand->getCategories() && $demand->getCategories() !== '0') {
            $constraints[] = $this->createCategoryConstraint(
                $query,
                $demand->getCategories(),
                $demand->getCategoryConjunction(),
                $demand->getIncludeSubCategories()
            );
        }

        if ($demand->getAuthor()) {
            $constraints[] = $query->equals('author', $demand->getAuthor());
        }

        // archived
        if ($demand->getArchiveRestriction() == 'archived') {
            $constraints[] = $query->logicalNot($this->createIsActiveConstraint($query));
            // non-archived (active)
        } elseif ($demand->getArchiveRestriction() == 'active') {
            $constraints[] = $this->createIsActiveConstraint($query);
        }

        // Time restriction greater than or equal
        $timeRestrictionField = $demand->getDateField();
        $timeRestrictionField = (empty($timeRestrictionField)) ? 'datetime' : $timeRestrictionField;

        if ($demand->getTimeRestriction()) {
            $timeLimit = 0;
            // integer = timestamp
            if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($demand->getTimeRestriction())) {
                $timeLimit = $GLOBALS['EXEC_TIME'] - $demand->getTimeRestriction();
            } else {
                // try to check strtotime
                $timeFromString = strtotime($demand->getTimeRestriction());

                if ($timeFromString) {
                    $timeLimit = $timeFromString;
                } else {
                    throw new \Exception('Time limit Low could not be resolved to an integer. Given was: ' . htmlspecialchars($timeLimit));
                }
            }

            $constraints[] = $query->greaterThanOrEqual(
                $timeRestrictionField,
                $timeLimit
            );
        }

        // Time restriction less than or equal
        if ($demand->getTimeRestrictionHigh()) {
            $timeLimit = 0;
            // integer = timestamp
            if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($demand->getTimeRestrictionHigh())) {
                $timeLimit = $GLOBALS['EXEC_TIME'] + $demand->getTimeRestrictionHigh();
            } else {
                // try to check strtotime
                $timeFromString = strtotime($demand->getTimeRestrictionHigh());

                if ($timeFromString) {
                    $timeLimit = $timeFromString;
                } else {
                    throw new \Exception('Time limit High could not be resolved to an integer. Given was: ' . htmlspecialchars($timeLimit));
                }
            }

            $constraints[] = $query->lessThanOrEqual(
                $timeRestrictionField,
                $timeLimit
            );
        }

        // top news
        if ($demand->getTopNewsRestriction() == 1) {
            $constraints[] = $query->equals('istopnews', 1);
        } elseif ($demand->getTopNewsRestriction() == 2) {
            $constraints[] = $query->equals('istopnews', 0);
        }

        // storage page
        if ($demand->getStoragePage() != 0) {
            $pidList = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getStoragePage(), TRUE);
            $constraints[] = $query->in('pid', $pidList);
        }

        // month & year OR year only
        if ($demand->getYear() > 0) {
            if (is_null($demand->getDateField())) {
                throw new \InvalidArgumentException('No Datefield is set, therefore no Datemenu is possible!');
            }
            if ($demand->getMonth() > 0) {
                if ($demand->getDay() > 0) {
                    $begin = mktime(0, 0, 0, $demand->getMonth(), $demand->getDay(), $demand->getYear());
                    $end = mktime(23, 59, 59, $demand->getMonth(), $demand->getDay(), $demand->getYear());
                } else {
                    $begin = mktime(0, 0, 0, $demand->getMonth(), 1, $demand->getYear());
                    $end = mktime(23, 59, 59, ($demand->getMonth() + 1), 0, $demand->getYear());
                }
            } else {
                $begin = mktime(0, 0, 0, 1, 1, $demand->getYear());
                $end = mktime(23, 59, 59, 12, 31, $demand->getYear());
            }
            $constraints[] = $query->logicalAnd(
                $query->greaterThanOrEqual($demand->getDateField(), $begin),
                $query->lessThanOrEqual($demand->getDateField(), $end)
            );
        }

        // Tags
        $tags = $demand->getTags();
        if ($tags) {
            $tagList = explode(',', $tags);

            foreach ($tagList as $singleTag) {
                $constraints[] = $query->contains('tags', $singleTag);
            }
        }

        // Search
        $searchConstraints = $this->getSearchConstraints($query, $demand);
        if (!empty($searchConstraints)) {
            $constraints[] = $query->logicalAnd($searchConstraints);
        }

        // Exclude already displayed
        if ($demand->getExcludeAlreadyDisplayedNews() && isset($GLOBALS['EXT']['news']['alreadyDisplayed']) && !empty($GLOBALS['EXT']['news']['alreadyDisplayed'])) {
            $constraints[] = $query->logicalNot(
                $query->in(
                    'uid',
                    $GLOBALS['EXT']['news']['alreadyDisplayed']
                )
            );
        }

            // events only
        $constraints[] = $query->logicalAnd($query->equals('tx_wngcvcinews_is_event', 1));

            // the event must have an event start date
        $constraints[] = $query->logicalAnd(
            $query->logicalNot(
                $query->equals('tx_wngcvcinews_start_date', 0)
            )
        );

            // Clean not used constraints
        foreach($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }

        return $constraints;
    }
}
?>