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
class HostingZusatzleistungenTest extends UnitTestCase
{
    /**
     * @var \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \DslFactory\DslIntranet\Domain\Model\HostingZusatzleistungen::class,
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
    public function getAnzahlReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getAnzahl()
        );
    }

    /**
     * @test
     */
    public function setAnzahlForIntSetsAnzahl(): void
    {
        $this->subject->setAnzahl(12);

        self::assertEquals(12, $this->subject->_get('anzahl'));
    }

    /**
     * @test
     */
    public function getSonderpreisMonatlichReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getSonderpreisMonatlich()
        );
    }

    /**
     * @test
     */
    public function setSonderpreisMonatlichForFloatSetsSonderpreisMonatlich(): void
    {
        $this->subject->setSonderpreisMonatlich(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('sonderpreisMonatlich'));
    }

    /**
     * @test
     */
    public function getGekuendigtReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getGekuendigt());
    }

    /**
     * @test
     */
    public function setGekuendigtForBoolSetsGekuendigt(): void
    {
        $this->subject->setGekuendigt(true);

        self::assertEquals(true, $this->subject->_get('gekuendigt'));
    }

    /**
     * @test
     */
    public function getVertragsbeginReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getVertragsbegin()
        );
    }

    /**
     * @test
     */
    public function setVertragsbeginForDateTimeSetsVertragsbegin(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setVertragsbegin($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('vertragsbegin'));
    }

    /**
     * @test
     */
    public function getBezahltbisReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getBezahltbis()
        );
    }

    /**
     * @test
     */
    public function setBezahltbisForDateTimeSetsBezahltbis(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setBezahltbis($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('bezahltbis'));
    }

    /**
     * @test
     */
    public function getSonderlaufzeitReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getSonderlaufzeit()
        );
    }

    /**
     * @test
     */
    public function setSonderlaufzeitForIntSetsSonderlaufzeit(): void
    {
        $this->subject->setSonderlaufzeit(12);

        self::assertEquals(12, $this->subject->_get('sonderlaufzeit'));
    }

    /**
     * @test
     */
    public function getZusatzleistungReturnsInitialValueForZusatzleistungen(): void
    {
        self::assertEquals(
            null,
            $this->subject->getZusatzleistung()
        );
    }

    /**
     * @test
     */
    public function setZusatzleistungForZusatzleistungenSetsZusatzleistung(): void
    {
        $zusatzleistungFixture = new \DslFactory\DslIntranet\Domain\Model\Zusatzleistungen();
        $this->subject->setZusatzleistung($zusatzleistungFixture);

        self::assertEquals($zusatzleistungFixture, $this->subject->_get('zusatzleistung'));
    }

    /**
     * @test
     */
    public function getRechnungenReturnsInitialValueForHostingTarifRechnungen(): void
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
    public function setRechnungenForObjectStorageContainingHostingTarifRechnungenSetsRechnungen(): void
    {
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();
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
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();
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
        $rechnungen = new \DslFactory\DslIntranet\Domain\Model\HostingTarifRechnungen();
        $rechnungenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $rechnungenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($rechnungen));
        $this->subject->_set('rechnungen', $rechnungenObjectStorageMock);

        $this->subject->removeRechnungen($rechnungen);
    }
}
