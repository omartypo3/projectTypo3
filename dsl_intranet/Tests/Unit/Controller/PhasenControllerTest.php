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
class PhasenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\PhasenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\PhasenController::class))
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
    public function listActionFetchesAllPhasensFromRepositoryAndAssignsThemToView(): void
    {
        $allPhasens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $phasenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\PhasenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $phasenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPhasens));
        $this->subject->_set('phasenRepository', $phasenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('phasens', $allPhasens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPhasenToView(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('phasen', $phasen);

        $this->subject->showAction($phasen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPhasenToPhasenRepository(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();

        $phasenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\PhasenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $phasenRepository->expects(self::once())->method('add')->with($phasen);
        $this->subject->_set('phasenRepository', $phasenRepository);

        $this->subject->createAction($phasen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPhasenToView(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('phasen', $phasen);

        $this->subject->editAction($phasen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPhasenInPhasenRepository(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();

        $phasenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\PhasenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $phasenRepository->expects(self::once())->method('update')->with($phasen);
        $this->subject->_set('phasenRepository', $phasenRepository);

        $this->subject->updateAction($phasen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPhasenFromPhasenRepository(): void
    {
        $phasen = new \DslFactory\DslIntranet\Domain\Model\Phasen();

        $phasenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\PhasenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $phasenRepository->expects(self::once())->method('remove')->with($phasen);
        $this->subject->_set('phasenRepository', $phasenRepository);

        $this->subject->deleteAction($phasen);
    }
}
