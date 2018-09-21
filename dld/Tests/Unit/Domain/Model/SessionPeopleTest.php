<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class SessionPeopleTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\SessionPeople
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\SessionPeople();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getIsSpeakerReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getIsSpeaker()
        );

    }

    /**
     * @test
     */
    public function setIsSpeakerForBoolSetsIsSpeaker()
    {
        $this->subject->setIsSpeaker(true);

        self::assertAttributeEquals(
            true,
            'isSpeaker',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getIsModeratorReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getIsModerator()
        );

    }

    /**
     * @test
     */
    public function setIsModeratorForBoolSetsIsModerator()
    {
        $this->subject->setIsModerator(true);

        self::assertAttributeEquals(
            true,
            'isModerator',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getSortOrderReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setSortOrderForIntSetsSortOrder()
    {
    }

    /**
     * @test
     */
    public function getSessionIdReturnsInitialValueForSession()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSessionId()
        );

    }

    /**
     * @test
     */
    public function setSessionIdForObjectStorageContainingSessionSetsSessionId()
    {
        $sessionId = new \DLD\Dld\Domain\Model\Session();
        $objectStorageHoldingExactlyOneSessionId = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSessionId->attach($sessionId);
        $this->subject->setSessionId($objectStorageHoldingExactlyOneSessionId);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneSessionId,
            'sessionId',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addSessionIdToObjectStorageHoldingSessionId()
    {
        $sessionId = new \DLD\Dld\Domain\Model\Session();
        $sessionIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sessionIdObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($sessionId));
        $this->inject($this->subject, 'sessionId', $sessionIdObjectStorageMock);

        $this->subject->addSessionId($sessionId);
    }

    /**
     * @test
     */
    public function removeSessionIdFromObjectStorageHoldingSessionId()
    {
        $sessionId = new \DLD\Dld\Domain\Model\Session();
        $sessionIdObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sessionIdObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($sessionId));
        $this->inject($this->subject, 'sessionId', $sessionIdObjectStorageMock);

        $this->subject->removeSessionId($sessionId);

    }

    /**
     * @test
     */
    public function getPeopleIdReturnsInitialValueForPeople()
    {
        self::assertEquals(
            null,
            $this->subject->getPeopleId()
        );

    }

    /**
     * @test
     */
    public function setPeopleIdForPeopleSetsPeopleId()
    {
        $peopleIdFixture = new \DLD\Dld\Domain\Model\People();
        $this->subject->setPeopleId($peopleIdFixture);

        self::assertAttributeEquals(
            $peopleIdFixture,
            'peopleId',
            $this->subject
        );

    }
}
