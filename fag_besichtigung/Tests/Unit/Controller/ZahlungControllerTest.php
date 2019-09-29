<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Controller;

/**
 * Test case.
 */
class ZahlungControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Controller\ZahlungController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Controller\ZahlungController::class)
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
    public function listActionFetchesAllZahlungsFromRepositoryAndAssignsThemToView()
    {

        $allZahlungs = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $zahlungRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\ZahlungRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $zahlungRepository->expects(self::once())->method('findAll')->will(self::returnValue($allZahlungs));
        $this->inject($this->subject, 'zahlungRepository', $zahlungRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('zahlungs', $allZahlungs);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenZahlungToView()
    {
        $zahlung = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('zahlung', $zahlung);

        $this->subject->showAction($zahlung);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenZahlungToZahlungRepository()
    {
        $zahlung = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();

        $zahlungRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\ZahlungRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $zahlungRepository->expects(self::once())->method('add')->with($zahlung);
        $this->inject($this->subject, 'zahlungRepository', $zahlungRepository);

        $this->subject->createAction($zahlung);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenZahlungToView()
    {
        $zahlung = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('zahlung', $zahlung);

        $this->subject->editAction($zahlung);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenZahlungInZahlungRepository()
    {
        $zahlung = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();

        $zahlungRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\ZahlungRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $zahlungRepository->expects(self::once())->method('update')->with($zahlung);
        $this->inject($this->subject, 'zahlungRepository', $zahlungRepository);

        $this->subject->updateAction($zahlung);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenZahlungFromZahlungRepository()
    {
        $zahlung = new \FRONTAL\FagBesichtigung\Domain\Model\Zahlung();

        $zahlungRepository = $this->getMockBuilder(\FRONTAL\FagBesichtigung\Domain\Repository\ZahlungRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $zahlungRepository->expects(self::once())->method('remove')->with($zahlung);
        $this->inject($this->subject, 'zahlungRepository', $zahlungRepository);

        $this->subject->deleteAction($zahlung);
    }
}
