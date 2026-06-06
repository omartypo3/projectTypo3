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
class UrlaubControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\UrlaubController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\UrlaubController::class))
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
    public function listActionFetchesAllUrlaubsFromRepositoryAndAssignsThemToView(): void
    {
        $allUrlaubs = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $urlaubRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\UrlaubRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $urlaubRepository->expects(self::once())->method('findAll')->will(self::returnValue($allUrlaubs));
        $this->subject->_set('urlaubRepository', $urlaubRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('urlaubs', $allUrlaubs);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenUrlaubToView(): void
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('urlaub', $urlaub);

        $this->subject->showAction($urlaub);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenUrlaubToUrlaubRepository(): void
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();

        $urlaubRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\UrlaubRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $urlaubRepository->expects(self::once())->method('add')->with($urlaub);
        $this->subject->_set('urlaubRepository', $urlaubRepository);

        $this->subject->createAction($urlaub);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenUrlaubToView(): void
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('urlaub', $urlaub);

        $this->subject->editAction($urlaub);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenUrlaubInUrlaubRepository(): void
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();

        $urlaubRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\UrlaubRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $urlaubRepository->expects(self::once())->method('update')->with($urlaub);
        $this->subject->_set('urlaubRepository', $urlaubRepository);

        $this->subject->updateAction($urlaub);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenUrlaubFromUrlaubRepository(): void
    {
        $urlaub = new \DslFactory\DslIntranet\Domain\Model\Urlaub();

        $urlaubRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\UrlaubRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $urlaubRepository->expects(self::once())->method('remove')->with($urlaub);
        $this->subject->_set('urlaubRepository', $urlaubRepository);

        $this->subject->deleteAction($urlaub);
    }
}
