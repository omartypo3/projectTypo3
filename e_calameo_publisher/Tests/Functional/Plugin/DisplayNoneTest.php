<?php
namespace Emagineurs\ERssaggregator\Tests\Functional\Controller;

use Mockery;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class DisplayNoneTest extends FunctionalTestCase {
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


}