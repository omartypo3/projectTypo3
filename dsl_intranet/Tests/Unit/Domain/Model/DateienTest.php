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
class DateienTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Dateien|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Dateien::class,
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
    public function getDateiReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getDatei()
        );
    }

    /**
     * @test
     */
    public function setDateiForFileReferenceSetsDatei(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setDatei($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('datei'));
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
    public function getSichtbarkeitReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getSichtbarkeit());
    }

    /**
     * @test
     */
    public function setSichtbarkeitForBoolSetsSichtbarkeit(): void
    {
        $this->subject->setSichtbarkeit(true);

        self::assertEquals(true, $this->subject->_get('sichtbarkeit'));
    }

    /**
     * @test
     */
    public function getTempDateiNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempDateiName()
        );
    }

    /**
     * @test
     */
    public function setTempDateiNameForStringSetsTempDateiName(): void
    {
        $this->subject->setTempDateiName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempDateiName'));
    }

    /**
     * @test
     */
    public function getTempDateiGroesseReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getTempDateiGroesse()
        );
    }

    /**
     * @test
     */
    public function setTempDateiGroesseForIntSetsTempDateiGroesse(): void
    {
        $this->subject->setTempDateiGroesse(12);

        self::assertEquals(12, $this->subject->_get('tempDateiGroesse'));
    }

    /**
     * @test
     */
    public function getTempKundenNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempKundenName()
        );
    }

    /**
     * @test
     */
    public function setTempKundenNameForStringSetsTempKundenName(): void
    {
        $this->subject->setTempKundenName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempKundenName'));
    }

    /**
     * @test
     */
    public function getTempTypeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempType()
        );
    }

    /**
     * @test
     */
    public function setTempTypeForStringSetsTempType(): void
    {
        $this->subject->setTempType('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempType'));
    }

    /**
     * @test
     */
    public function getTempKundenNummerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempKundenNummer()
        );
    }

    /**
     * @test
     */
    public function setTempKundenNummerForStringSetsTempKundenNummer(): void
    {
        $this->subject->setTempKundenNummer('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempKundenNummer'));
    }

    /**
     * @test
     */
    public function getTempTimestampReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempTimestamp()
        );
    }

    /**
     * @test
     */
    public function setTempTimestampForStringSetsTempTimestamp(): void
    {
        $this->subject->setTempTimestamp('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempTimestamp'));
    }

    /**
     * @test
     */
    public function getTempRechnungsnummerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTempRechnungsnummer()
        );
    }

    /**
     * @test
     */
    public function setTempRechnungsnummerForStringSetsTempRechnungsnummer(): void
    {
        $this->subject->setTempRechnungsnummer('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('tempRechnungsnummer'));
    }
}
