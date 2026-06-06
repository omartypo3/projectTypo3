<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_event_mgt" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Pingag\PingagAddress\Domain\Repository;

use DERHANSEN\SfEventMgt\Domain\Model\Dto\EventDemand;
use DERHANSEN\SfEventMgt\Event\ModifyEventQueryConstraintsEvent;
use DERHANSEN\SfEventMgt\Service\CategoryService;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Events
 */
class EventRepository extends \DERHANSEN\SfEventMgt\Domain\Repository\EventRepository
{
    public function findEventAjax($categoryUid)
    {
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $query = $this->createQuery();


        $query->matching(
            $query->logicalAnd(
                $query->logicalOr(
                    $query->like('title', '%' . $categoryUid . '%'),
                    $query->like('teaser', '%' . $categoryUid . '%'),
                    $query->like('description', '%' . $categoryUid . '%')
                ),
                $query->equals('hidden', 0),
                $query->equals('deleted', 0),
                $query->greaterThan('startdate', new \DateTime()),
                $query->equals('sys_language_uid', $sys_language_uid)
            )
        );
        $query->setOrderings(
            [
                'startdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,

            ]
        );
        return $query->execute();

    }

    /**
     * Returns the objects of this repository matching the given demand
     *
     * @param EventDemand $eventDemand EventDemand
     *
     * @return array|QueryResultInterface QueryResultInterface
     */
    public function findDemanded(EventDemand $eventDemand)
    {
        $constraints = [];
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields($eventDemand->getIgnoreEnableFields());

        $this->setStoragePageConstraint($query, $eventDemand, $constraints);
        $this->setDisplayModeConstraint($query, $eventDemand, $constraints);
        $this->setCategoryConstraint($query, $eventDemand, $constraints);
        $this->setLocationConstraint($query, $eventDemand, $constraints);
        $this->setLocationCityConstraint($query, $eventDemand, $constraints);
        $this->setLocationCountryConstraint($query, $eventDemand, $constraints);
        $this->setSpeakerConstraint($query, $eventDemand, $constraints);
        $this->setOrganisatorConstraint($query, $eventDemand, $constraints);
        $this->setStartEndDateConstraint($query, $eventDemand, $constraints);
        $this->setSearchConstraint($query, $eventDemand, $constraints);
        $this->setTopEventConstraint($query, $eventDemand, $constraints);
        $this->setYearMonthDayRestriction($query, $eventDemand, $constraints);

        $modifyEventQueryConstraintsEvent = new ModifyEventQueryConstraintsEvent(
            $constraints,
            $query,
            $eventDemand,
            $this
        );
        $this->eventDispatcher->dispatch($modifyEventQueryConstraintsEvent);
        $constraints = $modifyEventQueryConstraintsEvent->getConstraints();

        $this->setOrderingsFromDemand($query, $eventDemand);

        if (count($constraints) > 0) {
            $query->matching(
                $query->logicalAnd(
                    $constraints,
                    $query->greaterThan('startdate', new \DateTime())
                ));
        }

        $this->setQueryLimitFromDemand($query, $eventDemand);

        return $query->execute();
    }

    public function getFlexform($pid)
    {
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $query = $this->createQuery();
        $query->statement('SELECT pi_flexform FROM tt_content WHERE pid ='.$pid.' AND list_type = \'sfeventmgt_pieventlist\' And sys_language_uid ='.$sys_language_uid);
        $resultat = $query->execute();
        return $resultat;
    }
}
