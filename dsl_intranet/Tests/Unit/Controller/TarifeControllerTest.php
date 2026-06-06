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
class TarifeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\TarifeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\TarifeController::class))
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
    public function listActionFetchesAllTarivesFromRepositoryAndAssignsThemToView(): void
    {
        $allTarives = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tarifeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TarifeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $tarifeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTarives));
        $this->subject->_set('tarifeRepository', $tarifeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('tarives', $allTarives);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenTarifeToView(): void
    {
        $tarife = new \DslFactory\DslIntranet\Domain\Model\Tarife();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('tarife', $tarife);

        $this->subject->showAction($tarife);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenTarifeToTarifeRepository(): void
    {
        $tarife = new \DslFactory\DslIntranet\Domain\Model\Tarife();

        $tarifeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TarifeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $tarifeRepository->expects(self::once())->method('add')->with($tarife);
        $this->subject->_set('tarifeRepository', $tarifeRepository);

        $this->subject->createAction($tarife);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenTarifeToView(): void
    {
        $tarife = new \DslFactory\DslIntranet\Domain\Model\Tarife();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('tarife', $tarife);

        $this->subject->editAction($tarife);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenTarifeInTarifeRepository(): void
    {
        $tarife = new \DslFactory\DslIntranet\Domain\Model\Tarife();

        $tarifeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TarifeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $tarifeRepository->expects(self::once())->method('update')->with($tarife);
        $this->subject->_set('tarifeRepository', $tarifeRepository);

        $this->subject->updateAction($tarife);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenTarifeFromTarifeRepository(): void
    {
        $tarife = new \DslFactory\DslIntranet\Domain\Model\Tarife();

        $tarifeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\TarifeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $tarifeRepository->expects(self::once())->method('remove')->with($tarife);
        $this->subject->_set('tarifeRepository', $tarifeRepository);

        $this->subject->deleteAction($tarife);
    }
}
