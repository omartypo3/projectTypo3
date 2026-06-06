<?php
namespace DslFactory\DslJobs\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class JobSiteTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslJobs\Domain\Model\JobSite
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslJobs\Domain\Model\JobSite();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getJobsiteUidReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setJobsiteUidForIntSetsJobsiteUid()
    {
    }

    /**
     * @test
     */
    public function getCompanyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCompany()
        );

    }

    /**
     * @test
     */
    public function setCompanyForStringSetsCompany()
    {
        $this->subject->setCompany('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'company',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getShortnameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getShortname()
        );

    }

    /**
     * @test
     */
    public function setShortnameForStringSetsShortname()
    {
        $this->subject->setShortname('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'shortname',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getCountryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCountry()
        );

    }

    /**
     * @test
     */
    public function setCountryForStringSetsCountry()
    {
        $this->subject->setCountry('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'country',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getStateReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getState()
        );

    }

    /**
     * @test
     */
    public function setStateForStringSetsState()
    {
        $this->subject->setState('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'state',
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
}
