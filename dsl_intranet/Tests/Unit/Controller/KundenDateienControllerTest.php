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
class KundenDateienControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenDateienController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenDateienController::class))
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
    public function listActionFetchesAllKundenDateiensFromRepositoryAndAssignsThemToView(): void
    {
        $allKundenDateiens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenDateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenDateienRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundenDateiens));
        $this->subject->_set('kundenDateienRepository', $kundenDateienRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundenDateiens', $allKundenDateiens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenDateienToView(): void
    {
        $kundenDateien = new \DslFactory\DslIntranet\Domain\Model\KundenDateien();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenDateien', $kundenDateien);

        $this->subject->showAction($kundenDateien);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenDateienToKundenDateienRepository(): void
    {
        $kundenDateien = new \DslFactory\DslIntranet\Domain\Model\KundenDateien();

        $kundenDateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenDateienRepository->expects(self::once())->method('add')->with($kundenDateien);
        $this->subject->_set('kundenDateienRepository', $kundenDateienRepository);

        $this->subject->createAction($kundenDateien);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenDateienToView(): void
    {
        $kundenDateien = new \DslFactory\DslIntranet\Domain\Model\KundenDateien();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenDateien', $kundenDateien);

        $this->subject->editAction($kundenDateien);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenDateienInKundenDateienRepository(): void
    {
        $kundenDateien = new \DslFactory\DslIntranet\Domain\Model\KundenDateien();

        $kundenDateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenDateienRepository->expects(self::once())->method('update')->with($kundenDateien);
        $this->subject->_set('kundenDateienRepository', $kundenDateienRepository);

        $this->subject->updateAction($kundenDateien);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenDateienFromKundenDateienRepository(): void
    {
        $kundenDateien = new \DslFactory\DslIntranet\Domain\Model\KundenDateien();

        $kundenDateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenDateienRepository->expects(self::once())->method('remove')->with($kundenDateien);
        $this->subject->_set('kundenDateienRepository', $kundenDateienRepository);

        $this->subject->deleteAction($kundenDateien);
    }
}
