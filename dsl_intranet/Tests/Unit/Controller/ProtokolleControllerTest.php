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
class ProtokolleControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\ProtokolleController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\ProtokolleController::class))
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
    public function listActionFetchesAllProtokollesFromRepositoryAndAssignsThemToView(): void
    {
        $allProtokolles = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $protokolleRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $protokolleRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProtokolles));
        $this->subject->_set('protokolleRepository', $protokolleRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('protokolles', $allProtokolles);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProtokolleToView(): void
    {
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('protokolle', $protokolle);

        $this->subject->showAction($protokolle);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenProtokolleToProtokolleRepository(): void
    {
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();

        $protokolleRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokolleRepository->expects(self::once())->method('add')->with($protokolle);
        $this->subject->_set('protokolleRepository', $protokolleRepository);

        $this->subject->createAction($protokolle);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProtokolleToView(): void
    {
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('protokolle', $protokolle);

        $this->subject->editAction($protokolle);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenProtokolleInProtokolleRepository(): void
    {
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();

        $protokolleRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokolleRepository->expects(self::once())->method('update')->with($protokolle);
        $this->subject->_set('protokolleRepository', $protokolleRepository);

        $this->subject->updateAction($protokolle);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenProtokolleFromProtokolleRepository(): void
    {
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();

        $protokolleRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ProtokolleRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $protokolleRepository->expects(self::once())->method('remove')->with($protokolle);
        $this->subject->_set('protokolleRepository', $protokolleRepository);

        $this->subject->deleteAction($protokolle);
    }
}
