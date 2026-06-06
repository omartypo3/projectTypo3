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
class WartungsvertraegeZeitraeumeTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume::class,
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
    public function getZeitenReturnsInitialValueForZeiteintraege(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getZeiten()
        );
    }

    /**
     * @test
     */
    public function setZeitenForObjectStorageContainingZeiteintraegeSetsZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $objectStorageHoldingExactlyOneZeiten = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneZeiten->attach($zeiten);
        $this->subject->setZeiten($objectStorageHoldingExactlyOneZeiten);

        self::assertEquals($objectStorageHoldingExactlyOneZeiten, $this->subject->_get('zeiten'));
    }

    /**
     * @test
     */
    public function addZeitenToObjectStorageHoldingZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $zeitenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($zeiten));
        $this->subject->_set('zeiten', $zeitenObjectStorageMock);

        $this->subject->addZeiten($zeiten);
    }

    /**
     * @test
     */
    public function removeZeitenFromObjectStorageHoldingZeiten(): void
    {
        $zeiten = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $zeitenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $zeitenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($zeiten));
        $this->subject->_set('zeiten', $zeitenObjectStorageMock);

        $this->subject->removeZeiten($zeiten);
    }

    /**
     * @test
     */
    public function getRechnungenReturnsInitialValueForWartungsvertraegeRechnungen(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getRechnungen()
        );
    }

    /**
     * @test
     */
    public function setRechnungenForObjectStorageContainingWartungsvertraegeRechnungenSetsRechnungen(): void
    {
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();
        $objectStorageHoldingExactlyOneRechnungen = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneRechnungen->attach($rechnungen);
        $this->subject->setRechnungen($objectStorageHoldingExactlyOneRechnungen);

        self::assertEquals($objectStorageHoldingExactlyOneRechnungen, $this->subject->_get('rechnungen'));
    }

    /**
     * @test
     */
    public function addRechnungenToObjectStorageHoldingRechnungen(): void
    {
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();
        $rechnungenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $rechnungenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($rechnungen));
        $this->subject->_set('rechnungen', $rechnungenObjectStorageMock);

        $this->subject->addRechnungen($rechnungen);
    }

    /**
     * @test
     */
    public function removeRechnungenFromObjectStorageHoldingRechnungen(): void
    {
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeRechnungen();
        $rechnungenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $rechnungenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($rechnungen));
        $this->subject->_set('rechnungen', $rechnungenObjectStorageMock);

        $this->subject->removeRechnungen($rechnungen);
    }
}
