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
class AuftraegeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AuftraegeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AuftraegeController::class))
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
    public function listActionFetchesAllAuftraegesFromRepositoryAndAssignsThemToView(): void
    {
        $allAuftraeges = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $auftraegeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAuftraeges));
        $this->subject->_set('auftraegeRepository', $auftraegeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('auftraeges', $allAuftraeges);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAuftraegeToView(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftraege', $auftraege);

        $this->subject->showAction($auftraege);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAuftraegeToAuftraegeRepository(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $auftraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeRepository->expects(self::once())->method('add')->with($auftraege);
        $this->subject->_set('auftraegeRepository', $auftraegeRepository);

        $this->subject->createAction($auftraege);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAuftraegeToView(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftraege', $auftraege);

        $this->subject->editAction($auftraege);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAuftraegeInAuftraegeRepository(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $auftraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeRepository->expects(self::once())->method('update')->with($auftraege);
        $this->subject->_set('auftraegeRepository', $auftraegeRepository);

        $this->subject->updateAction($auftraege);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAuftraegeFromAuftraegeRepository(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $auftraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeRepository->expects(self::once())->method('remove')->with($auftraege);
        $this->subject->_set('auftraegeRepository', $auftraegeRepository);

        $this->subject->deleteAction($auftraege);
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAuftraegeToView(): void
    {
        $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftraege', $auftraege);

        $this->subject->showAction($auftraege);
    }
}
