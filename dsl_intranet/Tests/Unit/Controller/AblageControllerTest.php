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
class AblageControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AblageController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AblageController::class))
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
    public function listActionFetchesAllAblagesFromRepositoryAndAssignsThemToView(): void
    {
        $allAblages = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ablageRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AblageRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $ablageRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAblages));
        $this->subject->_set('ablageRepository', $ablageRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('ablages', $allAblages);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAblageToView(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('ablage', $ablage);

        $this->subject->showAction($ablage);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAblageToAblageRepository(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();

        $ablageRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AblageRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $ablageRepository->expects(self::once())->method('add')->with($ablage);
        $this->subject->_set('ablageRepository', $ablageRepository);

        $this->subject->createAction($ablage);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAblageToView(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('ablage', $ablage);

        $this->subject->editAction($ablage);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAblageInAblageRepository(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();

        $ablageRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AblageRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $ablageRepository->expects(self::once())->method('update')->with($ablage);
        $this->subject->_set('ablageRepository', $ablageRepository);

        $this->subject->updateAction($ablage);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAblageFromAblageRepository(): void
    {
        $ablage = new \DslFactory\DslIntranet\Domain\Model\Ablage();

        $ablageRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AblageRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $ablageRepository->expects(self::once())->method('remove')->with($ablage);
        $this->subject->_set('ablageRepository', $ablageRepository);

        $this->subject->deleteAction($ablage);
    }
}
