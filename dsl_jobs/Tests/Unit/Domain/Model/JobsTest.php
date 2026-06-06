<?php
namespace DslFactory\DslJobs\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class JobsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslJobs\Domain\Model\Jobs
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslJobs\Domain\Model\Jobs();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getJobidReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobid()
        );

    }

    /**
     * @test
     */
    public function setJobidForStringSetsJobid()
    {
        $this->subject->setJobid('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobid',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getJobtitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobtitle()
        );

    }

    /**
     * @test
     */
    public function setJobtitleForStringSetsJobtitle()
    {
        $this->subject->setJobtitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobtitle',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionIntroHeadingReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionIntroHeading()
        );

    }

    /**
     * @test
     */
    public function setDescriptionIntroHeadingForStringSetsDescriptionIntroHeading()
    {
        $this->subject->setDescriptionIntroHeading('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionIntroHeading',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionIntroBodyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionIntroBody()
        );

    }

    /**
     * @test
     */
    public function setDescriptionIntroBodyForStringSetsDescriptionIntroBody()
    {
        $this->subject->setDescriptionIntroBody('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionIntroBody',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionTasksHeadingReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionTasksHeading()
        );

    }

    /**
     * @test
     */
    public function setDescriptionTasksHeadingForStringSetsDescriptionTasksHeading()
    {
        $this->subject->setDescriptionTasksHeading('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionTasksHeading',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionTasksBodyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionTasksBody()
        );

    }

    /**
     * @test
     */
    public function setDescriptionTasksBodyForStringSetsDescriptionTasksBody()
    {
        $this->subject->setDescriptionTasksBody('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionTasksBody',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionQualificationsHeadingReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionQualificationsHeading()
        );

    }

    /**
     * @test
     */
    public function setDescriptionQualificationsHeadingForStringSetsDescriptionQualificationsHeading()
    {
        $this->subject->setDescriptionQualificationsHeading('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionQualificationsHeading',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionQualificationsBodyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionQualificationsBody()
        );

    }

    /**
     * @test
     */
    public function setDescriptionQualificationsBodyForStringSetsDescriptionQualificationsBody()
    {
        $this->subject->setDescriptionQualificationsBody('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionQualificationsBody',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionBenefitsHeadingReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionBenefitsHeading()
        );

    }

    /**
     * @test
     */
    public function setDescriptionBenefitsHeadingForStringSetsDescriptionBenefitsHeading()
    {
        $this->subject->setDescriptionBenefitsHeading('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionBenefitsHeading',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionBenefitsBodyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionBenefitsBody()
        );

    }

    /**
     * @test
     */
    public function setDescriptionBenefitsBodyForStringSetsDescriptionBenefitsBody()
    {
        $this->subject->setDescriptionBenefitsBody('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionBenefitsBody',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDescriptionOutroBodyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescriptionOutroBody()
        );

    }

    /**
     * @test
     */
    public function setDescriptionOutroBodyForStringSetsDescriptionOutroBody()
    {
        $this->subject->setDescriptionOutroBody('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'descriptionOutroBody',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getApplylinkLabelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApplylinkLabel()
        );

    }

    /**
     * @test
     */
    public function setApplylinkLabelForStringSetsApplylinkLabel()
    {
        $this->subject->setApplylinkLabel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'applylinkLabel',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getApplylinkUrlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApplylinkUrl()
        );

    }

    /**
     * @test
     */
    public function setApplylinkUrlForStringSetsApplylinkUrl()
    {
        $this->subject->setApplylinkUrl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'applylinkUrl',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getJobSiteReturnsInitialValueForJobSite()
    {
        self::assertEquals(
            null,
            $this->subject->getJobSite()
        );

    }

    /**
     * @test
     */
    public function setJobSiteForJobSiteSetsJobSite()
    {
        $jobSiteFixture = new \DslFactory\DslJobs\Domain\Model\JobSite();
        $this->subject->setJobSite($jobSiteFixture);

        self::assertAttributeEquals(
            $jobSiteFixture,
            'jobSite',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getJobLevelReturnsInitialValueForJobLevel()
    {
        self::assertEquals(
            null,
            $this->subject->getJobLevel()
        );

    }

    /**
     * @test
     */
    public function setJobLevelForJobLevelSetsJobLevel()
    {
        $jobLevelFixture = new \DslFactory\DslJobs\Domain\Model\JobLevel();
        $this->subject->setJobLevel($jobLevelFixture);

        self::assertAttributeEquals(
            $jobLevelFixture,
            'jobLevel',
            $this->subject
        );

    }
}
