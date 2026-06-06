<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 */
class MapControllerTest extends UnitTestCase
{
    /**
     * @var \Pingag\PingagAddress\Controller\MapController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Pingag\PingagAddress\Controller\MapController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllMapsFromRepositoryAndAssignsThemToView(): void
    {
        $allMaps = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mapRepository = $this->getMockBuilder(\Pingag\PingagAddress\Domain\Repository\MapRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $mapRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaps));
        $this->subject->_set('mapRepository', $mapRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('maps', $allMaps);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMapToView(): void
    {
        $map = new \Pingag\PingagAddress\Domain\Model\Map();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('map', $map);

        $this->subject->showAction($map);
    }
}
