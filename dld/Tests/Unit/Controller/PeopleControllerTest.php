<?php
namespace DLD\Dld\Tests\Unit\Controller;

/**
 * Test case.
 */
class PeopleControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Controller\PeopleController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DLD\Dld\Controller\PeopleController::class)
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
    public function listActionFetchesAllPeoplesFromRepositoryAndAssignsThemToView()
    {

        $allPeoples = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $peopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\PeopleRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $peopleRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPeoples));
        $this->inject($this->subject, 'peopleRepository', $peopleRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('peoples', $allPeoples);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPeopleToView()
    {
        $people = new \DLD\Dld\Domain\Model\People();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('people', $people);

        $this->subject->showAction($people);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPeopleToPeopleRepository()
    {
        $people = new \DLD\Dld\Domain\Model\People();

        $peopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\PeopleRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $peopleRepository->expects(self::once())->method('add')->with($people);
        $this->inject($this->subject, 'peopleRepository', $peopleRepository);

        $this->subject->createAction($people);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPeopleToView()
    {
        $people = new \DLD\Dld\Domain\Model\People();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('people', $people);

        $this->subject->editAction($people);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPeopleInPeopleRepository()
    {
        $people = new \DLD\Dld\Domain\Model\People();

        $peopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\PeopleRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $peopleRepository->expects(self::once())->method('update')->with($people);
        $this->inject($this->subject, 'peopleRepository', $peopleRepository);

        $this->subject->updateAction($people);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPeopleFromPeopleRepository()
    {
        $people = new \DLD\Dld\Domain\Model\People();

        $peopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\PeopleRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $peopleRepository->expects(self::once())->method('remove')->with($people);
        $this->inject($this->subject, 'peopleRepository', $peopleRepository);

        $this->subject->deleteAction($people);
    }
}
