<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Controller;

/**
 * Test case.
 */
class DatumControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Controller\DatumController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Controller\DatumController::class)
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
    public function listActionFetchesAllDataFromRepositoryAndAssignsThemToView()
    {

        $allData = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $datumRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $datumRepository->expects(self::once())->method('findAll')->will(self::returnValue($allData));
        $this->inject($this->subject, 'datumRepository', $datumRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('data', $allData);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDatumToView()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('datum', $datum);

        $this->subject->showAction($datum);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDatumToDatumRepository()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();

        $datumRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $datumRepository->expects(self::once())->method('add')->with($datum);
        $this->inject($this->subject, 'datumRepository', $datumRepository);

        $this->subject->createAction($datum);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDatumToView()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('datum', $datum);

        $this->subject->editAction($datum);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDatumInDatumRepository()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();

        $datumRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $datumRepository->expects(self::once())->method('update')->with($datum);
        $this->inject($this->subject, 'datumRepository', $datumRepository);

        $this->subject->updateAction($datum);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDatumFromDatumRepository()
    {
        $datum = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();

        $datumRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\DatumRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $datumRepository->expects(self::once())->method('remove')->with($datum);
        $this->inject($this->subject, 'datumRepository', $datumRepository);

        $this->subject->deleteAction($datum);
    }
}
