<?php
namespace DslFactory\DslKanban\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author mz@dsl-factory.de <mz@dsl-factory.de>
 */
class ItemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslKanban\Domain\Model\Item
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslKanban\Domain\Model\Item();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitel()
        );

    }

    /**
     * @test
     */
    public function setTitelForStringSetsTitel()
    {
        $this->subject->setTitel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'titel',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getUntertitelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUntertitel()
        );

    }

    /**
     * @test
     */
    public function setUntertitelForStringSetsUntertitel()
    {
        $this->subject->setUntertitel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'untertitel',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getNotizReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNotiz()
        );

    }

    /**
     * @test
     */
    public function setNotizForStringSetsNotiz()
    {
        $this->subject->setNotiz('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'notiz',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getRelationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getRelation()
        );

    }

    /**
     * @test
     */
    public function setRelationForStringSetsRelation()
    {
        $this->subject->setRelation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'relation',
            $this->subject
        );

    }
}
