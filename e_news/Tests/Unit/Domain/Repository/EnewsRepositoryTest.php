<?php
namespace Emagineurs\ENews\Tests\Unit\Domain\Repository;

/***************************************************************
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
 ***************************************************************/
 
use TYPO3\CMS\Core\Tests\UnitTestCase;
// use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Prophecy\Prophecy\ProphecySubjectInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use Emagineurs\ENews\Domain\Repository\EnewsRepository;
 
/**
 *
 *
 * @package e_news
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EnewsRepositoryTest extends UnitTestCase 
{
    /**
     * @var bool
     */
    protected $backupGlobals = false;
	
    /**
     * @var EnewsRepository
     */
    protected $subject;
	
    /**
     * @var ObjectManagerInterface|ProphecySubjectInterface
     */
    protected $objectManager = null;
	
	
    /**
     * @return void
     */
    public function setUp()
    {
        $objectManagerProphecy = $this->prophesize(ObjectManagerInterface::class);
        $this->objectManager = $objectManagerProphecy->reveal();
        $this->subject = new EnewsRepository($this->objectManager);
    }

    /**
     * @return void
     */
    public function tearDown()
    {
    }
	
    /**
     * @test
     */
    public function isRepository()
    {
        $this->assertInstanceOf(Repository::class, $this->subject);
    }

    /**
     * @test
     */
    public function testSettingOfSettingsInRepository(){
		$settingsToTest = [
			'setting1' => 'test de settings N1',
			'setting2' => 'test de settings N2',
			'setting3' => 'test de settings N3'
		];
		
		$paramsToTest = [
			'dateTest' => '28/09/1988',
			'filterActive' => true,
			'numberItemsToDisplay' => 15
		];
		
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $repository = GeneralUtility::makeInstance(EnewsRepository::class, $objectManager);
        $repository->setSettings($settingsToTest, $paramsToTest);
		
		$this->assertEquals($repository->settings, $settingsToTest);
		$this->assertEquals($repository->dateTest, '28/09/1988');
		$this->assertEquals($repository->filterActive, true);
		$this->assertEquals($repository->numberItemsToDisplay, 15);
    }
	
    /**
     * @test
     */
    public function testGetNewsUidFromSettings(){
		$settingsValueToTest = 'tx_news_domain_model_news_145,tx_news_domain_model_news_289,tx_news_domain_model_news_124,tx_news_domain_model_news_399';
				
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $repository = GeneralUtility::makeInstance(EnewsRepository::class, $objectManager);
		
		$settings['selectNews'] = $settingsValueToTest;
        $this->inject($repository, 'settings', $settings);
		
		$result = $repository->getNewsUidFromSettings();
		
        $expectedResult = [
			'145',
			'289',
			'124',
			'399'
		];
		
		$this->assertEquals($result, $expectedResult);		
    }

    /**
     * @test
     */
    public function testSearchConstraintsHandlerExists(){
		$mockRepository = $this->getMockBuilder(EnewsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
		
		$repoMethods = get_class_methods($mockRepository);
		
		foreach($mockRepository->arraySearch as $searchAllowed) {
			$this->assertContains('handle'.$searchAllowed.'Search', $repoMethods);
		}
	}
}
