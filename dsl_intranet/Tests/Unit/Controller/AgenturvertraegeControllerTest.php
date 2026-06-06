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
class AgenturvertraegeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\AgenturvertraegeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\AgenturvertraegeController::class))
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
    public function listActionFetchesAllAgenturvertraegesFromRepositoryAndAssignsThemToView(): void
    {
        $allAgenturvertraeges = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $agenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $agenturvertraegeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAgenturvertraeges));
        $this->subject->_set('agenturvertraegeRepository', $agenturvertraegeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('agenturvertraeges', $allAgenturvertraeges);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAgenturvertraegeToView(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('agenturvertraege', $agenturvertraege);

        $this->subject->showAction($agenturvertraege);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAgenturvertraegeToAgenturvertraegeRepository(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $agenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $agenturvertraegeRepository->expects(self::once())->method('add')->with($agenturvertraege);
        $this->subject->_set('agenturvertraegeRepository', $agenturvertraegeRepository);

        $this->subject->createAction($agenturvertraege);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAgenturvertraegeToView(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('agenturvertraege', $agenturvertraege);

        $this->subject->editAction($agenturvertraege);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAgenturvertraegeInAgenturvertraegeRepository(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $agenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $agenturvertraegeRepository->expects(self::once())->method('update')->with($agenturvertraege);
        $this->subject->_set('agenturvertraegeRepository', $agenturvertraegeRepository);

        $this->subject->updateAction($agenturvertraege);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAgenturvertraegeFromAgenturvertraegeRepository(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $agenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $agenturvertraegeRepository->expects(self::once())->method('remove')->with($agenturvertraege);
        $this->subject->_set('agenturvertraegeRepository', $agenturvertraegeRepository);

        $this->subject->deleteAction($agenturvertraege);
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAgenturvertraegeToView(): void
    {
        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('agenturvertraege', $agenturvertraege);

        $this->subject->showAction($agenturvertraege);
    }
}
