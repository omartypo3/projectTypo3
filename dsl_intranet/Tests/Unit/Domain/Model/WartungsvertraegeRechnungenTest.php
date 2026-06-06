<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class WartungsvertraegeRechnungenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getVonReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getVon()
        );
    }

    /**
     * @test
     */
    public function setVonForDateTimeSetsVon(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setVon($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('von'));
    }

    /**
     * @test
     */
    public function getBisReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getBis()
        );
    }

    /**
     * @test
     */
    public function setBisForDateTimeSetsBis(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setBis($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('bis'));
    }

    /**
     * @test
     */
    public function getPreisReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getPreis()
        );
    }

    /**
     * @test
     */
    public function setPreisForFloatSetsPreis(): void
    {
        $this->subject->setPreis(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('preis'));
    }

    /**
     * @test
     */
    public function getNotizReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNotiz()
        );
    }

    /**
     * @test
     */
    public function setNotizForStringSetsNotiz(): void
    {
        $this->subject->setNotiz('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('notiz'));
    }

    /**
     * @test
     */
    public function getEckdatenReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEckdaten()
        );
    }

    /**
     * @test
     */
    public function setEckdatenForStringSetsEckdaten(): void
    {
        $this->subject->setEckdaten('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('eckdaten'));
    }

    /**
     * @test
     */
    public function getTypeReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getType()
        );
    }

    /**
     * @test
     */
    public function setTypeForIntSetsType(): void
    {
        $this->subject->setType(12);

        self::assertEquals(12, $this->subject->_get('type'));
    }

    /**
     * @test
     */
    public function getStatusReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getStatus()
        );
    }

    /**
     * @test
     */
    public function setStatusForIntSetsStatus(): void
    {
        $this->subject->setStatus(12);

        self::assertEquals(12, $this->subject->_get('status'));
    }

    /**
     * @test
     */
    public function getPreisMehraufwandReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getPreisMehraufwand()
        );
    }

    /**
     * @test
     */
    public function setPreisMehraufwandForFloatSetsPreisMehraufwand(): void
    {
        $this->subject->setPreisMehraufwand(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('preisMehraufwand'));
    }
}
