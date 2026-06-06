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
class FremdkostenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\FremdkostenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\FremdkostenController::class))
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
    public function listActionFetchesAllFremdkostensFromRepositoryAndAssignsThemToView(): void
    {
        $allFremdkostens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $fremdkostenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allFremdkostens));
        $this->subject->_set('fremdkostenRepository', $fremdkostenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('fremdkostens', $allFremdkostens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenFremdkostenToView(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('fremdkosten', $fremdkosten);

        $this->subject->showAction($fremdkosten);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFremdkostenToFremdkostenRepository(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();

        $fremdkostenRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenRepository->expects(self::once())->method('add')->with($fremdkosten);
        $this->subject->_set('fremdkostenRepository', $fremdkostenRepository);

        $this->subject->createAction($fremdkosten);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFremdkostenToView(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('fremdkosten', $fremdkosten);

        $this->subject->editAction($fremdkosten);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFremdkostenInFremdkostenRepository(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();

        $fremdkostenRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenRepository->expects(self::once())->method('update')->with($fremdkosten);
        $this->subject->_set('fremdkostenRepository', $fremdkostenRepository);

        $this->subject->updateAction($fremdkosten);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFremdkostenFromFremdkostenRepository(): void
    {
        $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();

        $fremdkostenRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $fremdkostenRepository->expects(self::once())->method('remove')->with($fremdkosten);
        $this->subject->_set('fremdkostenRepository', $fremdkostenRepository);

        $this->subject->deleteAction($fremdkosten);
    }
}
