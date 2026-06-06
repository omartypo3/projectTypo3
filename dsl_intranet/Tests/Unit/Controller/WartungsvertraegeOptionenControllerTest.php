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
class WartungsvertraegeOptionenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\WartungsvertraegeOptionenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\WartungsvertraegeOptionenController::class))
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
    public function listActionFetchesAllWartungsvertraegeOptionensFromRepositoryAndAssignsThemToView(): void
    {
        $allWartungsvertraegeOptionens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeOptionenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $wartungsvertraegeOptionenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allWartungsvertraegeOptionens));
        $this->subject->_set('wartungsvertraegeOptionenRepository', $wartungsvertraegeOptionenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeOptionens', $allWartungsvertraegeOptionens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenWartungsvertraegeOptionenToView(): void
    {
        $wartungsvertraegeOptionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeOptionen', $wartungsvertraegeOptionen);

        $this->subject->showAction($wartungsvertraegeOptionen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenWartungsvertraegeOptionenToWartungsvertraegeOptionenRepository(): void
    {
        $wartungsvertraegeOptionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();

        $wartungsvertraegeOptionenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeOptionenRepository->expects(self::once())->method('add')->with($wartungsvertraegeOptionen);
        $this->subject->_set('wartungsvertraegeOptionenRepository', $wartungsvertraegeOptionenRepository);

        $this->subject->createAction($wartungsvertraegeOptionen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenWartungsvertraegeOptionenToView(): void
    {
        $wartungsvertraegeOptionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeOptionen', $wartungsvertraegeOptionen);

        $this->subject->editAction($wartungsvertraegeOptionen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenWartungsvertraegeOptionenInWartungsvertraegeOptionenRepository(): void
    {
        $wartungsvertraegeOptionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();

        $wartungsvertraegeOptionenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeOptionenRepository->expects(self::once())->method('update')->with($wartungsvertraegeOptionen);
        $this->subject->_set('wartungsvertraegeOptionenRepository', $wartungsvertraegeOptionenRepository);

        $this->subject->updateAction($wartungsvertraegeOptionen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenWartungsvertraegeOptionenFromWartungsvertraegeOptionenRepository(): void
    {
        $wartungsvertraegeOptionen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeOptionen();

        $wartungsvertraegeOptionenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeOptionenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeOptionenRepository->expects(self::once())->method('remove')->with($wartungsvertraegeOptionen);
        $this->subject->_set('wartungsvertraegeOptionenRepository', $wartungsvertraegeOptionenRepository);

        $this->subject->deleteAction($wartungsvertraegeOptionen);
    }
}
