<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class SettingTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\Setting
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\Setting();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getFieldReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getField()
        );

    }

    /**
     * @test
     */
    public function setFieldForStringSetsField()
    {
        $this->subject->setField('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'field',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getValueReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getValue()
        );

    }

    /**
     * @test
     */
    public function setValueForStringSetsValue()
    {
        $this->subject->setValue('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'value',
            $this->subject
        );

    }
}
