<?php
namespace Emagineurs\EImportExport\Tests\Functional\Controller;

use Emagineurs\EImportExport\Domain\Model\Conf;
use Emagineurs\EImportExport\Handlers\AbstractHandlers;
use Emagineurs\EImportExport\Handlers\Export\AbstractHandlers as ExportAbstractHandlers;
use Emagineurs\EImportExport\Handlers\Import\AbstractHandlers as ImportAbstractHandlers;
use Mockery;
use Emagineurs\EImportExport\Domain\Repository\ConfRepository;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use Emagineurs\EImportExport\Controller\ImportExportController;

class ImportExportControllerTest extends UnitTestCase  {
	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface */
	protected $objectManager;

	/** @var  ConfRepository */
	protected $confRepository;

	protected function tearDown()
    {
		Mockery::close();
    }

	/**
	 * Test if xml import is working
	 *
	 * @test
	 *
	 * @return void
	 */
	public function confNotFoundTest() {
		$controller = new ImportExportController();

		$confRepository = Mockery::mock(ConfRepository::class);
		$confRepository->shouldReceive('findByUid')->with(1)->andReturn(null);
		$this->inject($controller, 'confRepository', $confRepository);

		$this->expectExceptionMessage('Invalid configuration uid: 1. Check your configuration state.');
		$controller->indexAction(1);
	}

	/**
	 * Test if xml import is working
	 *
	 * @test
	 *
	 * @return void
	 */
	public function handlerNotFoundTest() {
		$controller = new ImportExportController();

		$conf = Mockery::mock(Conf::class);
		$conf->shouldReceive('getHandler')->andReturn(null);

		$confRepository = Mockery::mock(ConfRepository::class);
		$confRepository->shouldReceive('findByUid')->with(1)->andReturn($conf);
		$this->inject($controller, 'confRepository', $confRepository);

		$this->expectExceptionMessage('Invalid handler, null. Check your interaction and type in GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'eImportExport\'][\'Handlers\'].');
		$controller->indexAction(1);
	}

	/**
	 * Test if xml import is working
	 *
	 * @test
	 *
	 * @return void
	 */
	public function wrongHandlerFoundTest() {
		$controller = new ImportExportController();

		$handler = Mockery::mock(AbstractHandlers::class);

		$conf = Mockery::mock(Conf::class);
		$conf->shouldReceive('getHandler')->andReturn($handler);

		$confRepository = Mockery::mock(ConfRepository::class);
		$confRepository->shouldReceive('findByUid')->with(1)->andReturn($conf);
		$this->inject($controller, 'confRepository', $confRepository);

		$this->expectExceptionMessage('Invalid handler "Mockery_2_Emagineurs_EImportExport_Handlers_AbstractHandlers", must implement the \Emagineurs\EImportExport\Handlers\AbstractHandlers class.');
		$controller->indexAction(1);
	}

	/**
	 * Test if xml import is working
	 *
	 * @test
	 *
	 * @return void
	 */
	public function exportTest() {
		$controller = new ImportExportController();

		$handler = Mockery::mock(ExportAbstractHandlers::class);
		$handler->shouldReceive('header');
		$handler->shouldReceive('export');

		$conf = Mockery::mock(Conf::class);
		$conf->shouldReceive('getHandler')->andReturn($handler);

		$confRepository = Mockery::mock(ConfRepository::class);
		$confRepository->shouldReceive('findByUid')->with(1)->andReturn($conf);
		$this->inject($controller, 'confRepository', $confRepository);

		$controller->indexAction(1);
	}

	/**
	 * Test if xml import is working
	 *
	 * @test
	 *
	 * @return void
	 */
	public function importTest() {
		$controller = new ImportExportController();

		$handler = Mockery::mock(ExportAbstractHandlers::class);
		$handler->shouldReceive('import');

		$conf = Mockery::mock(Conf::class);
		$conf->shouldReceive('getHandler')->andReturn($handler);

		$confRepository = Mockery::mock(ConfRepository::class);
		$confRepository->shouldReceive('findByUid')->with(1)->andReturn($conf);
		$this->inject($controller, 'confRepository', $confRepository);

		$controller->indexAction(1);
	}
}
