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
class AuftragsartenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AuftragsartenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AuftragsartenController::class))
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
    public function listActionFetchesAllAuftragsartensFromRepositoryAndAssignsThemToView(): void
    {
        $allAuftragsartens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $auftragsartenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $auftragsartenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAuftragsartens));
        $this->subject->_set('auftragsartenRepository', $auftragsartenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('auftragsartens', $allAuftragsartens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAuftragsartenToView(): void
    {
        $auftragsarten = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftragsarten', $auftragsarten);

        $this->subject->showAction($auftragsarten);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAuftragsartenToAuftragsartenRepository(): void
    {
        $auftragsarten = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();

        $auftragsartenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftragsartenRepository->expects(self::once())->method('add')->with($auftragsarten);
        $this->subject->_set('auftragsartenRepository', $auftragsartenRepository);

        $this->subject->createAction($auftragsarten);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAuftragsartenToView(): void
    {
        $auftragsarten = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('auftragsarten', $auftragsarten);

        $this->subject->editAction($auftragsarten);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAuftragsartenInAuftragsartenRepository(): void
    {
        $auftragsarten = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();

        $auftragsartenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftragsartenRepository->expects(self::once())->method('update')->with($auftragsarten);
        $this->subject->_set('auftragsartenRepository', $auftragsartenRepository);

        $this->subject->updateAction($auftragsarten);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAuftragsartenFromAuftragsartenRepository(): void
    {
        $auftragsarten = new \DslFactory\DslIntranet\Domain\Model\Auftragsarten();

        $auftragsartenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AuftragsartenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $auftragsartenRepository->expects(self::once())->method('remove')->with($auftragsarten);
        $this->subject->_set('auftragsartenRepository', $auftragsartenRepository);

        $this->subject->deleteAction($auftragsarten);
    }
}
