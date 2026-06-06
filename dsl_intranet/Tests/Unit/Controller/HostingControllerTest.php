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
class HostingControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\HostingController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\HostingController::class))
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
    public function listActionFetchesAllHostingsFromRepositoryAndAssignsThemToView(): void
    {
        $allHostings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $hostingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allHostings));
        $this->subject->_set('hostingRepository', $hostingRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('hostings', $allHostings);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenHostingToView(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hosting', $hosting);

        $this->subject->showAction($hosting);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenHostingToHostingRepository(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $hostingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingRepository->expects(self::once())->method('add')->with($hosting);
        $this->subject->_set('hostingRepository', $hostingRepository);

        $this->subject->createAction($hosting);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenHostingToView(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hosting', $hosting);

        $this->subject->editAction($hosting);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenHostingInHostingRepository(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $hostingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingRepository->expects(self::once())->method('update')->with($hosting);
        $this->subject->_set('hostingRepository', $hostingRepository);

        $this->subject->updateAction($hosting);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenHostingFromHostingRepository(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $hostingRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingRepository->expects(self::once())->method('remove')->with($hosting);
        $this->subject->_set('hostingRepository', $hostingRepository);

        $this->subject->deleteAction($hosting);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenHostingToView(): void
    {
        $hosting = new \DslFactory\DslIntranet\Domain\Model\Hosting();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hosting', $hosting);

        $this->subject->editAction($hosting);
    }

}
