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
class BenutzerControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\BenutzerController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\BenutzerController::class))
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
    public function listActionFetchesAllBenutzersFromRepositoryAndAssignsThemToView(): void
    {
        $allBenutzers = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $benutzerRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $benutzerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allBenutzers));
        $this->subject->_set('benutzerRepository', $benutzerRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('benutzers', $allBenutzers);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBenutzerToView(): void
    {
        $benutzer = new \DslFactory\DslIntranet\Domain\Model\Benutzer();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('benutzer', $benutzer);

        $this->subject->showAction($benutzer);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenBenutzerToBenutzerRepository(): void
    {
        $benutzer = new \DslFactory\DslIntranet\Domain\Model\Benutzer();

        $benutzerRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $benutzerRepository->expects(self::once())->method('add')->with($benutzer);
        $this->subject->_set('benutzerRepository', $benutzerRepository);

        $this->subject->createAction($benutzer);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenBenutzerToView(): void
    {
        $benutzer = new \DslFactory\DslIntranet\Domain\Model\Benutzer();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('benutzer', $benutzer);

        $this->subject->editAction($benutzer);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenBenutzerInBenutzerRepository(): void
    {
        $benutzer = new \DslFactory\DslIntranet\Domain\Model\Benutzer();

        $benutzerRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $benutzerRepository->expects(self::once())->method('update')->with($benutzer);
        $this->subject->_set('benutzerRepository', $benutzerRepository);

        $this->subject->updateAction($benutzer);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenBenutzerFromBenutzerRepository(): void
    {
        $benutzer = new \DslFactory\DslIntranet\Domain\Model\Benutzer();

        $benutzerRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $benutzerRepository->expects(self::once())->method('remove')->with($benutzer);
        $this->subject->_set('benutzerRepository', $benutzerRepository);

        $this->subject->deleteAction($benutzer);
    }
}
