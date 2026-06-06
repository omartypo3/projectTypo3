<?php
namespace Emagineurs\EComment\Test\Utility;

use Emagineurs\EComment\Utility\BasicUtility;
use PHPUnit\Framework\TestCase;

class BasicUtilityTest extends TestCase
{
	/**
	 * Test param parse with simple string
	 * @test
	 */
	public function parseParamPathSimpleTest()
	{
		$this->assertEquals(array('first'), BasicUtility::parseParamPath('first'));
	}

	/**
	 * Test param parse with sub-elements string
	 * @test
	 */
	public function parseParamPathComplexTest()
	{
        $this->assertEquals(array('first', 'second', 'third'), BasicUtility::parseParamPath('first[second][third]'));
	}

	/**
	 * Test param parse with empty string
	 * @test
	 */
	public function parseParamPathEmptyTest()
	{
        $this->assertEquals(array(), BasicUtility::parseParamPath(''));
	}

    /**
     * Test param parse with empty string
     * @test
     */
    public function traverseArrayByPathTest()
    {
        $this->assertEquals('good', BasicUtility::traverseArrayByPath(array('1' => array('1' => 'wrong', '2' => 'good')), array('1', '2')));
        $this->assertEquals(null, BasicUtility::traverseArrayByPath(array('1' => array('1' => 'wrong', '2' => 'good')), array('1', '3')));
    }
}