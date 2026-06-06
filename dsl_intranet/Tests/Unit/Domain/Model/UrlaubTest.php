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
class UrlaubTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Urlaub|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Urlaub::class,
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
    public function getBeginReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getBegin()
        );
    }

    /**
     * @test
     */
    public function setBeginForDateTimeSetsBegin(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setBegin($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('begin'));
    }

    /**
     * @test
     */
    public function getEndReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getEnd()
        );
    }

    /**
     * @test
     */
    public function setEndForDateTimeSetsEnd(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setEnd($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('end'));
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
    public function getTitelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitel()
        );
    }

    /**
     * @test
     */
    public function setTitelForStringSetsTitel(): void
    {
        $this->subject->setTitel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('titel'));
    }

    /**
     * @test
     */
    public function getTageReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getTage()
        );
    }

    /**
     * @test
     */
    public function setTageForIntSetsTage(): void
    {
        $this->subject->setTage(12);

        self::assertEquals(12, $this->subject->_get('tage'));
    }

    /**
     * @test
     */
    public function getTageResturlaubReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getTageResturlaub()
        );
    }

    /**
     * @test
     */
    public function setTageResturlaubForIntSetsTageResturlaub(): void
    {
        $this->subject->setTageResturlaub(12);

        self::assertEquals(12, $this->subject->_get('tageResturlaub'));
    }

    /**
     * @test
     */
    public function getOldidReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getOldid()
        );
    }

    /**
     * @test
     */
    public function setOldidForIntSetsOldid(): void
    {
        $this->subject->setOldid(12);

        self::assertEquals(12, $this->subject->_get('oldid'));
    }

    /**
     * @test
     */
    public function getSonstigesReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getSonstiges());
    }

    /**
     * @test
     */
    public function setSonstigesForBoolSetsSonstiges(): void
    {
        $this->subject->setSonstiges(true);

        self::assertEquals(true, $this->subject->_get('sonstiges'));
    }

    /**
     * @test
     */
    public function getMitarbeiterReturnsInitialValueForMitarbeiter(): void
    {
        self::assertEquals(
            null,
            $this->subject->getMitarbeiter()
        );
    }

    /**
     * @test
     */
    public function setMitarbeiterForMitarbeiterSetsMitarbeiter(): void
    {
        $mitarbeiterFixture = new \DslFactory\DslIntranet\Domain\Model\Mitarbeiter();
        $this->subject->setMitarbeiter($mitarbeiterFixture);

        self::assertEquals($mitarbeiterFixture, $this->subject->_get('mitarbeiter'));
    }
}
