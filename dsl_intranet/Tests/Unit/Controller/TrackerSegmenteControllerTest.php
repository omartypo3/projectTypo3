<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class TrackerSegmenteControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\TrackerSegmenteController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\TrackerSegmenteController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllTrackerSegmentesFromRepositoryAndAssignsThemToView(): void
    {
        $allTrackerSegmentes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $trackerSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $trackerSegmenteRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTrackerSegmentes));
        $this->subject->_set('trackerSegmenteRepository', $trackerSegmenteRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('trackerSegmentes', $allTrackerSegmentes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenTrackerSegmenteToView(): void
    {
        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('trackerSegmente', $trackerSegmente);

        $this->subject->showAction($trackerSegmente);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenTrackerSegmenteToTrackerSegmenteRepository(): void
    {
        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();

        $trackerSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $trackerSegmenteRepository->expects(self::once())->method('add')->with($trackerSegmente);
        $this->subject->_set('trackerSegmenteRepository', $trackerSegmenteRepository);

        $this->subject->createAction($trackerSegmente);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenTrackerSegmenteToView(): void
    {
        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('trackerSegmente', $trackerSegmente);

        $this->subject->editAction($trackerSegmente);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenTrackerSegmenteInTrackerSegmenteRepository(): void
    {
        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();

        $trackerSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $trackerSegmenteRepository->expects(self::once())->method('update')->with($trackerSegmente);
        $this->subject->_set('trackerSegmenteRepository', $trackerSegmenteRepository);

        $this->subject->updateAction($trackerSegmente);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenTrackerSegmenteFromTrackerSegmenteRepository(): void
    {
        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();

        $trackerSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TrackerSegmenteRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $trackerSegmenteRepository->expects(self::once())->method('remove')->with($trackerSegmente);
        $this->subject->_set('trackerSegmenteRepository', $trackerSegmenteRepository);

        $this->subject->deleteAction($trackerSegmente);
    }
}
