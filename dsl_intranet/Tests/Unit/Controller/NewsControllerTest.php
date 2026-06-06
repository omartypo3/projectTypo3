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
class NewsControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\NewsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\NewsController::class))
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
    public function listActionFetchesAllNewsFromRepositoryAndAssignsThemToView(): void
    {
        $allNews = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $newsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NewsRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $newsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allNews));
        $this->subject->_set('newsRepository', $newsRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('news', $allNews);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenNewsToView(): void
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('news', $news);

        $this->subject->showAction($news);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenNewsToNewsRepository(): void
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $newsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NewsRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $newsRepository->expects(self::once())->method('add')->with($news);
        $this->subject->_set('newsRepository', $newsRepository);

        $this->subject->createAction($news);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenNewsToView(): void
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('news', $news);

        $this->subject->editAction($news);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenNewsInNewsRepository(): void
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $newsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NewsRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $newsRepository->expects(self::once())->method('update')->with($news);
        $this->subject->_set('newsRepository', $newsRepository);

        $this->subject->updateAction($news);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenNewsFromNewsRepository(): void
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $newsRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\NewsRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $newsRepository->expects(self::once())->method('remove')->with($news);
        $this->subject->_set('newsRepository', $newsRepository);

        $this->subject->deleteAction($news);
    }
}
