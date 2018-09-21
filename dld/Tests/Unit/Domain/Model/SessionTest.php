<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class SessionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\Session
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\Session();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );

    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getStartReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setStartForIntSetsStart()
    {
    }

    /**
     * @test
     */
    public function getEndReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setEndForIntSetsEnd()
    {
    }

    /**
     * @test
     */
    public function getIsVisibleReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getIsVisible()
        );

    }

    /**
     * @test
     */
    public function setIsVisibleForBoolSetsIsVisible()
    {
        $this->subject->setIsVisible(true);

        self::assertAttributeEquals(
            true,
            'isVisible',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getEventIdReturnsInitialValueForEvent()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getEventId()
        );

    }

    /**
     * @test
     */
    public function setEventIdForObjectStorageContainingEventSetsEventId()
    {
        $eventId = new \DLD\Dld\Domain\Model\Event();
        $objectStorageHoldingExactlyOneEventId = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneEventId->attach($eventId);
        $this->subject->setEventId($objectStorageHoldingExactlyOneEventId);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneEventId,
            'eventId',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addEventIdToObjectStorageHoldingEventId()
    {
        $eventId = new \DLD\Dld\Domain\Model\Event();
        $eventIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventIdObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($eventId));
        $this->inject($this->subject, 'eventId', $eventIdObjectStorageMock);

        $this->subject->addEventId($eventId);
    }

    /**
     * @test
     */
    public function removeEventIdFromObjectStorageHoldingEventId()
    {
        $eventId = new \DLD\Dld\Domain\Model\Event();
        $eventIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventIdObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($eventId));
        $this->inject($this->subject, 'eventId', $eventIdObjectStorageMock);

        $this->subject->removeEventId($eventId);

    }

    /**
     * @test
     */
    public function getVenueIdReturnsInitialValueForVenue()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getVenueId()
        );

    }

    /**
     * @test
     */
    public function setVenueIdForObjectStorageContainingVenueSetsVenueId()
    {
        $venueId = new \DLD\Dld\Domain\Model\Venue();
        $objectStorageHoldingExactlyOneVenueId = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneVenueId->attach($venueId);
        $this->subject->setVenueId($objectStorageHoldingExactlyOneVenueId);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneVenueId,
            'venueId',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addVenueIdToObjectStorageHoldingVenueId()
    {
        $venueId = new \DLD\Dld\Domain\Model\Venue();
        $venueIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $venueIdObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($venueId));
        $this->inject($this->subject, 'venueId', $venueIdObjectStorageMock);

        $this->subject->addVenueId($venueId);
    }

    /**
     * @test
     */
    public function removeVenueIdFromObjectStorageHoldingVenueId()
    {
        $venueId = new \DLD\Dld\Domain\Model\Venue();
        $venueIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $venueIdObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($venueId));
        $this->inject($this->subject, 'venueId', $venueIdObjectStorageMock);

        $this->subject->removeVenueId($venueId);

    }
}
