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
class ProtokollePendingControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\ProtokollePendingController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\ProtokollePendingController::class))
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
    public function listActionFetchesAllProtokollePendingsFromRepositoryAndAssignsThemToView(): void
    {
        $allProtokollePendings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $protokollePendingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $protokollePendingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProtokollePendings));
        $this->subject->_set('protokollePendingRepository', $protokollePendingRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('protokollePendings', $allProtokollePendings);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProtokollePendingToView(): void
    {
        $protokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('protokollePending', $protokollePending);

        $this->subject->showAction($protokollePending);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenProtokollePendingToProtokollePendingRepository(): void
    {
        $protokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();

        $protokollePendingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokollePendingRepository->expects(self::once())->method('add')->with($protokollePending);
        $this->subject->_set('protokollePendingRepository', $protokollePendingRepository);

        $this->subject->createAction($protokollePending);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProtokollePendingToView(): void
    {
        $protokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('protokollePending', $protokollePending);

        $this->subject->editAction($protokollePending);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenProtokollePendingInProtokollePendingRepository(): void
    {
        $protokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();

        $protokollePendingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokollePendingRepository->expects(self::once())->method('update')->with($protokollePending);
        $this->subject->_set('protokollePendingRepository', $protokollePendingRepository);

        $this->subject->updateAction($protokollePending);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenProtokollePendingFromProtokollePendingRepository(): void
    {
        $protokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();

        $protokollePendingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokollePendingRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokollePendingRepository->expects(self::once())->method('remove')->with($protokollePending);
        $this->subject->_set('protokollePendingRepository', $protokollePendingRepository);

        $this->subject->deleteAction($protokollePending);
    }
}
