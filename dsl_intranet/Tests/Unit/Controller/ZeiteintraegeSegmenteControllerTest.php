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
class ZeiteintraegeSegmenteControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\ZeiteintraegeSegmenteController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\ZeiteintraegeSegmenteController::class))
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
    public function listActionFetchesAllZeiteintraegeSegmentesFromRepositoryAndAssignsThemToView(): void
    {
        $allZeiteintraegeSegmentes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $zeiteintraegeSegmenteRepository->expects(self::once())->method('findAll')->will(self::returnValue($allZeiteintraegeSegmentes));
        $this->subject->_set('zeiteintraegeSegmenteRepository', $zeiteintraegeSegmenteRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('zeiteintraegeSegmentes', $allZeiteintraegeSegmentes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenZeiteintraegeSegmenteToView(): void
    {
        $zeiteintraegeSegmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zeiteintraegeSegmente', $zeiteintraegeSegmente);

        $this->subject->showAction($zeiteintraegeSegmente);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenZeiteintraegeSegmenteToZeiteintraegeSegmenteRepository(): void
    {
        $zeiteintraegeSegmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();

        $zeiteintraegeSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeSegmenteRepository->expects(self::once())->method('add')->with($zeiteintraegeSegmente);
        $this->subject->_set('zeiteintraegeSegmenteRepository', $zeiteintraegeSegmenteRepository);

        $this->subject->createAction($zeiteintraegeSegmente);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenZeiteintraegeSegmenteToView(): void
    {
        $zeiteintraegeSegmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zeiteintraegeSegmente', $zeiteintraegeSegmente);

        $this->subject->editAction($zeiteintraegeSegmente);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenZeiteintraegeSegmenteInZeiteintraegeSegmenteRepository(): void
    {
        $zeiteintraegeSegmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();

        $zeiteintraegeSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeSegmenteRepository->expects(self::once())->method('update')->with($zeiteintraegeSegmente);
        $this->subject->_set('zeiteintraegeSegmenteRepository', $zeiteintraegeSegmenteRepository);

        $this->subject->updateAction($zeiteintraegeSegmente);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenZeiteintraegeSegmenteFromZeiteintraegeSegmenteRepository(): void
    {
        $zeiteintraegeSegmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();

        $zeiteintraegeSegmenteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeSegmenteRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeSegmenteRepository->expects(self::once())->method('remove')->with($zeiteintraegeSegmente);
        $this->subject->_set('zeiteintraegeSegmenteRepository', $zeiteintraegeSegmenteRepository);

        $this->subject->deleteAction($zeiteintraegeSegmente);
    }
}
