<?php
namespace J77\J77products\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class WeitereAnforderungenTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \J77\J77products\Domain\Model\WeitereAnforderungen
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \J77\J77products\Domain\Model\WeitereAnforderungen();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getWertReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getWert()
        );
    }

    /**
     * @test
     */
    public function setWertForStringSetsWert()
    {
        $this->subject->setWert('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'wert',
            $this->subject
        );
    }
}
