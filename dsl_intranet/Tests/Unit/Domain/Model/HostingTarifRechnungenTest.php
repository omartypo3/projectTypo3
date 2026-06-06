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
class HostingTarifRechnungenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen::class,
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
    public function getTarifReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTarif()
        );
    }

    /**
     * @test
     */
    public function setTarifForStringSetsTarif(): void
    {
        $this->subject->setTarif('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tarif'));
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
    public function getDomainnameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDomainname()
        );
    }

    /**
     * @test
     */
    public function setDomainnameForStringSetsDomainname(): void
    {
        $this->subject->setDomainname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('domainname'));
    }
}
