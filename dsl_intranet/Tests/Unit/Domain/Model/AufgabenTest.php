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
class AufgabenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Aufgaben|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Aufgaben::class,
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
    public function getErledigtReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getErledigt());
    }

    /**
     * @test
     */
    public function setErledigtForBoolSetsErledigt(): void
    {
        $this->subject->setErledigt(true);

        self::assertEquals(true, $this->subject->_get('erledigt'));
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

    /**
     * @test
     */
    public function getAuftragReturnsInitialValueForAuftraege(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAuftrag()
        );
    }

    /**
     * @test
     */
    public function setAuftragForAuftraegeSetsAuftrag(): void
    {
        $auftragFixture = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
        $this->subject->setAuftrag($auftragFixture);

        self::assertEquals($auftragFixture, $this->subject->_get('auftrag'));
    }
}
