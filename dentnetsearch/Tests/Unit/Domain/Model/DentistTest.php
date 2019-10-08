<?php
namespace DentNetSearch\Dentnetsearch\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author ons <ons.chaari@softtodo.com>
 */
class DentistTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \DentNetSearch\Dentnetsearch\Domain\Model\Dentist
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DentNetSearch\Dentnetsearch\Domain\Model\Dentist();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getIdReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getId()
        );
    }

    /**
     * @test
     */
    public function setIdForIntSetsId()
    {
        $this->subject->setId(12);

        self::assertAttributeEquals(
            12,
            'id',
            $this->subject
        );
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
}
