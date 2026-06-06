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
class WartungsvertraegeRechnungenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\WartungsvertraegeRechnungenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\WartungsvertraegeRechnungenController::class))
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
    public function listActionFetchesAllWartungsvertraegeRechnungensFromRepositoryAndAssignsThemToView(): void
    {
        $allWartungsvertraegeRechnungens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $wartungsvertraegeRechnungenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allWartungsvertraegeRechnungens));
        $this->subject->_set('wartungsvertraegeRechnungenRepository', $wartungsvertraegeRechnungenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeRechnungens', $allWartungsvertraegeRechnungens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenWartungsvertraegeRechnungenToView(): void
    {
        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeRechnungen', $wartungsvertraegeRechnungen);

        $this->subject->showAction($wartungsvertraegeRechnungen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenWartungsvertraegeRechnungenToWartungsvertraegeRechnungenRepository(): void
    {
        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();

        $wartungsvertraegeRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeRechnungenRepository->expects(self::once())->method('add')->with($wartungsvertraegeRechnungen);
        $this->subject->_set('wartungsvertraegeRechnungenRepository', $wartungsvertraegeRechnungenRepository);

        $this->subject->createAction($wartungsvertraegeRechnungen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenWartungsvertraegeRechnungenToView(): void
    {
        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeRechnungen', $wartungsvertraegeRechnungen);

        $this->subject->editAction($wartungsvertraegeRechnungen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenWartungsvertraegeRechnungenInWartungsvertraegeRechnungenRepository(): void
    {
        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();

        $wartungsvertraegeRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeRechnungenRepository->expects(self::once())->method('update')->with($wartungsvertraegeRechnungen);
        $this->subject->_set('wartungsvertraegeRechnungenRepository', $wartungsvertraegeRechnungenRepository);

        $this->subject->updateAction($wartungsvertraegeRechnungen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenWartungsvertraegeRechnungenFromWartungsvertraegeRechnungenRepository(): void
    {
        $wartungsvertraegeRechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();

        $wartungsvertraegeRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeRechnungenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeRechnungenRepository->expects(self::once())->method('remove')->with($wartungsvertraegeRechnungen);
        $this->subject->_set('wartungsvertraegeRechnungenRepository', $wartungsvertraegeRechnungenRepository);

        $this->subject->deleteAction($wartungsvertraegeRechnungen);
    }
}
