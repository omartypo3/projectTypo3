<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Controller;

/**
 * Test case.
 */
class GruppenFuhrerControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Controller\GruppenFuhrerController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Controller\GruppenFuhrerController::class)
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
    public function listActionFetchesAllGruppenFuhrersFromRepositoryAndAssignsThemToView()
    {

        $allGruppenFuhrers = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppenFuhrerRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $gruppenFuhrerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allGruppenFuhrers));
        $this->inject($this->subject, 'gruppenFuhrerRepository', $gruppenFuhrerRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('gruppenFuhrers', $allGruppenFuhrers);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenGruppenFuhrerToView()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('gruppenFuhrer', $gruppenFuhrer);

        $this->subject->showAction($gruppenFuhrer);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenGruppenFuhrerToGruppenFuhrerRepository()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();

        $gruppenFuhrerRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppenFuhrerRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerRepository->expects(self::once())->method('add')->with($gruppenFuhrer);
        $this->inject($this->subject, 'gruppenFuhrerRepository', $gruppenFuhrerRepository);

        $this->subject->createAction($gruppenFuhrer);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenGruppenFuhrerToView()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('gruppenFuhrer', $gruppenFuhrer);

        $this->subject->editAction($gruppenFuhrer);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenGruppenFuhrerInGruppenFuhrerRepository()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();

        $gruppenFuhrerRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppenFuhrerRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerRepository->expects(self::once())->method('update')->with($gruppenFuhrer);
        $this->inject($this->subject, 'gruppenFuhrerRepository', $gruppenFuhrerRepository);

        $this->subject->updateAction($gruppenFuhrer);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenGruppenFuhrerFromGruppenFuhrerRepository()
    {
        $gruppenFuhrer = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();

        $gruppenFuhrerRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\GruppenFuhrerRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $gruppenFuhrerRepository->expects(self::once())->method('remove')->with($gruppenFuhrer);
        $this->inject($this->subject, 'gruppenFuhrerRepository', $gruppenFuhrerRepository);

        $this->subject->deleteAction($gruppenFuhrer);
    }
}
