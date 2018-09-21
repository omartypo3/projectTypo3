<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class EventPartnerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\EventPartner
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\EventPartner();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getPartnerStatusReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setPartnerStatusForIntSetsPartnerStatus()
    {
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
    public function getEventIdReturnsInitialValueForEvent()
    {
        self::assertEquals(
            null,
            $this->subject->getEventId()
        );

    }

    /**
     * @test
     */
    public function setEventIdForEventSetsEventId()
    {
        $eventIdFixture = new \DLD\Dld\Domain\Model\Event();
        $this->subject->setEventId($eventIdFixture);

        self::assertAttributeEquals(
            $eventIdFixture,
            'eventId',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPartnerIdReturnsInitialValueForPartner()
    {
        self::assertEquals(
            null,
            $this->subject->getPartnerId()
        );

    }

    /**
     * @test
     */
    public function setPartnerIdForPartnerSetsPartnerId()
    {
        $partnerIdFixture = new \DLD\Dld\Domain\Model\Partner();
        $this->subject->setPartnerId($partnerIdFixture);

        self::assertAttributeEquals(
            $partnerIdFixture,
            'partnerId',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getSessionIdReturnsInitialValueForSession()
    {
        self::assertEquals(
            null,
            $this->subject->getSessionId()
        );

    }

    /**
     * @test
     */
    public function setSessionIdForSessionSetsSessionId()
    {
        $sessionIdFixture = new \DLD\Dld\Domain\Model\Session();
        $this->subject->setSessionId($sessionIdFixture);

        self::assertAttributeEquals(
            $sessionIdFixture,
            'sessionId',
            $this->subject
        );

    }
}
