<?php
namespace J77\J77products\Tests\Unit\Controller;

/**
 * Test case.
 */
class ProzessanlageControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Controller\ProzessanlageController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\J77\J77products\Controller\ProzessanlageController::class)
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
    public function listActionFetchesAllProzessanlagesFromRepositoryAndAssignsThemToView()
    {

        $allProzessanlages = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $prozessanlageRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $prozessanlageRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProzessanlages));
        $this->inject($this->subject, 'prozessanlageRepository', $prozessanlageRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('prozessanlages', $allProzessanlages);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProzessanlageToView()
    {
        $prozessanlage = new \J77\J77products\Domain\Model\Prozessanlage();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('prozessanlage', $prozessanlage);

        $this->subject->showAction($prozessanlage);
    }
}
