<?php
namespace Emagineurs\EImportExport\Tests\Functional\Controller;

use Emagineurs\EImportExport\Domain\Repository\FieldRepository;
use Emagineurs\EImportExport\Domain\Repository\GenericRepository;
use Emagineurs\EImportExport\Domain\Repository\TableRepository;
use Mockery;
use Emagineurs\EImportExport\Domain\Repository\ConfRepository;
use Emagineurs\EImportExport\Handlers\Import\XmlHandlers;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Emagineurs\EImportExport\Controller\ImportExportController;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class JsonExportTest extends FunctionalTestCase {
	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface */
	protected $objectManager;

	/** @var  ConfRepository */
	protected $confRepository;

	/** @var  FieldRepository */
	protected $fieldRepository;

	/** @var  TableRepository */
	protected $tableRepository;

	protected $testExtensionsToLoad = ['EXT:e_import_export'];

	public function setUp() {
		parent::setUp();

		$this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$this->confRepository = $this->objectManager->get(ConfRepository::class);
		$this->fieldRepository = $this->objectManager->get(FieldRepository::class);
		$this->tableRepository = $this->objectManager->get(TableRepository::class);

		$this->setUpBackendUserFromFixture(1);
		Bootstrap::getInstance()->initializeLanguageObject();

		$this->importDataSet(__DIR__ . '/../Fixtures/tx_eimportexport_domain_model_conf.xml');
		$this->importDataSet(__DIR__ . '/../Fixtures/tx_eimportexport_domain_model_field.xml');
		$this->importDataSet(__DIR__ . '/../Fixtures/tx_eimportexport_domain_model_table.xml');
	}
	
    protected function tearDown() {
		Mockery::close();
    }

	/**
	 * Test for JSON file
	 *
	 * @test
	 * @return void
	 */
	public function importJsonTest() {
		$this->importTest(1, 'test1.xml', 'xml',
			[
				'fe_groups' => [
					['title' => 'value1', 'pid' => '1', 'description' => 'id1'],
					['title' => 'value2', 'pid' => '1', 'description' => 'id2']
				]
			]
		);
	}

	/**
	 * Generic test for all import
	 *
	 * @return void
	 */
	public function importTest($confuid, $filename, $handlerType, $rows) {
		$conf = $this->confRepository->findByUid($confuid);
		$conf->setForceadd(false);
		$this->importConfTest($conf, $filename, $handlerType, [], $rows, [], true);
		/*$this->importConfTest($conf, $filename, $handlerType, $rows, [], $rows, true);
		$conf->setForceadd(true);
		$this->importConfTest($conf, $filename, $handlerType, $rows, $rows, [], true);*/
	}

	/**
	 * Generic test for all import
	 *
	 * @return void
	 */
	public function importConfTest($conf, $filename, $handlerType, $defaultRows, $addedRows, $updatedRows, $useTCA)
	{
		//stub the file
		/** @var XmlHandlers $xmlHandler */
		$testFileStream = fopen(__DIR__ . '/../FileExamples/' . $filename, 'r');
		$xmlHandler = Mockery::mock(XmlHandlers::class . '[openFile]', array($conf))->shouldAllowMockingProtectedMethods();
		$xmlHandler->shouldReceive('openFile')->andReturn($testFileStream);

		GeneralUtility::addInstance($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['eImportExport']['Handlers']['import'][$handlerType], $xmlHandler);

		//mock the general repository
		$genericRepository = Mockery::mock(GenericRepository::class . '[add,update]');

		foreach($defaultRows as $table => $rows) {
			foreach ($rows as $index => $row) {
				$genericRepository->shouldReceive('find')->with($table, array('uid' => $index), $useTCA)->andReturn(array_merge(['uid' => $index], $row));
			}
		}

		foreach($addedRows as $table => $rows) {
			foreach ($rows as $index => $row) {
				$genericRepository->shouldReceive('add')->with($table, $row, $useTCA)->andReturn($index)->once();
			}
		}

		foreach($updatedRows as $table => $rows) {
			foreach ($rows as $index => $row) {
				$genericRepository->shouldReceive('update')->with($index, $table, $row, $useTCA)->once();
			}
		}

		GeneralUtility::setSingletonInstance(GenericRepository::class, $genericRepository);

		//execute the controller action
		/** @var ImportExportController $controller */
		$controller = GeneralUtility::makeInstance(ImportExportController::class);
		$this->inject($controller, 'confRepository', $this->confRepository);

		$contents = $controller->indexAction(1);
		$contents = unserialize($contents);

		$shouldBeCreatedCount = 0;
		foreach($addedRows as $table => $rows) {
			$shouldBeCreatedCount += count($rows);
		}

		$shouldBeUpdatedCount = 0;
		foreach($updatedRows as $table => $rows) {
			$shouldBeUpdatedCount += count($rows);
		}

		$this->assertEquals($contents['create'], $shouldBeCreatedCount);
		$this->assertEquals($contents['update'], $shouldBeUpdatedCount);
	}
}
