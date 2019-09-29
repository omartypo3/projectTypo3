<?php
namespace LeadGeneration\ContactForm\Tests\Unit\Controller;

/**
 * Test case.
 */
class EventControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \LeadGeneration\ContactForm\Controller\EventController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\LeadGeneration\ContactForm\Controller\EventController::class)
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
    public function listActionFetchesAllEventsFromRepositoryAndAssignsThemToView()
    {

        $allEvents = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository = $this->getMockBuilder(\LeadGeneration\ContactForm\Domain\Repository\EventRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $eventRepository->expects(self::once())->method('findAll')->will(self::returnValue($allEvents));
        $this->inject($this->subject, 'eventRepository', $eventRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('events', $allEvents);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenEventToView()
    {
        $event = new \LeadGeneration\ContactForm\Domain\Model\Event();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('event', $event);

        $this->subject->showAction($event);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenEventToEventRepository()
    {
        $event = new \LeadGeneration\ContactForm\Domain\Model\Event();

        $eventRepository = $this->getMockBuilder(\LeadGeneration\ContactForm\Domain\Repository\EventRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('add')->with($event);
        $this->inject($this->subject, 'eventRepository', $eventRepository);

        $this->subject->createAction($event);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenEventToView()
    {
        $event = new \LeadGeneration\ContactForm\Domain\Model\Event();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('event', $event);

        $this->subject->editAction($event);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenEventInEventRepository()
    {
        $event = new \LeadGeneration\ContactForm\Domain\Model\Event();

        $eventRepository = $this->getMockBuilder(\LeadGeneration\ContactForm\Domain\Repository\EventRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('update')->with($event);
        $this->inject($this->subject, 'eventRepository', $eventRepository);

        $this->subject->updateAction($event);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenEventFromEventRepository()
    {
        $event = new \LeadGeneration\ContactForm\Domain\Model\Event();

        $eventRepository = $this->getMockBuilder(\LeadGeneration\ContactForm\Domain\Repository\EventRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('remove')->with($event);
        $this->inject($this->subject, 'eventRepository', $eventRepository);

        $this->subject->deleteAction($event);
    }
}
