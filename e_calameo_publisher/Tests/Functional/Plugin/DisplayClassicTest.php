<?php
namespace Emagineurs\ERssaggregator\Tests\Functional\Controller;

use Mockery;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use Emagineurs\ECalameoPublisher\Service\CalameoService;
use Emagineurs\ECalameoPublisher\Controller\CalameoPluginController;

class DisplayClassicTest extends FunctionalTestCase {
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface */
    protected $objectManager;

    /** @var array */
    protected $coreExtensionsToLoad  = ['extbase'];

    /** @var array */
    protected $testExtensionsToLoad = ['EXT:e_calameo_publisher'];

    protected $timezone = null;

    public function setUp() {
        parent::setUp();

        $this->timezone = date_default_timezone_get();
        date_default_timezone_set('UTC');

        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->setUpBackendUserFromFixture(1);
        Bootstrap::getInstance()->initializeLanguageObject();
    }

    protected function tearDown() {
        Mockery::close();

        date_default_timezone_set($this->timezone);
        GeneralUtility::purgeInstances();
    }

    public function displayClassicTest() {
        //stub the curl request
        $service = Mockery::mock(CalameoService::class . '[sendRequest]');

        $parameters = array(
            'apikey' => null,
            'action' => "getBookInfos",
            'output' => "XML",
            'expires' => time() + 60,
            'book_id' => 10
        );
        $service->shouldReceive('sendRequest')->with(null, $parameters)->andReturn(1);

        $parameters = array(
            'apikey' => null,
            'action' => "getBookInfos",
            'output' => "XML",
            'expires' => time() + 60,
            'book_id' => 21
        );
        $service->shouldReceive('sendRequest')->with(null, $parameters)->andReturn(1);

        $parameters = array(
            'apikey' => null,
            'action' => "getBookInfos",
            'output' => "XML",
            'expires' => time() + 60,
            'book_id' => 32
        );
        $service->shouldReceive('sendRequest')->with(null, $parameters)->andReturn(1);

        GeneralUtility::addInstance(CalameoService::class, $service);

        //mock the view
        $view = Mockery::mock(AbstractView::class);
        $view->shouldReceive('assign')->with('items', 2)->once();
        $view->shouldReceive('assign')->with('nbRssStream', 1)->once();

        //define settings
        $settings = array();
        $settings['width'] = 400;
        $settings['height'] = 350;
        $settings['documentSelection'] = '10,21,32';

        //inject mocks
        /** @var CalameoPluginController $controller */
        $controller = GeneralUtility::makeInstance(CalameoPluginController::class);
        $this->inject($controller, 'settings', $settings);
        $this->inject($controller, 'view', $view);
        $controller->injectObjectManager($this->objectManager);

        //execute the action
        $controller->indexAction();
    }
}