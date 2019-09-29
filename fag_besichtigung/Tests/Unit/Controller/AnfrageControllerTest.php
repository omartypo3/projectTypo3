<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Controller;

/**
 * Test case.
 */
class AnfrageControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Controller\AnfrageController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Controller\AnfrageController::class)
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
    public function listActionFetchesAllAnfragesFromRepositoryAndAssignsThemToView()
    {

        $allAnfrages = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $anfrageRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAnfrages));
        $this->inject($this->subject, 'anfrageRepository', $anfrageRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('anfrages', $allAnfrages);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAnfrageToView()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('anfrage', $anfrage);

        $this->subject->showAction($anfrage);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAnfrageToAnfrageRepository()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();

        $anfrageRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageRepository->expects(self::once())->method('add')->with($anfrage);
        $this->inject($this->subject, 'anfrageRepository', $anfrageRepository);

        $this->subject->createAction($anfrage);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAnfrageToView()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('anfrage', $anfrage);

        $this->subject->editAction($anfrage);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAnfrageInAnfrageRepository()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();

        $anfrageRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageRepository->expects(self::once())->method('update')->with($anfrage);
        $this->inject($this->subject, 'anfrageRepository', $anfrageRepository);

        $this->subject->updateAction($anfrage);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAnfrageFromAnfrageRepository()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();

        $anfrageRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\AnfrageRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageRepository->expects(self::once())->method('remove')->with($anfrage);
        $this->inject($this->subject, 'anfrageRepository', $anfrageRepository);

        $this->subject->deleteAction($anfrage);
    }
}
