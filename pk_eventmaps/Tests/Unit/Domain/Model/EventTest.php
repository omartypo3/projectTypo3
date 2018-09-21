<?php
namespace EventMaps\PkEventmaps\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Patrick Kudla 
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \EventMaps\PkEventmaps\Domain\Model\Event
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \EventMaps\PkEventmaps\Domain\Model\Event();
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
    public function getAktionszeitReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAktionszeit()
        );

    }

    /**
     * @test
     */
    public function setAktionszeitForStringSetsAktionszeit()
    {
        $this->subject->setAktionszeit('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'aktionszeit',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getLocationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLocation()
        );

    }

    /**
     * @test
     */
    public function setLocationForStringSetsLocation()
    {
        $this->subject->setLocation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'location',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getStreetReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStreet()
        );

    }

    /**
     * @test
     */
    public function setStreetForStringSetsStreet()
    {
        $this->subject->setStreet('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'street',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getStreetnumberReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStreetnumber()
        );

    }

    /**
     * @test
     */
    public function setStreetnumberForStringSetsStreetnumber()
    {
        $this->subject->setStreetnumber('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'streetnumber',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getZipReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZip()
        );

    }

    /**
     * @test
     */
    public function setZipForStringSetsZip()
    {
        $this->subject->setZip('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zip',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getCityReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCity()
        );

    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->subject->setCity('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'city',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getModeratorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getModerator()
        );

    }

    /**
     * @test
     */
    public function setModeratorForStringSetsModerator()
    {
        $this->subject->setModerator('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'moderator',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getInformationsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getInformations()
        );

    }

    /**
     * @test
     */
    public function setInformationsForStringSetsInformations()
    {
        $this->subject->setInformations('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'informations',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getFonReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFon()
        );

    }

    /**
     * @test
     */
    public function setFonForStringSetsFon()
    {
        $this->subject->setFon('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'fon',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getFaxReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFax()
        );

    }

    /**
     * @test
     */
    public function setFaxForStringSetsFax()
    {
        $this->subject->setFax('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'fax',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getMailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMail()
        );

    }

    /**
     * @test
     */
    public function setMailForStringSetsMail()
    {
        $this->subject->setMail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'mail',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getLonReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLon()
        );

    }

    /**
     * @test
     */
    public function setLonForStringSetsLon()
    {
        $this->subject->setLon('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lon',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getLatReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLat()
        );

    }

    /**
     * @test
     */
    public function setLatForStringSetsLat()
    {
        $this->subject->setLat('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lat',
            $this->subject
        );

    }
}
