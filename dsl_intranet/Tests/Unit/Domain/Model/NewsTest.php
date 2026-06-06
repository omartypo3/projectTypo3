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
class NewsTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\News|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\News::class,
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
    public function getUntertitelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getUntertitel()
        );
    }

    /**
     * @test
     */
    public function setUntertitelForStringSetsUntertitel(): void
    {
        $this->subject->setUntertitel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('untertitel'));
    }

    /**
     * @test
     */
    public function getTextReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getText()
        );
    }

    /**
     * @test
     */
    public function setTextForStringSetsText(): void
    {
        $this->subject->setText('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('text'));
    }

    /**
     * @test
     */
    public function getAngebot1ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAngebot1()
        );
    }

    /**
     * @test
     */
    public function setAngebot1ForStringSetsAngebot1(): void
    {
        $this->subject->setAngebot1('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('angebot1'));
    }

    /**
     * @test
     */
    public function getAngebot2ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAngebot2()
        );
    }

    /**
     * @test
     */
    public function setAngebot2ForStringSetsAngebot2(): void
    {
        $this->subject->setAngebot2('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('angebot2'));
    }

    /**
     * @test
     */
    public function getAngebot3ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAngebot3()
        );
    }

    /**
     * @test
     */
    public function setAngebot3ForStringSetsAngebot3(): void
    {
        $this->subject->setAngebot3('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('angebot3'));
    }

    /**
     * @test
     */
    public function getLinkExternReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLinkExtern()
        );
    }

    /**
     * @test
     */
    public function setLinkExternForStringSetsLinkExtern(): void
    {
        $this->subject->setLinkExtern('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('linkExtern'));
    }

    /**
     * @test
     */
    public function getLinkExternNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLinkExternName()
        );
    }

    /**
     * @test
     */
    public function setLinkExternNameForStringSetsLinkExternName(): void
    {
        $this->subject->setLinkExternName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('linkExternName'));
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
    public function getGueltigAbReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getGueltigAb()
        );
    }

    /**
     * @test
     */
    public function setGueltigAbForDateTimeSetsGueltigAb(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setGueltigAb($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('gueltigAb'));
    }

    /**
     * @test
     */
    public function getGueltigBisReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getGueltigBis()
        );
    }

    /**
     * @test
     */
    public function setGueltigBisForDateTimeSetsGueltigBis(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setGueltigBis($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('gueltigBis'));
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
    public function getCountdownReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getCountdown());
    }

    /**
     * @test
     */
    public function setCountdownForBoolSetsCountdown(): void
    {
        $this->subject->setCountdown(true);

        self::assertEquals(true, $this->subject->_get('countdown'));
    }
}
