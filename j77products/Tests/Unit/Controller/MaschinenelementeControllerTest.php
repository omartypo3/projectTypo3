<?php
namespace J77\J77products\Tests\Unit\Controller;

/**
 * Test case.
 */
class MaschinenelementeControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Controller\MaschinenelementeController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\J77\J77products\Controller\MaschinenelementeController::class)
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
    public function listActionFetchesAllMaschinenelementesFromRepositoryAndAssignsThemToView()
    {

        $allMaschinenelementes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maschinenelementeRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $maschinenelementeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaschinenelementes));
        $this->inject($this->subject, 'maschinenelementeRepository', $maschinenelementeRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('maschinenelementes', $allMaschinenelementes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMaschinenelementeToView()
    {
        $maschinenelemente = new \J77\J77products\Domain\Model\Maschinenelemente();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('maschinenelemente', $maschinenelemente);

        $this->subject->showAction($maschinenelemente);
    }
}
