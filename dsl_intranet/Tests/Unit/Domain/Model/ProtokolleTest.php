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
class ProtokolleTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Protokolle|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Protokolle::class,
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
    public function getAktionReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getAktion()
        );
    }

    /**
     * @test
     */
    public function setAktionForIntSetsAktion(): void
    {
        $this->subject->setAktion(12);

        self::assertEquals(12, $this->subject->_get('aktion'));
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
    public function getKundeninfoTimeReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getKundeninfoTime()
        );
    }

    /**
     * @test
     */
    public function setKundeninfoTimeForDateTimeSetsKundeninfoTime(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setKundeninfoTime($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('kundeninfoTime'));
    }

    /**
     * @test
     */
    public function getKundeninfoMailReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getKundeninfoMail()
        );
    }

    /**
     * @test
     */
    public function setKundeninfoMailForStringSetsKundeninfoMail(): void
    {
        $this->subject->setKundeninfoMail('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('kundeninfoMail'));
    }

    /**
     * @test
     */
    public function getNotizSystemReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getNotizSystem()
        );
    }

    /**
     * @test
     */
    public function setNotizSystemForStringSetsNotizSystem(): void
    {
        $this->subject->setNotizSystem('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('notizSystem'));
    }

    /**
     * @test
     */
    public function getZeitpunktReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getZeitpunkt()
        );
    }

    /**
     * @test
     */
    public function setZeitpunktForDateTimeSetsZeitpunkt(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setZeitpunkt($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('zeitpunkt'));
    }

    /**
     * @test
     */
    public function getKundeninfoSichtbarkeitReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getKundeninfoSichtbarkeit()
        );
    }

    /**
     * @test
     */
    public function setKundeninfoSichtbarkeitForIntSetsKundeninfoSichtbarkeit(): void
    {
        $this->subject->setKundeninfoSichtbarkeit(12);

        self::assertEquals(12, $this->subject->_get('kundeninfoSichtbarkeit'));
    }

    /**
     * @test
     */
    public function getAuftragStatusAltReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getAuftragStatusAlt()
        );
    }

    /**
     * @test
     */
    public function setAuftragStatusAltForIntSetsAuftragStatusAlt(): void
    {
        $this->subject->setAuftragStatusAlt(12);

        self::assertEquals(12, $this->subject->_get('auftragStatusAlt'));
    }

    /**
     * @test
     */
    public function getAuftragStatusNeuReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getAuftragStatusNeu()
        );
    }

    /**
     * @test
     */
    public function setAuftragStatusNeuForIntSetsAuftragStatusNeu(): void
    {
        $this->subject->setAuftragStatusNeu(12);

        self::assertEquals(12, $this->subject->_get('auftragStatusNeu'));
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

    /**
     * @test
     */
    public function getDateiReturnsInitialValueForDateien(): void
    {
        self::assertEquals(
            null,
            $this->subject->getDatei()
        );
    }

    /**
     * @test
     */
    public function setDateiForDateienSetsDatei(): void
    {
        $dateiFixture = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $this->subject->setDatei($dateiFixture);

        self::assertEquals($dateiFixture, $this->subject->_get('datei'));
    }

    /**
     * @test
     */
    public function getPendingReturnsInitialValueForProtokollePending(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getPending()
        );
    }

    /**
     * @test
     */
    public function setPendingForObjectStorageContainingProtokollePendingSetsPending(): void
    {
        $pending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $objectStorageHoldingExactlyOnePending = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOnePending->attach($pending);
        $this->subject->setPending($objectStorageHoldingExactlyOnePending);

        self::assertEquals($objectStorageHoldingExactlyOnePending, $this->subject->_get('pending'));
    }

    /**
     * @test
     */
    public function addPendingToObjectStorageHoldingPending(): void
    {
        $pending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $pendingObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $pendingObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($pending));
        $this->subject->_set('pending', $pendingObjectStorageMock);

        $this->subject->addPending($pending);
    }

    /**
     * @test
     */
    public function removePendingFromObjectStorageHoldingPending(): void
    {
        $pending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $pendingObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $pendingObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($pending));
        $this->subject->_set('pending', $pendingObjectStorageMock);

        $this->subject->removePending($pending);
    }

    /**
     * @test
     */
    public function getAgenturvertragReturnsInitialValueForAgenturvertraege(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAgenturvertrag()
        );
    }

    /**
     * @test
     */
    public function setAgenturvertragForAgenturvertraegeSetsAgenturvertrag(): void
    {
        $agenturvertragFixture = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();
        $this->subject->setAgenturvertrag($agenturvertragFixture);

        self::assertEquals($agenturvertragFixture, $this->subject->_get('agenturvertrag'));
    }
}
