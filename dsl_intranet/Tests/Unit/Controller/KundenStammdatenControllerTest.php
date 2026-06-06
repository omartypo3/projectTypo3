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
class KundenStammdatenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenStammdatenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenStammdatenController::class))
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
    public function listActionFetchesAllKundenStammdatensFromRepositoryAndAssignsThemToView(): void
    {
        $allKundenStammdatens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenStammdatenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenStammdatenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundenStammdatens));
        $this->subject->_set('kundenStammdatenRepository', $kundenStammdatenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundenStammdatens', $allKundenStammdatens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenStammdatenToView(): void
    {
        $kundenStammdaten = new \DslFactory\DslIntranet\Domain\Model\KundenStammdaten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenStammdaten', $kundenStammdaten);

        $this->subject->showAction($kundenStammdaten);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenStammdatenToKundenStammdatenRepository(): void
    {
        $kundenStammdaten = new \DslFactory\DslIntranet\Domain\Model\KundenStammdaten();

        $kundenStammdatenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenStammdatenRepository->expects(self::once())->method('add')->with($kundenStammdaten);
        $this->subject->_set('kundenStammdatenRepository', $kundenStammdatenRepository);

        $this->subject->createAction($kundenStammdaten);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenStammdatenToView(): void
    {
        $kundenStammdaten = new \DslFactory\DslIntranet\Domain\Model\KundenStammdaten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenStammdaten', $kundenStammdaten);

        $this->subject->editAction($kundenStammdaten);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenStammdatenInKundenStammdatenRepository(): void
    {
        $kundenStammdaten = new \DslFactory\DslIntranet\Domain\Model\KundenStammdaten();

        $kundenStammdatenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenStammdatenRepository->expects(self::once())->method('update')->with($kundenStammdaten);
        $this->subject->_set('kundenStammdatenRepository', $kundenStammdatenRepository);

        $this->subject->updateAction($kundenStammdaten);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenStammdatenFromKundenStammdatenRepository(): void
    {
        $kundenStammdaten = new \DslFactory\DslIntranet\Domain\Model\KundenStammdaten();

        $kundenStammdatenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenStammdatenRepository->expects(self::once())->method('remove')->with($kundenStammdaten);
        $this->subject->_set('kundenStammdatenRepository', $kundenStammdatenRepository);

        $this->subject->deleteAction($kundenStammdaten);
    }
}
