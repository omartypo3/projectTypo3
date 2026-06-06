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
class ZusatzleistungenControllerTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Controller\ZusatzleistungenController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\DslFactory\DslIntranet\Controller\ZusatzleistungenController::class))
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
    public function listActionFetchesAllZusatzleistungensFromRepositoryAndAssignsThemToView(): void
    {
        $allZusatzleistungens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $zusatzleistungenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allZusatzleistungens));
        $this->subject->_set('zusatzleistungenRepository', $zusatzleistungenRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('zusatzleistungens', $allZusatzleistungens);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenZusatzleistungenToView(): void
    {
        $zusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zusatzleistungen', $zusatzleistungen);

        $this->subject->showAction($zusatzleistungen);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenZusatzleistungenToZusatzleistungenRepository(): void
    {
        $zusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();

        $zusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzleistungenRepository->expects(self::once())->method('add')->with($zusatzleistungen);
        $this->subject->_set('zusatzleistungenRepository', $zusatzleistungenRepository);

        $this->subject->createAction($zusatzleistungen);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenZusatzleistungenToView(): void
    {
        $zusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('zusatzleistungen', $zusatzleistungen);

        $this->subject->editAction($zusatzleistungen);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenZusatzleistungenInZusatzleistungenRepository(): void
    {
        $zusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();

        $zusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzleistungenRepository->expects(self::once())->method('update')->with($zusatzleistungen);
        $this->subject->_set('zusatzleistungenRepository', $zusatzleistungenRepository);

        $this->subject->updateAction($zusatzleistungen);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenZusatzleistungenFromZusatzleistungenRepository(): void
    {
        $zusatzleistungen = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();

        $zusatzleistungenRepository = $this->getMockBuilder(\DslFactory\DslIntranet\Domain\Repository\ZusatzleistungenRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $zusatzleistungenRepository->expects(self::once())->method('remove')->with($zusatzleistungen);
        $this->subject->_set('zusatzleistungenRepository', $zusatzleistungenRepository);

        $this->subject->deleteAction($zusatzleistungen);
    }
}
