<?php
namespace DLD\Dld\Tests\Unit\Controller;

/**
 * Test case.
 */
class SessionPeopleControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Controller\SessionPeopleController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DLD\Dld\Controller\SessionPeopleController::class)
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
    public function listActionFetchesAllSessionPeoplesFromRepositoryAndAssignsThemToView()
    {

        $allSessionPeoples = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sessionPeopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SessionPeopleRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $sessionPeopleRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSessionPeoples));
        $this->inject($this->subject, 'sessionPeopleRepository', $sessionPeopleRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('sessionPeoples', $allSessionPeoples);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenSessionPeopleToView()
    {
        $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('sessionPeople', $sessionPeople);

        $this->subject->showAction($sessionPeople);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSessionPeopleToSessionPeopleRepository()
    {
        $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();

        $sessionPeopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SessionPeopleRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $sessionPeopleRepository->expects(self::once())->method('add')->with($sessionPeople);
        $this->inject($this->subject, 'sessionPeopleRepository', $sessionPeopleRepository);

        $this->subject->createAction($sessionPeople);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenSessionPeopleToView()
    {
        $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('sessionPeople', $sessionPeople);

        $this->subject->editAction($sessionPeople);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenSessionPeopleInSessionPeopleRepository()
    {
        $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();

        $sessionPeopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SessionPeopleRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $sessionPeopleRepository->expects(self::once())->method('update')->with($sessionPeople);
        $this->inject($this->subject, 'sessionPeopleRepository', $sessionPeopleRepository);

        $this->subject->updateAction($sessionPeople);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSessionPeopleFromSessionPeopleRepository()
    {
        $sessionPeople = new \DLD\Dld\Domain\Model\SessionPeople();

        $sessionPeopleRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SessionPeopleRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $sessionPeopleRepository->expects(self::once())->method('remove')->with($sessionPeople);
        $this->inject($this->subject, 'sessionPeopleRepository', $sessionPeopleRepository);

        $this->subject->deleteAction($sessionPeople);
    }
}
