<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Controller;

/**
 * Test case.
 */
class GruppentypControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Controller\GruppentypController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Controller\GruppentypController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllGruppentypsFromRepositoryAndAssignsThemToView()
    {

        $allGruppentyps = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gruppentypRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $gruppentypRepository->expects(self::once())->method('findAll')->will(self::returnValue($allGruppentyps));
        $this->inject($this->subject, 'gruppentypRepository', $gruppentypRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('gruppentyps', $allGruppentyps);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenGruppentypToView()
    {
        $gruppentyp = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('gruppentyp', $gruppentyp);

        $this->subject->showAction($gruppentyp);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenGruppentypToGruppentypRepository()
    {
        $gruppentyp = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();

        $gruppentypRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppentypRepository->expects(self::once())->method('add')->with($gruppentyp);
        $this->inject($this->subject, 'gruppentypRepository', $gruppentypRepository);

        $this->subject->createAction($gruppentyp);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenGruppentypToView()
    {
        $gruppentyp = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('gruppentyp', $gruppentyp);

        $this->subject->editAction($gruppentyp);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenGruppentypInGruppentypRepository()
    {
        $gruppentyp = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();

        $gruppentypRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppentypRepository->expects(self::once())->method('update')->with($gruppentyp);
        $this->inject($this->subject, 'gruppentypRepository', $gruppentypRepository);

        $this->subject->updateAction($gruppentyp);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenGruppentypFromGruppentypRepository()
    {
        $gruppentyp = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();

        $gruppentypRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppentypRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppentypRepository->expects(self::once())->method('remove')->with($gruppentyp);
        $this->inject($this->subject, 'gruppentypRepository', $gruppentypRepository);

        $this->subject->deleteAction($gruppentyp);
    }
}
