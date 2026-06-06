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
class MitarbeiterControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\MitarbeiterController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\MitarbeiterController::class))
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
    public function listActionFetchesAllMitarbeitersFromRepositoryAndAssignsThemToView(): void
    {
        $allMitarbeiters = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $mitarbeiterRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMitarbeiters));
        $this->subject->_set('mitarbeiterRepository', $mitarbeiterRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('mitarbeiters', $allMitarbeiters);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMitarbeiterToView(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('mitarbeiter', $mitarbeiter);

        $this->subject->showAction($mitarbeiter);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMitarbeiterToMitarbeiterRepository(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();

        $mitarbeiterRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterRepository->expects(self::once())->method('add')->with($mitarbeiter);
        $this->subject->_set('mitarbeiterRepository', $mitarbeiterRepository);

        $this->subject->createAction($mitarbeiter);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMitarbeiterToView(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('mitarbeiter', $mitarbeiter);

        $this->subject->editAction($mitarbeiter);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMitarbeiterInMitarbeiterRepository(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();

        $mitarbeiterRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterRepository->expects(self::once())->method('update')->with($mitarbeiter);
        $this->subject->_set('mitarbeiterRepository', $mitarbeiterRepository);

        $this->subject->updateAction($mitarbeiter);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMitarbeiterFromMitarbeiterRepository(): void
    {
        $mitarbeiter = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();

        $mitarbeiterRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $mitarbeiterRepository->expects(self::once())->method('remove')->with($mitarbeiter);
        $this->subject->_set('mitarbeiterRepository', $mitarbeiterRepository);

        $this->subject->deleteAction($mitarbeiter);
    }
}
