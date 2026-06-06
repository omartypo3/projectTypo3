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
class AuftraegeTexteControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AuftraegeTexteController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AuftraegeTexteController::class))
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
    public function listActionFetchesAllAuftraegeTextesFromRepositoryAndAssignsThemToView(): void
    {
        $allAuftraegeTextes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeTexteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $auftraegeTexteRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAuftraegeTextes));
        $this->subject->_set('auftraegeTexteRepository', $auftraegeTexteRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('auftraegeTextes', $allAuftraegeTextes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAuftraegeTexteToView(): void
    {
        $auftraegeTexte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftraegeTexte', $auftraegeTexte);

        $this->subject->showAction($auftraegeTexte);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAuftraegeTexteToAuftraegeTexteRepository(): void
    {
        $auftraegeTexte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();

        $auftraegeTexteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeTexteRepository->expects(self::once())->method('add')->with($auftraegeTexte);
        $this->subject->_set('auftraegeTexteRepository', $auftraegeTexteRepository);

        $this->subject->createAction($auftraegeTexte);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAuftraegeTexteToView(): void
    {
        $auftraegeTexte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftraegeTexte', $auftraegeTexte);

        $this->subject->editAction($auftraegeTexte);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAuftraegeTexteInAuftraegeTexteRepository(): void
    {
        $auftraegeTexte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();

        $auftraegeTexteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeTexteRepository->expects(self::once())->method('update')->with($auftraegeTexte);
        $this->subject->_set('auftraegeTexteRepository', $auftraegeTexteRepository);

        $this->subject->updateAction($auftraegeTexte);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAuftraegeTexteFromAuftraegeTexteRepository(): void
    {
        $auftraegeTexte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();

        $auftraegeTexteRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftraegeTexteRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftraegeTexteRepository->expects(self::once())->method('remove')->with($auftraegeTexte);
        $this->subject->_set('auftraegeTexteRepository', $auftraegeTexteRepository);

        $this->subject->deleteAction($auftraegeTexte);
    }
}
