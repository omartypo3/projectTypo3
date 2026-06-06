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
class ZeiteintraegeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\ZeiteintraegeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\ZeiteintraegeController::class))
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
    public function listActionFetchesAllZeiteintraegesFromRepositoryAndAssignsThemToView(): void
    {
        $allZeiteintraeges = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $zeiteintraegeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allZeiteintraeges));
        $this->subject->_set('zeiteintraegeRepository', $zeiteintraegeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('zeiteintraeges', $allZeiteintraeges);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenZeiteintraegeToView(): void
    {
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zeiteintraege', $zeiteintraege);

        $this->subject->showAction($zeiteintraege);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenZeiteintraegeToZeiteintraegeRepository(): void
    {
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();

        $zeiteintraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeRepository->expects(self::once())->method('add')->with($zeiteintraege);
        $this->subject->_set('zeiteintraegeRepository', $zeiteintraegeRepository);

        $this->subject->createAction($zeiteintraege);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenZeiteintraegeToView(): void
    {
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zeiteintraege', $zeiteintraege);

        $this->subject->editAction($zeiteintraege);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenZeiteintraegeInZeiteintraegeRepository(): void
    {
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();

        $zeiteintraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeRepository->expects(self::once())->method('update')->with($zeiteintraege);
        $this->subject->_set('zeiteintraegeRepository', $zeiteintraegeRepository);

        $this->subject->updateAction($zeiteintraege);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenZeiteintraegeFromZeiteintraegeRepository(): void
    {
        $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();

        $zeiteintraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZeiteintraegeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeiteintraegeRepository->expects(self::once())->method('remove')->with($zeiteintraege);
        $this->subject->_set('zeiteintraegeRepository', $zeiteintraegeRepository);

        $this->subject->deleteAction($zeiteintraege);
    }
}
