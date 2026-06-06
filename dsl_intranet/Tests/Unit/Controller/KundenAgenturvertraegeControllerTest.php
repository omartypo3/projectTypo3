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
class KundenAgenturvertraegeControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenAgenturvertraegeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenAgenturvertraegeController::class))
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
    public function listActionFetchesAllKundenAgenturvertraegesFromRepositoryAndAssignsThemToView(): void
    {
        $allKundenAgenturvertraeges = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenAgenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenAgenturvertraegeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundenAgenturvertraeges));
        $this->subject->_set('kundenAgenturvertraegeRepository', $kundenAgenturvertraegeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundenAgenturvertraeges', $allKundenAgenturvertraeges);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenAgenturvertraegeToView(): void
    {
        $kundenAgenturvertraege = new \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenAgenturvertraege', $kundenAgenturvertraege);

        $this->subject->showAction($kundenAgenturvertraege);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenAgenturvertraegeToKundenAgenturvertraegeRepository(): void
    {
        $kundenAgenturvertraege = new \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege();

        $kundenAgenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenAgenturvertraegeRepository->expects(self::once())->method('add')->with($kundenAgenturvertraege);
        $this->subject->_set('kundenAgenturvertraegeRepository', $kundenAgenturvertraegeRepository);

        $this->subject->createAction($kundenAgenturvertraege);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenAgenturvertraegeToView(): void
    {
        $kundenAgenturvertraege = new \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenAgenturvertraege', $kundenAgenturvertraege);

        $this->subject->editAction($kundenAgenturvertraege);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenAgenturvertraegeInKundenAgenturvertraegeRepository(): void
    {
        $kundenAgenturvertraege = new \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege();

        $kundenAgenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenAgenturvertraegeRepository->expects(self::once())->method('update')->with($kundenAgenturvertraege);
        $this->subject->_set('kundenAgenturvertraegeRepository', $kundenAgenturvertraegeRepository);

        $this->subject->updateAction($kundenAgenturvertraege);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenAgenturvertraegeFromKundenAgenturvertraegeRepository(): void
    {
        $kundenAgenturvertraege = new \DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege();

        $kundenAgenturvertraegeRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenAgenturvertraegeRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenAgenturvertraegeRepository->expects(self::once())->method('remove')->with($kundenAgenturvertraege);
        $this->subject->_set('kundenAgenturvertraegeRepository', $kundenAgenturvertraegeRepository);

        $this->subject->deleteAction($kundenAgenturvertraege);
    }
}
