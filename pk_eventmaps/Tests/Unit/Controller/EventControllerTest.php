<?php
namespace EventMaps\PkEventmaps\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Patrick Kudla 
 */
class EventControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \EventMaps\PkEventmaps\Controller\EventController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\EventMaps\PkEventmaps\Controller\EventController::class)
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

        $eventRepository = $this->getMockBuilder(\EventMaps\PkEventmaps\Domain\Repository\EventRepository::class)
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
}
