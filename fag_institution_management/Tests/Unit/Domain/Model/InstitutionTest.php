<?php
namespace FRONTAL\FagInstitutionManagement\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Roland Kneubühler <rk@frontal.ch>
 */
class InstitutionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Institution
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \FRONTAL\FagInstitutionManagement\Domain\Model\Institution();
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
    public function getLogoReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getLogo()
        );
    }

    /**
     * @test
     */
    public function setLogoForFileReferenceSetsLogo()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setLogo($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'logo',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFunctionsReturnsInitialValueFor()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getFunctions()
        );
    }

    /**
     * @test
     */
    public function setFunctionsForObjectStorageContainingSetsFunctions()
    {
        $function = new ();
        $objectStorageHoldingExactlyOneFunctions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFunctions->attach($function);
        $this->subject->setFunctions($objectStorageHoldingExactlyOneFunctions);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneFunctions,
            'functions',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addFunctionToObjectStorageHoldingFunctions()
    {
        $function = new ();
        $functionsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $functionsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($function));
        $this->inject($this->subject, 'functions', $functionsObjectStorageMock);

        $this->subject->addFunction($function);
    }

    /**
     * @test
     */
    public function removeFunctionFromObjectStorageHoldingFunctions()
    {
        $function = new ();
        $functionsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $functionsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($function));
        $this->inject($this->subject, 'functions', $functionsObjectStorageMock);

        $this->subject->removeFunction($function);
    }

    /**
     * @test
     */
    public function getEventsReturnsInitialValueForEvent()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getEvents()
        );
    }

    /**
     * @test
     */
    public function setEventsForObjectStorageContainingEventSetsEvents()
    {
        $event = new \FRONTAL\FagInstitutionManagement\Domain\Model\Event();
        $objectStorageHoldingExactlyOneEvents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneEvents->attach($event);
        $this->subject->setEvents($objectStorageHoldingExactlyOneEvents);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneEvents,
            'events',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addEventToObjectStorageHoldingEvents()
    {
        $event = new \FRONTAL\FagInstitutionManagement\Domain\Model\Event();
        $eventsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($event));
        $this->inject($this->subject, 'events', $eventsObjectStorageMock);

        $this->subject->addEvent($event);
    }

    /**
     * @test
     */
    public function removeEventFromObjectStorageHoldingEvents()
    {
        $event = new \FRONTAL\FagInstitutionManagement\Domain\Model\Event();
        $eventsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($event));
        $this->inject($this->subject, 'events', $eventsObjectStorageMock);

        $this->subject->removeEvent($event);
    }
}
