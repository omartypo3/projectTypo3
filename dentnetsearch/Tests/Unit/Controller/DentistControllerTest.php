<?php
namespace DentNetSearch\Dentnetsearch\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author ons <ons.chaari@softtodo.com>
 */
class DentistControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \DentNetSearch\Dentnetsearch\Controller\DentistController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DentNetSearch\Dentnetsearch\Controller\DentistController::class)
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
    public function listActionFetchesAllDentistsFromRepositoryAndAssignsThemToView()
    {

        $allDentists = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dentistRepository = $this->getMockBuilder(\DentNetSearch\Dentnetsearch\Domain\Repository\DentistRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $dentistRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDentists));
        $this->inject($this->subject, 'dentistRepository', $dentistRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('dentists', $allDentists);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDentistToView()
    {
        $dentist = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('dentist', $dentist);

        $this->subject->showAction($dentist);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDentistToDentistRepository()
    {
        $dentist = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();

        $dentistRepository = $this->getMockBuilder(\DentNetSearch\Dentnetsearch\Domain\Repository\DentistRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $dentistRepository->expects(self::once())->method('add')->with($dentist);
        $this->inject($this->subject, 'dentistRepository', $dentistRepository);

        $this->subject->createAction($dentist);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDentistToView()
    {
        $dentist = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('dentist', $dentist);

        $this->subject->editAction($dentist);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDentistInDentistRepository()
    {
        $dentist = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();

        $dentistRepository = $this->getMockBuilder(\DentNetSearch\Dentnetsearch\Domain\Repository\DentistRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $dentistRepository->expects(self::once())->method('update')->with($dentist);
        $this->inject($this->subject, 'dentistRepository', $dentistRepository);

        $this->subject->updateAction($dentist);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDentistFromDentistRepository()
    {
        $dentist = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();

        $dentistRepository = $this->getMockBuilder(\DentNetSearch\Dentnetsearch\Domain\Repository\DentistRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $dentistRepository->expects(self::once())->method('remove')->with($dentist);
        $this->inject($this->subject, 'dentistRepository', $dentistRepository);

        $this->subject->deleteAction($dentist);
    }
}
