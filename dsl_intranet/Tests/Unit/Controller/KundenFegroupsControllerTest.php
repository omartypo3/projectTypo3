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
class KundenFegroupsControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenFegroupsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenFegroupsController::class))
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
    public function listActionFetchesAllKundenFegroupsFromRepositoryAndAssignsThemToView(): void
    {
        $allKundenFegroups = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenFegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenFegroupsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundenFegroups));
        $this->subject->_set('kundenFegroupsRepository', $kundenFegroupsRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundenFegroups', $allKundenFegroups);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenFegroupsToView(): void
    {
        $kundenFegroups = new \DslFactory\DslIntranet\Domain\Model\KundenFegroups();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenFegroups', $kundenFegroups);

        $this->subject->showAction($kundenFegroups);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenFegroupsToKundenFegroupsRepository(): void
    {
        $kundenFegroups = new \DslFactory\DslIntranet\Domain\Model\KundenFegroups();

        $kundenFegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenFegroupsRepository->expects(self::once())->method('add')->with($kundenFegroups);
        $this->subject->_set('kundenFegroupsRepository', $kundenFegroupsRepository);

        $this->subject->createAction($kundenFegroups);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenFegroupsToView(): void
    {
        $kundenFegroups = new \DslFactory\DslIntranet\Domain\Model\KundenFegroups();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenFegroups', $kundenFegroups);

        $this->subject->editAction($kundenFegroups);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenFegroupsInKundenFegroupsRepository(): void
    {
        $kundenFegroups = new \DslFactory\DslIntranet\Domain\Model\KundenFegroups();

        $kundenFegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenFegroupsRepository->expects(self::once())->method('update')->with($kundenFegroups);
        $this->subject->_set('kundenFegroupsRepository', $kundenFegroupsRepository);

        $this->subject->updateAction($kundenFegroups);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenFegroupsFromKundenFegroupsRepository(): void
    {
        $kundenFegroups = new \DslFactory\DslIntranet\Domain\Model\KundenFegroups();

        $kundenFegroupsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenFegroupsRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenFegroupsRepository->expects(self::once())->method('remove')->with($kundenFegroups);
        $this->subject->_set('kundenFegroupsRepository', $kundenFegroupsRepository);

        $this->subject->deleteAction($kundenFegroups);
    }
}
