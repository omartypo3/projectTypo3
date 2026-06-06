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
class LieferantenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\LieferantenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\LieferantenController::class))
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
    public function listActionFetchesAllLieferantensFromRepositoryAndAssignsThemToView(): void
    {
        $allLieferantens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\LieferantenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $lieferantenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allLieferantens));
        $this->subject->_set('lieferantenRepository', $lieferantenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('lieferantens', $allLieferantens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenLieferantenToView(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('lieferanten', $lieferanten);

        $this->subject->showAction($lieferanten);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenLieferantenToLieferantenRepository(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();

        $lieferantenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\LieferantenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenRepository->expects(self::once())->method('add')->with($lieferanten);
        $this->subject->_set('lieferantenRepository', $lieferantenRepository);

        $this->subject->createAction($lieferanten);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenLieferantenToView(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('lieferanten', $lieferanten);

        $this->subject->editAction($lieferanten);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenLieferantenInLieferantenRepository(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();

        $lieferantenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\LieferantenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenRepository->expects(self::once())->method('update')->with($lieferanten);
        $this->subject->_set('lieferantenRepository', $lieferantenRepository);

        $this->subject->updateAction($lieferanten);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenLieferantenFromLieferantenRepository(): void
    {
        $lieferanten = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();

        $lieferantenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\LieferantenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $lieferantenRepository->expects(self::once())->method('remove')->with($lieferanten);
        $this->subject->_set('lieferantenRepository', $lieferantenRepository);

        $this->subject->deleteAction($lieferanten);
    }
}
