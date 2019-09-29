<?php
namespace FRONTAL\FagBesichtigung\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class DatumTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagBesichtigung\Domain\Model\Datum
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagBesichtigung\Domain\Model\Datum();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDate()
        );
    }

    /**
     * @test
     */
    public function setDateForDateTimeSetsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'date',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStartTimeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getStartTime()
        );
    }

    /**
     * @test
     */
    public function setStartTimeForIntSetsStartTime()
    {
        $this->subject->setStartTime(12);

        self::assertAttributeEquals(
            12,
            'startTime',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEndTimeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getEndTime()
        );
    }

    /**
     * @test
     */
    public function setEndTimeForIntSetsEndTime()
    {
        $this->subject->setEndTime(12);

        self::assertAttributeEquals(
            12,
            'endTime',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStatusReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStatus()
        );
    }

    /**
     * @test
     */
    public function setStatusForStringSetsStatus()
    {
        $this->subject->setStatus('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'status',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTeilnehmerMaxReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getTeilnehmerMax()
        );
    }

    /**
     * @test
     */
    public function setTeilnehmerMaxForIntSetsTeilnehmerMax()
    {
        $this->subject->setTeilnehmerMax(12);

        self::assertAttributeEquals(
            12,
            'teilnehmerMax',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnfrageReturnsInitialValueForAnfrage()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAnfrage()
        );
    }

    /**
     * @test
     */
    public function setAnfrageForObjectStorageContainingAnfrageSetsAnfrage()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();
        $objectStorageHoldingExactlyOneAnfrage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAnfrage->attach($anfrage);
        $this->subject->setAnfrage($objectStorageHoldingExactlyOneAnfrage);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAnfrage,
            'anfrage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAnfrageToObjectStorageHoldingAnfrage()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();
        $anfrageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($anfrage));
        $this->inject($this->subject, 'anfrage', $anfrageObjectStorageMock);

        $this->subject->addAnfrage($anfrage);
    }

    /**
     * @test
     */
    public function removeAnfrageFromObjectStorageHoldingAnfrage()
    {
        $anfrage = new \FRONTAL\FagBesichtigung\Domain\Model\Anfrage();
        $anfrageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $anfrageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($anfrage));
        $this->inject($this->subject, 'anfrage', $anfrageObjectStorageMock);

        $this->subject->removeAnfrage($anfrage);
    }

    /**
     * @test
     */
    public function getGruppenFuhrerReturnsInitialValueForGruppenFuhrer()
    {
        self::assertEquals(
            null,
            $this->subject->getGruppenFuhrer()
        );
    }

    /**
     * @test
     */
    public function setGruppenFuhrerForGruppenFuhrerSetsGruppenFuhrer()
    {
        $gruppenFuhrerFixture = new \FRONTAL\FagBesichtigung\Domain\Model\GruppenFuhrer();
        $this->subject->setGruppenFuhrer($gruppenFuhrerFixture);

        self::assertAttributeEquals(
            $gruppenFuhrerFixture,
            'gruppenFuhrer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGruppentypReturnsInitialValueForGruppentyp()
    {
        self::assertEquals(
            null,
            $this->subject->getGruppentyp()
        );
    }

    /**
     * @test
     */
    public function setGruppentypForGruppentypSetsGruppentyp()
    {
        $gruppentypFixture = new \FRONTAL\FagBesichtigung\Domain\Model\Gruppentyp();
        $this->subject->setGruppentyp($gruppentypFixture);

        self::assertAttributeEquals(
            $gruppentypFixture,
            'gruppentyp',
            $this->subject
        );
    }
}
