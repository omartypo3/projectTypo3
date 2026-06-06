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
class HostingTarifRechnungenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\HostingTarifRechnungenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\HostingTarifRechnungenController::class))
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
    public function listActionFetchesAllHostingTarifRechnungensFromRepositoryAndAssignsThemToView(): void
    {
        $allHostingTarifRechnungens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingTarifRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $hostingTarifRechnungenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allHostingTarifRechnungens));
        $this->subject->_set('hostingTarifRechnungenRepository', $hostingTarifRechnungenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('hostingTarifRechnungens', $allHostingTarifRechnungens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenHostingTarifRechnungenToView(): void
    {
        $hostingTarifRechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingTarifRechnungen', $hostingTarifRechnungen);

        $this->subject->showAction($hostingTarifRechnungen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenHostingTarifRechnungenToHostingTarifRechnungenRepository(): void
    {
        $hostingTarifRechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();

        $hostingTarifRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingTarifRechnungenRepository->expects(self::once())->method('add')->with($hostingTarifRechnungen);
        $this->subject->_set('hostingTarifRechnungenRepository', $hostingTarifRechnungenRepository);

        $this->subject->createAction($hostingTarifRechnungen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenHostingTarifRechnungenToView(): void
    {
        $hostingTarifRechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingTarifRechnungen', $hostingTarifRechnungen);

        $this->subject->editAction($hostingTarifRechnungen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenHostingTarifRechnungenInHostingTarifRechnungenRepository(): void
    {
        $hostingTarifRechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();

        $hostingTarifRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingTarifRechnungenRepository->expects(self::once())->method('update')->with($hostingTarifRechnungen);
        $this->subject->_set('hostingTarifRechnungenRepository', $hostingTarifRechnungenRepository);

        $this->subject->updateAction($hostingTarifRechnungen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenHostingTarifRechnungenFromHostingTarifRechnungenRepository(): void
    {
        $hostingTarifRechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();

        $hostingTarifRechnungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingTarifRechnungenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingTarifRechnungenRepository->expects(self::once())->method('remove')->with($hostingTarifRechnungen);
        $this->subject->_set('hostingTarifRechnungenRepository', $hostingTarifRechnungenRepository);

        $this->subject->deleteAction($hostingTarifRechnungen);
    }
}
