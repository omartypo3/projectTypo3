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
class KundenNewsControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\KundenNewsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\KundenNewsController::class))
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
    public function listActionFetchesAllKundenNewsFromRepositoryAndAssignsThemToView(): void
    {
        $allKundenNews = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kundenNewsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $kundenNewsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allKundenNews));
        $this->subject->_set('kundenNewsRepository', $kundenNewsRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('kundenNews', $allKundenNews);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenKundenNewsToView(): void
    {
        $kundenNews = new \DslFactory\DslIntranet\Domain\Model\KundenNews();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenNews', $kundenNews);

        $this->subject->showAction($kundenNews);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenKundenNewsToKundenNewsRepository(): void
    {
        $kundenNews = new \DslFactory\DslIntranet\Domain\Model\KundenNews();

        $kundenNewsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenNewsRepository->expects(self::once())->method('add')->with($kundenNews);
        $this->subject->_set('kundenNewsRepository', $kundenNewsRepository);

        $this->subject->createAction($kundenNews);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenKundenNewsToView(): void
    {
        $kundenNews = new \DslFactory\DslIntranet\Domain\Model\KundenNews();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('kundenNews', $kundenNews);

        $this->subject->editAction($kundenNews);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenKundenNewsInKundenNewsRepository(): void
    {
        $kundenNews = new \DslFactory\DslIntranet\Domain\Model\KundenNews();

        $kundenNewsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenNewsRepository->expects(self::once())->method('update')->with($kundenNews);
        $this->subject->_set('kundenNewsRepository', $kundenNewsRepository);

        $this->subject->updateAction($kundenNews);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenKundenNewsFromKundenNewsRepository(): void
    {
        $kundenNews = new \DslFactory\DslIntranet\Domain\Model\KundenNews();

        $kundenNewsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\KundenNewsRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $kundenNewsRepository->expects(self::once())->method('remove')->with($kundenNews);
        $this->subject->_set('kundenNewsRepository', $kundenNewsRepository);

        $this->subject->deleteAction($kundenNews);
    }
}
