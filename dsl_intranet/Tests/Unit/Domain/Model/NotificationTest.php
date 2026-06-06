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
class NotificationTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Notification|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Notification::class,
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
    public function getArtReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getArt()
        );
    }

    /**
     * @test
     */
    public function setArtForIntSetsArt(): void
    {
        $this->subject->setArt(12);

        self::assertEquals(12, $this->subject->_get('art'));
    }

    /**
     * @test
     */
    public function getGelesenReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getGelesen()
        );
    }

    /**
     * @test
     */
    public function setGelesenForIntSetsGelesen(): void
    {
        $this->subject->setGelesen(12);

        self::assertEquals(12, $this->subject->_get('gelesen'));
    }

    /**
     * @test
     */
    public function getWert1ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getWert1()
        );
    }

    /**
     * @test
     */
    public function setWert1ForStringSetsWert1(): void
    {
        $this->subject->setWert1('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('wert1'));
    }

    /**
     * @test
     */
    public function getWert2ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getWert2()
        );
    }

    /**
     * @test
     */
    public function setWert2ForStringSetsWert2(): void
    {
        $this->subject->setWert2('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('wert2'));
    }

    /**
     * @test
     */
    public function getWert3ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getWert3()
        );
    }

    /**
     * @test
     */
    public function setWert3ForStringSetsWert3(): void
    {
        $this->subject->setWert3('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('wert3'));
    }

    /**
     * @test
     */
    public function getWert4ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getWert4()
        );
    }

    /**
     * @test
     */
    public function setWert4ForStringSetsWert4(): void
    {
        $this->subject->setWert4('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('wert4'));
    }

    /**
     * @test
     */
    public function getKundeNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getKundeName()
        );
    }

    /**
     * @test
     */
    public function setKundeNameForStringSetsKundeName(): void
    {
        $this->subject->setKundeName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('kundeName'));
    }

    /**
     * @test
     */
    public function getAuftragTitelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAuftragTitel()
        );
    }

    /**
     * @test
     */
    public function setAuftragTitelForStringSetsAuftragTitel(): void
    {
        $this->subject->setAuftragTitel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('auftragTitel'));
    }
}
