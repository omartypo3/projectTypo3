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
class HostingZusatzleistungenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\HostingZusatzleistungenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\HostingZusatzleistungenController::class))
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
    public function listActionFetchesAllHostingZusatzleistungensFromRepositoryAndAssignsThemToView(): void
    {
        $allHostingZusatzleistungens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingZusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $hostingZusatzleistungenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allHostingZusatzleistungens));
        $this->subject->_set('hostingZusatzleistungenRepository', $hostingZusatzleistungenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('hostingZusatzleistungens', $allHostingZusatzleistungens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenHostingZusatzleistungenToView(): void
    {
        $hostingZusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingZusatzleistungen', $hostingZusatzleistungen);

        $this->subject->showAction($hostingZusatzleistungen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenHostingZusatzleistungenToHostingZusatzleistungenRepository(): void
    {
        $hostingZusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();

        $hostingZusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingZusatzleistungenRepository->expects(self::once())->method('add')->with($hostingZusatzleistungen);
        $this->subject->_set('hostingZusatzleistungenRepository', $hostingZusatzleistungenRepository);

        $this->subject->createAction($hostingZusatzleistungen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenHostingZusatzleistungenToView(): void
    {
        $hostingZusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingZusatzleistungen', $hostingZusatzleistungen);

        $this->subject->editAction($hostingZusatzleistungen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenHostingZusatzleistungenInHostingZusatzleistungenRepository(): void
    {
        $hostingZusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();

        $hostingZusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingZusatzleistungenRepository->expects(self::once())->method('update')->with($hostingZusatzleistungen);
        $this->subject->_set('hostingZusatzleistungenRepository', $hostingZusatzleistungenRepository);

        $this->subject->updateAction($hostingZusatzleistungen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenHostingZusatzleistungenFromHostingZusatzleistungenRepository(): void
    {
        $hostingZusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen();

        $hostingZusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingZusatzleistungenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingZusatzleistungenRepository->expects(self::once())->method('remove')->with($hostingZusatzleistungen);
        $this->subject->_set('hostingZusatzleistungenRepository', $hostingZusatzleistungenRepository);

        $this->subject->deleteAction($hostingZusatzleistungen);
    }
}
