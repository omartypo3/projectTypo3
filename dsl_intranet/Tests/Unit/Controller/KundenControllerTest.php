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
class KundenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenController::class))
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
    public function listActionFetchesAllKundensFromRepositoryAndAssignsThemToView(): void
    {
        $allKundens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundens));
        $this->subject->_set('kundenRepository', $kundenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundens', $allKundens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenToView(): void
    {
        $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kunden', $kunden);

        $this->subject->showAction($kunden);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenToKundenRepository(): void
    {
        $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();

        $kundenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenRepository->expects(self::once())->method('add')->with($kunden);
        $this->subject->_set('kundenRepository', $kundenRepository);

        $this->subject->createAction($kunden);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenToView(): void
    {
        $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kunden', $kunden);

        $this->subject->editAction($kunden);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenInKundenRepository(): void
    {
        $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();

        $kundenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenRepository->expects(self::once())->method('update')->with($kunden);
        $this->subject->_set('kundenRepository', $kundenRepository);

        $this->subject->updateAction($kunden);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenFromKundenRepository(): void
    {
        $kunden = new \DslFactory\DslIntranet\Domain\Model\Kunden();

        $kundenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenRepository->expects(self::once())->method('remove')->with($kunden);
        $this->subject->_set('kundenRepository', $kundenRepository);

        $this->subject->deleteAction($kunden);
    }
}
