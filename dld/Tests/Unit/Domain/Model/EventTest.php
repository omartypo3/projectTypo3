<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\Event
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\Event();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );

    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getHeaderImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getHeaderImage()
        );

    }

    /**
     * @test
     */
    public function setHeaderImageForFileReferenceSetsHeaderImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setHeaderImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'headerImage',
            $this->subject
        );

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
    public function getSlideImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getSlideImage()
        );

    }

    /**
     * @test
     */
    public function setSlideImageForFileReferenceSetsSlideImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setSlideImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'slideImage',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getConferenceImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getConferenceImage()
        );

    }

    /**
     * @test
     */
    public function setConferenceImageForFileReferenceSetsConferenceImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setConferenceImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'conferenceImage',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getProgramPdfReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getProgramPdf()
        );

    }

    /**
     * @test
     */
    public function setProgramPdfForStringSetsProgramPdf()
    {
        $this->subject->setProgramPdf('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'programPdf',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getMaxInviteeReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setMaxInviteeForIntSetsMaxInvitee()
    {
    }

    /**
     * @test
     */
    public function getTwitterHashtagReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTwitterHashtag()
        );

    }

    /**
     * @test
     */
    public function setTwitterHashtagForStringSetsTwitterHashtag()
    {
        $this->subject->setTwitterHashtag('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'twitterHashtag',
            $this->subject
        );

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
