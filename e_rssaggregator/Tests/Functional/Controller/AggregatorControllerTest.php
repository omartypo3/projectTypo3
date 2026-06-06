<?php
namespace Emagineurs\ERssaggregator\Tests\Functional\Controller;

use Emagineurs\ERssaggregator\Controller\AggregatorController;
use Emagineurs\ERssaggregator\Lib\ReadRSS;
use Mockery;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\AbstractView;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class AggregatorControllerTest extends FunctionalTestCase {
	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface */
	protected $objectManager;

	/** @var array */
	protected $coreExtensionsToLoad  = ['extbase'];

	/** @var array */
	protected $testExtensionsToLoad = ['EXT:e_rssaggregator'];

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

	/**
	 * A simple test to assert that test1.xml give the good values to the template engine
	 * @test
	 */
	public function simpleTest()
	{
		$expected = array(
			array(
				"article_title" => "Title2",
				"article_link" => "http://www.url2.com/",
				"article_comments" => NULL,
				"article_pubDate"=> "Thu, 13 Apr 2017 12:34:00 +0200",
				"article_timestamp" => 1492079640,
				"article_strftime" => false,
				"article_description" => "Description2",
				"article_creator" => NULL,
				"article_author" => NULL,
				"article_category" => NULL,
				"article_content" => "",
				"article_bodytext" => "Description2",
				"channel_title" => "My RSS Stream",
				"channel_link" => "http://www.url.com/",
				"channel_description" => "My RSS Stream Description",
				"channel_pubDate" => NULL,
				"channel_timestamp" => false,
				"channel_generator" => "",
				"channel_language" => "fr",
				"channel_image" => "http://www.url.com/test.png"
			),
			array(
				"article_title" => "Title1",
				"article_link" => "http://www.url1.com/",
				"article_comments" => NULL,
				"article_pubDate"=> "Thu, 13 Apr 2017 12:35:00 +0200",
				"article_timestamp" => 1492079700,
				"article_strftime" => false,
				"article_description" => "<img alt=\"image\" src=\"http://www.url1.com/test.png\" />Description1",
				"article_creator" => NULL,
				"article_author" => NULL,
				"article_category" => NULL,
				"article_content" => "",
				"article_bodytext" => "<img alt=\"image\" src=\"http://www.url1.com/test.png\" />Description1",
				"article_image" => "http://www.url1.com/test.png",
				"channel_title" => "My RSS Stream",
				"channel_link" => "http://www.url.com/",
				"channel_description" => "My RSS Stream Description",
				"channel_pubDate" => NULL,
				"channel_timestamp" => false,
				"channel_generator" => "",
				"channel_language" => "fr",
				"channel_image" => "http://www.url.com/test.png"
			)
		);

		//mock the view
		$view = Mockery::mock(AbstractView::class);
		$view->shouldReceive('assign')->with('items', $expected)->once();
		$view->shouldReceive('assign')->with('nbRssStream', 1)->once();

		//configure the controller
		$controller = new AggregatorController();
		$this->inject($controller, 'view', $view);

		$settings = array();
		$settings['listFeed'] = 'http://test.com/';
		$settings['limit'] = 10;
		$settings['limit2'] = 10;
		$settings['formatDate'] = '%A %d %B %Y; %Hh%M';
		$settings['stripHTML'] = 0;
		$settings['cropAdd'] = '...';
		$settings['cropTitle'] = 100;
		$settings['cropDesc'] = 100;
		$settings['cropContent'] = 500;
		$settings['cropContenu'] = 500;
		$settings['target'] = '_blank';
		$settings['image'] = 1;
		$settings['imageWidth'] = 250;
		$settings['imageHeight'] = 250;
		$settings['cache'] = 4;

		$this->inject($controller, 'settings', $settings);

		//stub the file
		$testFileContents = file_get_contents(__DIR__ . '/../FileExamples/test1.xml', 'r');
		$parser = Mockery::mock(ReadRSS::class . '[getUrl]');
		$parser->shouldReceive('getUrl')->with('http://test.com/')->andReturn($testFileContents)->once();
		$this->rssParser = GeneralUtility::addInstance(ReadRSS::class, $parser);

		//and execute the action
		$controller->initializeAction();
		$controller->listAction();
	}

	/**
	 * A simple test to assert that test1.xml give the good values to the template engine
	 * @test
	 */
	public function multipleRSSTest()
	{
		$expected = array(
			array(
				"article_title" => "Title2",
				"article_link" => "http://www.url2.com/",
				"article_comments" => NULL,
				"article_pubDate"=> "Thu, 13 Apr 2017 12:34:00 +0200",
				"article_timestamp" => 1492079640,
				"article_strftime" => false,
				"article_description" => "Description2",
				"article_creator" => NULL,
				"article_author" => NULL,
				"article_category" => NULL,
				"article_content" => "",
				"article_bodytext" => "Description2",
				"channel_title" => "My RSS Stream",
				"channel_link" => "http://www.url.com/",
				"channel_description" => "My RSS Stream Description",
				"channel_pubDate" => NULL,
				"channel_timestamp" => false,
				"channel_generator" => "",
				"channel_language" => "fr",
				"channel_image" => "http://www.url.com/test.png"
			),
			array(
				"article_title" => "Title3",
				"article_link" => "http://www.url3.com/",
				"article_comments" => NULL,
				"article_pubDate"=> "Thu, 13 Apr 2017 12:34:00 +0200",
				"article_timestamp" => 1492079670,
				"article_strftime" => false,
				"article_description" => "Description3",
				"article_creator" => NULL,
				"article_author" => NULL,
				"article_category" => NULL,
				"article_content" => "",
				"article_bodytext" => "Description3",
				"channel_title" => "My RSS Stream 2",
				"channel_link" => "http://www.other.com/",
				"channel_description" => "My RSS Stream Description 2",
				"channel_pubDate" => NULL,
				"channel_timestamp" => false,
				"channel_generator" => "",
				"channel_language" => "fr",
				"channel_image" => "http://www.other.com/test.png"
			),
			array(
				"article_title" => "Title1",
				"article_link" => "http://www.url1.com/",
				"article_comments" => NULL,
				"article_pubDate"=> "Thu, 13 Apr 2017 12:35:00 +0200",
				"article_timestamp" => 1492079700,
				"article_strftime" => false,
				"article_description" => "<img alt=\"image\" src=\"http://www.url1.com/test.png\" />Description1",
				"article_creator" => NULL,
				"article_author" => NULL,
				"article_category" => NULL,
				"article_content" => "",
				"article_bodytext" => "<img alt=\"image\" src=\"http://www.url1.com/test.png\" />Description1",
				"article_image" => "http://www.url1.com/test.png",
				"channel_title" => "My RSS Stream",
				"channel_link" => "http://www.url.com/",
				"channel_description" => "My RSS Stream Description",
				"channel_pubDate" => NULL,
				"channel_timestamp" => false,
				"channel_generator" => "",
				"channel_language" => "fr",
				"channel_image" => "http://www.url.com/test.png"
			)
		);

		//mock the view
		$view = Mockery::mock(AbstractView::class);
		$view->shouldReceive('assign')->with('items', $expected)->once();
		$view->shouldReceive('assign')->with('nbRssStream', 1)->once();

		//configure the controller
		$controller = new AggregatorController();
		$this->inject($controller, 'view', $view);

		$settings = array();
		$settings['listFeed'] = "http://test.com/\nhttp://test2.com/";
		$settings['limit'] = 10;
		$settings['limit2'] = 10;
		$settings['formatDate'] = '%A %d %B %Y; %Hh%M';
		$settings['stripHTML'] = 0;
		$settings['cropAdd'] = '...';
		$settings['cropTitle'] = 100;
		$settings['cropDesc'] = 100;
		$settings['cropContent'] = 500;
		$settings['cropContenu'] = 500;
		$settings['target'] = '_blank';
		$settings['image'] = 1;
		$settings['imageWidth'] = 250;
		$settings['imageHeight'] = 250;
		$settings['cache'] = 4;

		$this->inject($controller, 'settings', $settings);

		//stub the file
		$testFileContents = file_get_contents(__DIR__ . '/../FileExamples/test1.xml', 'r');
		$testFileContents2 = file_get_contents(__DIR__ . '/../FileExamples/test2.xml', 'r');
		$parser = Mockery::mock(ReadRSS::class . '[getUrl]');
		$parser->shouldReceive('getUrl')->with('http://test.com/')->andReturn($testFileContents)->once();
		$parser->shouldReceive('getUrl')->with('http://test2.com/')->andReturn($testFileContents2)->once();
		$this->rssParser = GeneralUtility::addInstance(ReadRSS::class, $parser);

		//and execute the action
		$controller->initializeAction();
		$controller->listAction();
	}
}