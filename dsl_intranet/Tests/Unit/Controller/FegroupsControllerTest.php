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
class FegroupsControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\FegroupsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\FegroupsController::class))
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
    public function listActionFetchesAllFegroupsFromRepositoryAndAssignsThemToView(): void
    {
        $allFegroups = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\FegroupsRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $fegroupsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allFegroups));
        $this->subject->_set('fegroupsRepository', $fegroupsRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('fegroups', $allFegroups);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenFegroupsToView(): void
    {
        $fegroups = new \DslFactory\DslIntranet\Domain\Model\Fegroups();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('fegroups', $fegroups);

        $this->subject->showAction($fegroups);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFegroupsToFegroupsRepository(): void
    {
        $fegroups = new \DslFactory\DslIntranet\Domain\Model\Fegroups();

        $fegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\FegroupsRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsRepository->expects(self::once())->method('add')->with($fegroups);
        $this->subject->_set('fegroupsRepository', $fegroupsRepository);

        $this->subject->createAction($fegroups);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFegroupsToView(): void
    {
        $fegroups = new \DslFactory\DslIntranet\Domain\Model\Fegroups();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('fegroups', $fegroups);

        $this->subject->editAction($fegroups);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFegroupsInFegroupsRepository(): void
    {
        $fegroups = new \DslFactory\DslIntranet\Domain\Model\Fegroups();

        $fegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\FegroupsRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsRepository->expects(self::once())->method('update')->with($fegroups);
        $this->subject->_set('fegroupsRepository', $fegroupsRepository);

        $this->subject->updateAction($fegroups);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFegroupsFromFegroupsRepository(): void
    {
        $fegroups = new \DslFactory\DslIntranet\Domain\Model\Fegroups();

        $fegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\FegroupsRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $fegroupsRepository->expects(self::once())->method('remove')->with($fegroups);
        $this->subject->_set('fegroupsRepository', $fegroupsRepository);

        $this->subject->deleteAction($fegroups);
    }
}
