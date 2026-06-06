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
class SplitpaneControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\SplitpaneController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\SplitpaneController::class))
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
    public function listActionFetchesAllSplitpanesFromRepositoryAndAssignsThemToView(): void
    {
        $allSplitpanes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $splitpaneRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $splitpaneRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSplitpanes));
        $this->subject->_set('splitpaneRepository', $splitpaneRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('splitpanes', $allSplitpanes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenSplitpaneToView(): void
    {
        $splitpane = new \DslFactory\DslIntranet\Domain\Model\Splitpane();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('splitpane', $splitpane);

        $this->subject->showAction($splitpane);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSplitpaneToSplitpaneRepository(): void
    {
        $splitpane = new \DslFactory\DslIntranet\Domain\Model\Splitpane();

        $splitpaneRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $splitpaneRepository->expects(self::once())->method('add')->with($splitpane);
        $this->subject->_set('splitpaneRepository', $splitpaneRepository);

        $this->subject->createAction($splitpane);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenSplitpaneToView(): void
    {
        $splitpane = new \DslFactory\DslIntranet\Domain\Model\Splitpane();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('splitpane', $splitpane);

        $this->subject->editAction($splitpane);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenSplitpaneInSplitpaneRepository(): void
    {
        $splitpane = new \DslFactory\DslIntranet\Domain\Model\Splitpane();

        $splitpaneRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $splitpaneRepository->expects(self::once())->method('update')->with($splitpane);
        $this->subject->_set('splitpaneRepository', $splitpaneRepository);

        $this->subject->updateAction($splitpane);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSplitpaneFromSplitpaneRepository(): void
    {
        $splitpane = new \DslFactory\DslIntranet\Domain\Model\Splitpane();

        $splitpaneRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $splitpaneRepository->expects(self::once())->method('remove')->with($splitpane);
        $this->subject->_set('splitpaneRepository', $splitpaneRepository);

        $this->subject->deleteAction($splitpane);
    }
}
