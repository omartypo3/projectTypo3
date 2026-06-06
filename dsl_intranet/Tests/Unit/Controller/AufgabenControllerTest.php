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
class AufgabenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AufgabenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AufgabenController::class))
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
    public function listActionFetchesAllAufgabensFromRepositoryAndAssignsThemToView(): void
    {
        $allAufgabens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $aufgabenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AufgabenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $aufgabenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAufgabens));
        $this->subject->_set('aufgabenRepository', $aufgabenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('aufgabens', $allAufgabens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAufgabenToView(): void
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('aufgaben', $aufgaben);

        $this->subject->showAction($aufgaben);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAufgabenToAufgabenRepository(): void
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();

        $aufgabenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AufgabenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $aufgabenRepository->expects(self::once())->method('add')->with($aufgaben);
        $this->subject->_set('aufgabenRepository', $aufgabenRepository);

        $this->subject->createAction($aufgaben);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAufgabenToView(): void
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('aufgaben', $aufgaben);

        $this->subject->editAction($aufgaben);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAufgabenInAufgabenRepository(): void
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();

        $aufgabenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AufgabenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $aufgabenRepository->expects(self::once())->method('update')->with($aufgaben);
        $this->subject->_set('aufgabenRepository', $aufgabenRepository);

        $this->subject->updateAction($aufgaben);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAufgabenFromAufgabenRepository(): void
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();

        $aufgabenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AufgabenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $aufgabenRepository->expects(self::once())->method('remove')->with($aufgaben);
        $this->subject->_set('aufgabenRepository', $aufgabenRepository);

        $this->subject->deleteAction($aufgaben);
    }
}
