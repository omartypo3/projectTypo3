<?php
namespace Emagineurs\EImportExport\Tests\Functional\Controller;

use Emagineurs\EImportExport\Domain\Model\Conf;
use Emagineurs\EImportExport\Handlers\Import\AbstractHandlers;
use Mockery;
use Emagineurs\EImportExport\Domain\Repository\ConfRepository;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use Emagineurs\EImportExport\Controller\ImportExportController;

class AbstractHandlersTest extends UnitTestCase  {
	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

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
}
