<?php
namespace Emagineurs\ENews\Tests\Unit\Controller;

/*********************************************************************************************************************************************************************************************
 *  Copyright notice
 *
 *  (c) 2017 xley <xley@e-magineurs.com>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *********************************************************************************************************************************************************************************************/
 
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Emagineurs\ENews\Domain\Repository\EnewsRepository;
use Emagineurs\ENews\Domain\Repository\CategoryRepository;
use Emagineurs\ENews\Domain\Repository\TagRepository;
use Emagineurs\ENews\Controller\EnewsController;
use Emagineurs\ENews\Domain\Model\Dto\NewsDemandEnews;
 
/**
 *
 *
 * @package e_news
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EnewsControllerTest extends UnitTestCase 
{
    /**
     * @return void
     */
    public function setUp()
    {
    }

    /**
     * @return void
     */
    public function tearDown()
    {
    }
	
    /**
     * @
     * test
     */
    public function testListActionMinimumAssignation() {
		/*
		$mockRepository = $this->getMock(
            EnewsRepository::class, 
            array('findDemanded'), array(), '', FALSE, FALSE, FALSE);       
        $mockRepository->expects($this->any())
            ->method('findDemanded')
            ->will($this->returnValue(['QueryResult']));
 
        $mockView = $this->getMock(
            TemplateView::class, 
            array('assignMultiple'), array(), '', FALSE);
        $mockView->expects($this->any())
            ->method('assignMultiple')
            ->with(
				'assignedValues', 
				[
					['QueryResult'],
					null,
					null
				]
			);
 
        $mockController = $this->getMock(
            $this->buildAccessibleProxy(EnewsController::class),         
            array('dummy'),array(), '', FALSE);
        $mockController->_set('enewsRepository', $mockRepository);
        $mockController->_set('view', $mockView);
        $mockController->listAction();
		*/
		
    }
	
    /**
     * @test
     */
    public function listActionAssignAllExpectedVariablesToView() {
		/*
		// Initialization of the mocking of the controller
		$mockController = $this->getAccessibleMock(
			EnewsController::class,
			[
				'emitActionSignal', 
				'createDemandObjectFromSettings'
			]
		);

		$mockController->expects($this->any())->method('createDemandObjectFromSettings')->willReturn(null);

		// Mocking of the repository to have a result for the findDemanded method
		$mockRepository = $this->getMockBuilder(EnewsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

		// Injection of the mocked repository
        $this->inject($mockController, 'enewsRepository', $mockRepository);

		// Setting of the expectation for emitActionSignal method
		// N.B : this value returned by the method is what is assigned to the view
		$controller = GeneralUtility::makeInstance(EnewsController::class);
		$signalSlotDispatcherTest = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
		$controller->signalSlotDispatcherTest = $signalSlotDispatcherTest;
		$signalResult = $controller->signalSlotDispatcherTest->dispatch(
			'GeorgRinger\\News\\Controller\\NewsController', 
			EnewsController::SIGNAL_ENEWS_LIST_ACTION, 
			[]
		);

		$mockController->expects($this->any())->method('emitActionSignal')->willReturn($signalResult);

		// Mocking of the view to have a result for the assignMultiple method
		$mockView = $this->getMockBuilder(TemplateView::class)
            ->disableOriginalConstructor()
            ->getMock();
		
		$mockView->expects($this->any())->method('assignMultiple')->with(
			$this->isType('array')
		);
			
        $mockController->listAction();
		*/
    }

    /**
     * @test
     */
    public function testOrderNewsByDatesWithoutSettings(){
		$arrayToSimulateQueryResult = $this->prepareMocksForTestingOrderNewsByDates();
		
        $controller = GeneralUtility::makeInstance(EnewsController::class);
		$result = $controller->orderNewsByDates($arrayToSimulateQueryResult);
		
        $expectedResult = [
            '123' => $arrayToSimulateQueryResult[0],
			'234' => $arrayToSimulateQueryResult[0],
			'345' => $arrayToSimulateQueryResult[1],
			'567' => $arrayToSimulateQueryResult[0],
			'678' => $arrayToSimulateQueryResult[1],
			'789' => $arrayToSimulateQueryResult[1],
			'912' => $arrayToSimulateQueryResult[0]
        ];
		
		$this->assertEquals($result, $expectedResult);
    }
	
    /**
     * @test
     */
    public function testOrderNewsByDatesOrderDesc(){
		$arrayToSimulateQueryResult = $this->prepareMocksForTestingOrderNewsByDates();
				
        $controller = GeneralUtility::makeInstance(EnewsController::class);
		
		$settings['orderDirection'] = 'desc';
        $this->inject($controller, 'settings', $settings);
		
		$result = $controller->orderNewsByDates($arrayToSimulateQueryResult);
		
        $expectedResult = [
			'912' => $arrayToSimulateQueryResult[0],
			'789' => $arrayToSimulateQueryResult[1],
			'678' => $arrayToSimulateQueryResult[1],
			'567' => $arrayToSimulateQueryResult[0],
			'345' => $arrayToSimulateQueryResult[1],
			'234' => $arrayToSimulateQueryResult[0],
            '123' => $arrayToSimulateQueryResult[0]
        ];
		
		$this->assertEquals($result, $expectedResult);
    }
	
    /**
     * @test
     */
    public function testOrderNewsByDatesWithLimit(){
		$arrayToSimulateQueryResult = $this->prepareMocksForTestingOrderNewsByDates();
				
        $controller = GeneralUtility::makeInstance(EnewsController::class);
		
		$settings['limit'] = '3';
        $this->inject($controller, 'settings', $settings);
		
		$result = $controller->orderNewsByDates($arrayToSimulateQueryResult);
		
        $expectedResult = [
            '123' => $arrayToSimulateQueryResult[0],
			'234' => $arrayToSimulateQueryResult[0],
			'345' => $arrayToSimulateQueryResult[1]
        ];
		
		$this->assertEquals($result, $expectedResult);
    }
	
    /**
     * @test
     */
    public function testOrderNewsByDatesWithLimitAndOrderDesc(){
		$arrayToSimulateQueryResult = $this->prepareMocksForTestingOrderNewsByDates();
				
        $controller = GeneralUtility::makeInstance(EnewsController::class);
		
		$settings['limit'] = '3';
		$settings['orderDirection'] = 'desc';
        $this->inject($controller, 'settings', $settings);
		
		$result = $controller->orderNewsByDates($arrayToSimulateQueryResult);
		
        $expectedResult = [
			'912' => $arrayToSimulateQueryResult[0],
			'789' => $arrayToSimulateQueryResult[1],
			'678' => $arrayToSimulateQueryResult[1]
        ];
		
		$this->assertEquals($result, $expectedResult);
    }
	
	public function prepareMocksForTestingOrderNewsByDates(){
		$mockDates1 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates1->expects($this->any())->method('getBegindate')->willReturn('123');
		
		$mockDates2 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates2->expects($this->any())->method('getBegindate')->willReturn('234');
		
		$mockDates3 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates3->expects($this->any())->method('getBegindate')->willReturn('567');
		
		$mockDates4 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates4->expects($this->any())->method('getBegindate')->willReturn('912');
		
        $mockNews1 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Enews::class)
            ->disableOriginalConstructor()
            ->getMock();			
		$mockNews1->expects($this->any())->method('getDates')->willReturn(
            [
				$mockDates1,
				$mockDates2,
				$mockDates3,
				$mockDates4
            ]
        );
		
		$mockDates5 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates5->expects($this->any())->method('getBegindate')->willReturn('345');
		
		$mockDates6 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates6->expects($this->any())->method('getBegindate')->willReturn('678');
		
		$mockDates7 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Dates::class)
            ->disableOriginalConstructor()
            ->getMock();
		$mockDates7->expects($this->any())->method('getBegindate')->willReturn('789');
        
		$mockNews2 = $this->getMockBuilder(\Emagineurs\ENews\Domain\Model\Enews::class)
            ->disableOriginalConstructor()
            ->getMock();	
		$mockNews2->expects($this->any())->method('getDates')->willReturn(
            [
				$mockDates5,
				$mockDates6,
				$mockDates7
            ]
        );
		
		return [$mockNews1, $mockNews2];
	}
	
	/************************************* MIS EN SUSPENS CAR FAUDRAIT REFAIRE LA GENERATION *************************************/
    /**
     * @test
     */
    public function testCategoryListGeneration(){
    }
	
	public function prepareMocksForCategories($uidCategory = 2){
	}
}
