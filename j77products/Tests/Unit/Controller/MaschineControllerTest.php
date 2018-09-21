<?php
namespace J77\J77products\Tests\Unit\Controller;

/**
 * Test case.
 */
class MaschineControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Controller\MaschineController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\J77\J77products\Controller\MaschineController::class)
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
    public function listActionFetchesAllMaschinesFromRepositoryAndAssignsThemToView()
    {

        $allMaschines = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maschineRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $maschineRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaschines));
        $this->inject($this->subject, 'maschineRepository', $maschineRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('maschines', $allMaschines);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMaschineToView()
    {
        $maschine = new \J77\J77products\Domain\Model\Maschine();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('maschine', $maschine);

        $this->subject->showAction($maschine);
    }
}
