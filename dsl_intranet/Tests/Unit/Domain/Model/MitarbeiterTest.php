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
class MitarbeiterTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Mitarbeiter|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Mitarbeiter::class,
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
    public function getMobilephoneReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getMobilephone()
        );
    }

    /**
     * @test
     */
    public function setMobilephoneForStringSetsMobilephone(): void
    {
        $this->subject->setMobilephone('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('mobilephone'));
    }

    /**
     * @test
     */
    public function getSpitznameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSpitzname()
        );
    }

    /**
     * @test
     */
    public function setSpitznameForStringSetsSpitzname(): void
    {
        $this->subject->setSpitzname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('spitzname'));
    }

    /**
     * @test
     */
    public function getInitialienReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getInitialien()
        );
    }

    /**
     * @test
     */
    public function setInitialienForStringSetsInitialien(): void
    {
        $this->subject->setInitialien('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('initialien'));
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
    public function getArbeitsbeginReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getArbeitsbegin()
        );
    }

    /**
     * @test
     */
    public function setArbeitsbeginForIntSetsArbeitsbegin(): void
    {
        $this->subject->setArbeitsbegin(12);

        self::assertEquals(12, $this->subject->_get('arbeitsbegin'));
    }

    /**
     * @test
     */
    public function getArbeitsendeReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getArbeitsende()
        );
    }

    /**
     * @test
     */
    public function setArbeitsendeForIntSetsArbeitsende(): void
    {
        $this->subject->setArbeitsende(12);

        self::assertEquals(12, $this->subject->_get('arbeitsende'));
    }

    /**
     * @test
     */
    public function getAutostopReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getAutostop()
        );
    }

    /**
     * @test
     */
    public function setAutostopForIntSetsAutostop(): void
    {
        $this->subject->setAutostop(12);

        self::assertEquals(12, $this->subject->_get('autostop'));
    }

    /**
     * @test
     */
    public function getFarbeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFarbe()
        );
    }

    /**
     * @test
     */
    public function setFarbeForStringSetsFarbe(): void
    {
        $this->subject->setFarbe('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('farbe'));
    }

    /**
     * @test
     */
    public function getRechteReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getRechte()
        );
    }

    /**
     * @test
     */
    public function setRechteForStringSetsRechte(): void
    {
        $this->subject->setRechte('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('rechte'));
    }

    /**
     * @test
     */
    public function getUrlaubstageProJahrReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getUrlaubstageProJahr()
        );
    }

    /**
     * @test
     */
    public function setUrlaubstageProJahrForIntSetsUrlaubstageProJahr(): void
    {
        $this->subject->setUrlaubstageProJahr(12);

        self::assertEquals(12, $this->subject->_get('urlaubstageProJahr'));
    }

    /**
     * @test
     */
    public function getUrlaubstageVerbrauchtReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getUrlaubstageVerbraucht()
        );
    }

    /**
     * @test
     */
    public function setUrlaubstageVerbrauchtForIntSetsUrlaubstageVerbraucht(): void
    {
        $this->subject->setUrlaubstageVerbraucht(12);

        self::assertEquals(12, $this->subject->_get('urlaubstageVerbraucht'));
    }
}
