<?php
namespace DLD\Dld\Tests\Unit\Controller;

/**
 * Test case.
 */
class VenueControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Controller\VenueController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DLD\Dld\Controller\VenueController::class)
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
    public function listActionFetchesAllVenuesFromRepositoryAndAssignsThemToView()
    {

        $allVenues = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $venueRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\VenueRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $venueRepository->expects(self::once())->method('findAll')->will(self::returnValue($allVenues));
        $this->inject($this->subject, 'venueRepository', $venueRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('venues', $allVenues);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenVenueToView()
    {
        $venue = new \DLD\Dld\Domain\Model\Venue();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('venue', $venue);

        $this->subject->showAction($venue);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenVenueToVenueRepository()
    {
        $venue = new \DLD\Dld\Domain\Model\Venue();

        $venueRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\VenueRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $venueRepository->expects(self::once())->method('add')->with($venue);
        $this->inject($this->subject, 'venueRepository', $venueRepository);

        $this->subject->createAction($venue);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenVenueToView()
    {
        $venue = new \DLD\Dld\Domain\Model\Venue();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('venue', $venue);

        $this->subject->editAction($venue);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenVenueInVenueRepository()
    {
        $venue = new \DLD\Dld\Domain\Model\Venue();

        $venueRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\VenueRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $venueRepository->expects(self::once())->method('update')->with($venue);
        $this->inject($this->subject, 'venueRepository', $venueRepository);

        $this->subject->updateAction($venue);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenVenueFromVenueRepository()
    {
        $venue = new \DLD\Dld\Domain\Model\Venue();

        $venueRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\VenueRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $venueRepository->expects(self::once())->method('remove')->with($venue);
        $this->inject($this->subject, 'venueRepository', $venueRepository);

        $this->subject->deleteAction($venue);
    }
}
