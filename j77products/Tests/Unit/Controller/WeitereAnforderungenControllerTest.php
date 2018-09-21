<?php
namespace J77\J77products\Tests\Unit\Controller;

/**
 * Test case.
 */
class WeitereAnforderungenControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Controller\WeitereAnforderungenController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\J77\J77products\Controller\WeitereAnforderungenController::class)
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
    public function listActionFetchesAllWeitereAnforderungensFromRepositoryAndAssignsThemToView()
    {

        $allWeitereAnforderungens = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $weitereAnforderungenRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $weitereAnforderungenRepository->expects(self::once())->method('findAll')->will(self::returnValue($allWeitereAnforderungens));
        $this->inject($this->subject, 'weitereAnforderungenRepository', $weitereAnforderungenRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('weitereAnforderungens', $allWeitereAnforderungens);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenWeitereAnforderungenToView()
    {
        $weitereAnforderungen = new \J77\J77products\Domain\Model\WeitereAnforderungen();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('weitereAnforderungen', $weitereAnforderungen);

        $this->subject->showAction($weitereAnforderungen);
    }
}
