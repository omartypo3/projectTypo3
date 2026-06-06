<?php
namespace DslFactory\DslJobs\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Mike Zimmer <mz@dsl-factory.de>
 */
class JobLevelTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DslFactory\DslJobs\Domain\Model\JobLevel
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DslFactory\DslJobs\Domain\Model\JobLevel();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getJobLevelReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setJobLevelForIntSetsJobLevel()
    {
    }

    /**
     * @test
     */
    public function getBezeichnungReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBezeichnung()
        );

    }

    /**
     * @test
     */
    public function setBezeichnungForStringSetsBezeichnung()
    {
        $this->subject->setBezeichnung('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'bezeichnung',
            $this->subject
        );

    }
}
