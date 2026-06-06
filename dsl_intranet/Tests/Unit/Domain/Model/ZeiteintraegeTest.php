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
class ZeiteintraegeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\Zeiteintraege|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\Zeiteintraege::class,
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
    public function getKontingentReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getKontingent()
        );
    }

    /**
     * @test
     */
    public function setKontingentForIntSetsKontingent(): void
    {
        $this->subject->setKontingent(12);

        self::assertEquals(12, $this->subject->_get('kontingent'));
    }

    /**
     * @test
     */
    public function getZeitnahmeReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getZeitnahme()
        );
    }

    /**
     * @test
     */
    public function setZeitnahmeForIntSetsZeitnahme(): void
    {
        $this->subject->setZeitnahme(12);

        self::assertEquals(12, $this->subject->_get('zeitnahme'));
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
    public function getZeitnahmeAutoStoppedReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getZeitnahmeAutoStopped());
    }

    /**
     * @test
     */
    public function setZeitnahmeAutoStoppedForBoolSetsZeitnahmeAutoStopped(): void
    {
        $this->subject->setZeitnahmeAutoStopped(true);

        self::assertEquals(true, $this->subject->_get('zeitnahmeAutoStopped'));
    }

    /**
     * @test
     */
    public function getPhaseReturnsInitialValueForPhasen(): void
    {
        self::assertEquals(
            null,
            $this->subject->getPhase()
        );
    }

    /**
     * @test
     */
    public function setPhaseForPhasenSetsPhase(): void
    {
        $phaseFixture = new \DslFactory\DslIntranet\Domain\Model\Phasen();
        $this->subject->setPhase($phaseFixture);

        self::assertEquals($phaseFixture, $this->subject->_get('phase'));
    }

    /**
     * @test
     */
    public function getTrackerReturnsInitialValueForTrackerSegmente(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getTracker()
        );
    }

    /**
     * @test
     */
    public function setTrackerForObjectStorageContainingTrackerSegmenteSetsTracker(): void
    {
        $tracker = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();
        $objectStorageHoldingExactlyOneTracker = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneTracker->attach($tracker);
        $this->subject->setTracker($objectStorageHoldingExactlyOneTracker);

        self::assertEquals($objectStorageHoldingExactlyOneTracker, $this->subject->_get('tracker'));
    }

    /**
     * @test
     */
    public function addTrackerToObjectStorageHoldingTracker(): void
    {
        $tracker = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();
        $trackerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $trackerObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($tracker));
        $this->subject->_set('tracker', $trackerObjectStorageMock);

        $this->subject->addTracker($tracker);
    }

    /**
     * @test
     */
    public function removeTrackerFromObjectStorageHoldingTracker(): void
    {
        $tracker = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();
        $trackerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $trackerObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($tracker));
        $this->subject->_set('tracker', $trackerObjectStorageMock);

        $this->subject->removeTracker($tracker);
    }

    /**
     * @test
     */
    public function getSegmenteReturnsInitialValueForZeiteintraegeSegmente(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSegmente()
        );
    }

    /**
     * @test
     */
    public function setSegmenteForObjectStorageContainingZeiteintraegeSegmenteSetsSegmente(): void
    {
        $segmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();
        $objectStorageHoldingExactlyOneSegmente = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSegmente->attach($segmente);
        $this->subject->setSegmente($objectStorageHoldingExactlyOneSegmente);

        self::assertEquals($objectStorageHoldingExactlyOneSegmente, $this->subject->_get('segmente'));
    }

    /**
     * @test
     */
    public function addSegmenteToObjectStorageHoldingSegmente(): void
    {
        $segmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();
        $segmenteObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $segmenteObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($segmente));
        $this->subject->_set('segmente', $segmenteObjectStorageMock);

        $this->subject->addSegmente($segmente);
    }

    /**
     * @test
     */
    public function removeSegmenteFromObjectStorageHoldingSegmente(): void
    {
        $segmente = new \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente();
        $segmenteObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $segmenteObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($segmente));
        $this->subject->_set('segmente', $segmenteObjectStorageMock);

        $this->subject->removeSegmente($segmente);
    }
}
