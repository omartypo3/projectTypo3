<?php
namespace DLD\Dld\Tests\Unit\Controller;

/**
 * Test case.
 */
class SettingControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Controller\SettingController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DLD\Dld\Controller\SettingController::class)
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
    public function listActionFetchesAllSettingsFromRepositoryAndAssignsThemToView()
    {

        $allSettings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $settingRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SettingRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $settingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSettings));
        $this->inject($this->subject, 'settingRepository', $settingRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('settings', $allSettings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenSettingToView()
    {
        $setting = new \DLD\Dld\Domain\Model\Setting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('setting', $setting);

        $this->subject->showAction($setting);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSettingToSettingRepository()
    {
        $setting = new \DLD\Dld\Domain\Model\Setting();

        $settingRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SettingRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $settingRepository->expects(self::once())->method('add')->with($setting);
        $this->inject($this->subject, 'settingRepository', $settingRepository);

        $this->subject->createAction($setting);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenSettingToView()
    {
        $setting = new \DLD\Dld\Domain\Model\Setting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('setting', $setting);

        $this->subject->editAction($setting);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenSettingInSettingRepository()
    {
        $setting = new \DLD\Dld\Domain\Model\Setting();

        $settingRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SettingRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $settingRepository->expects(self::once())->method('update')->with($setting);
        $this->inject($this->subject, 'settingRepository', $settingRepository);

        $this->subject->updateAction($setting);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSettingFromSettingRepository()
    {
        $setting = new \DLD\Dld\Domain\Model\Setting();

        $settingRepository = $this->getMockBuilder(\DLD\Dld\Domain\Repository\SettingRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $settingRepository->expects(self::once())->method('remove')->with($setting);
        $this->inject($this->subject, 'settingRepository', $settingRepository);

        $this->subject->deleteAction($setting);
    }
}
