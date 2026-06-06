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
class DateienControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\DateienController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\DateienController::class))
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
    public function listActionFetchesAllDateiensFromRepositoryAndAssignsThemToView(): void
    {
        $allDateiens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\DateienRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $dateienRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDateiens));
        $this->subject->_set('dateienRepository', $dateienRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('dateiens', $allDateiens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDateienToView(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('dateien', $dateien);

        $this->subject->showAction($dateien);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDateienToDateienRepository(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

        $dateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\DateienRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $dateienRepository->expects(self::once())->method('add')->with($dateien);
        $this->subject->_set('dateienRepository', $dateienRepository);

        $this->subject->createAction($dateien);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDateienToView(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('dateien', $dateien);

        $this->subject->editAction($dateien);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDateienInDateienRepository(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

        $dateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\DateienRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $dateienRepository->expects(self::once())->method('update')->with($dateien);
        $this->subject->_set('dateienRepository', $dateienRepository);

        $this->subject->updateAction($dateien);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDateienFromDateienRepository(): void
    {
        $dateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();

        $dateienRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\DateienRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $dateienRepository->expects(self::once())->method('remove')->with($dateien);
        $this->subject->_set('dateienRepository', $dateienRepository);

        $this->subject->deleteAction($dateien);
    }
}
