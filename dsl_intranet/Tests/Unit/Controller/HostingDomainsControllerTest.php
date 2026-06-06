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
class HostingDomainsControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\HostingDomainsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\HostingDomainsController::class))
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
    public function listActionFetchesAllHostingDomainsFromRepositoryAndAssignsThemToView(): void
    {
        $allHostingDomains = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hostingDomainsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $hostingDomainsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allHostingDomains));
        $this->subject->_set('hostingDomainsRepository', $hostingDomainsRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('hostingDomains', $allHostingDomains);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenHostingDomainsToView(): void
    {
        $hostingDomains = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingDomains', $hostingDomains);

        $this->subject->showAction($hostingDomains);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenHostingDomainsToHostingDomainsRepository(): void
    {
        $hostingDomains = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();

        $hostingDomainsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingDomainsRepository->expects(self::once())->method('add')->with($hostingDomains);
        $this->subject->_set('hostingDomainsRepository', $hostingDomainsRepository);

        $this->subject->createAction($hostingDomains);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenHostingDomainsToView(): void
    {
        $hostingDomains = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('hostingDomains', $hostingDomains);

        $this->subject->editAction($hostingDomains);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenHostingDomainsInHostingDomainsRepository(): void
    {
        $hostingDomains = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();

        $hostingDomainsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingDomainsRepository->expects(self::once())->method('update')->with($hostingDomains);
        $this->subject->_set('hostingDomainsRepository', $hostingDomainsRepository);

        $this->subject->updateAction($hostingDomains);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenHostingDomainsFromHostingDomainsRepository(): void
    {
        $hostingDomains = new \DslFactory\DslIntranet\Domain\Model\HostingDomains();

        $hostingDomainsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\HostingDomainsRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $hostingDomainsRepository->expects(self::once())->method('remove')->with($hostingDomains);
        $this->subject->_set('hostingDomainsRepository', $hostingDomainsRepository);

        $this->subject->deleteAction($hostingDomains);
    }
}
