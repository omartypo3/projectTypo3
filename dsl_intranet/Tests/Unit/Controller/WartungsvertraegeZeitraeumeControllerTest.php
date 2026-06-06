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
class WartungsvertraegeZeitraeumeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\WartungsvertraegeZeitraeumeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\WartungsvertraegeZeitraeumeController::class))
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
    public function listActionFetchesAllWartungsvertraegeZeitraeumesFromRepositoryAndAssignsThemToView(): void
    {
        $allWartungsvertraegeZeitraeumes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeZeitraeumeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $wartungsvertraegeZeitraeumeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allWartungsvertraegeZeitraeumes));
        $this->subject->_set('wartungsvertraegeZeitraeumeRepository', $wartungsvertraegeZeitraeumeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeZeitraeumes', $allWartungsvertraegeZeitraeumes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenWartungsvertraegeZeitraeumeToView(): void
    {
        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeZeitraeume', $wartungsvertraegeZeitraeume);

        $this->subject->showAction($wartungsvertraegeZeitraeume);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenWartungsvertraegeZeitraeumeToWartungsvertraegeZeitraeumeRepository(): void
    {
        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();

        $wartungsvertraegeZeitraeumeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeZeitraeumeRepository->expects(self::once())->method('add')->with($wartungsvertraegeZeitraeume);
        $this->subject->_set('wartungsvertraegeZeitraeumeRepository', $wartungsvertraegeZeitraeumeRepository);

        $this->subject->createAction($wartungsvertraegeZeitraeume);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenWartungsvertraegeZeitraeumeToView(): void
    {
        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('wartungsvertraegeZeitraeume', $wartungsvertraegeZeitraeume);

        $this->subject->editAction($wartungsvertraegeZeitraeume);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenWartungsvertraegeZeitraeumeInWartungsvertraegeZeitraeumeRepository(): void
    {
        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();

        $wartungsvertraegeZeitraeumeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeZeitraeumeRepository->expects(self::once())->method('update')->with($wartungsvertraegeZeitraeume);
        $this->subject->_set('wartungsvertraegeZeitraeumeRepository', $wartungsvertraegeZeitraeumeRepository);

        $this->subject->updateAction($wartungsvertraegeZeitraeume);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenWartungsvertraegeZeitraeumeFromWartungsvertraegeZeitraeumeRepository(): void
    {
        $wartungsvertraegeZeitraeume = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume();

        $wartungsvertraegeZeitraeumeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\WartungsvertraegeZeitraeumeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $wartungsvertraegeZeitraeumeRepository->expects(self::once())->method('remove')->with($wartungsvertraegeZeitraeume);
        $this->subject->_set('wartungsvertraegeZeitraeumeRepository', $wartungsvertraegeZeitraeumeRepository);

        $this->subject->deleteAction($wartungsvertraegeZeitraeume);
    }
}
