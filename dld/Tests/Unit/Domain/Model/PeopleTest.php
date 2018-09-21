<?php
namespace DLD\Dld\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class PeopleTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DLD\Dld\Domain\Model\People
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \DLD\Dld\Domain\Model\People();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getEmailPrivateReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmailPrivate()
        );

    }

    /**
     * @test
     */
    public function setEmailPrivateForStringSetsEmailPrivate()
    {
        $this->subject->setEmailPrivate('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'emailPrivate',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getEmailDefaultCcReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmailDefaultCc()
        );

    }

    /**
     * @test
     */
    public function setEmailDefaultCcForStringSetsEmailDefaultCc()
    {
        $this->subject->setEmailDefaultCc('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'emailDefaultCc',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getSocialLinkedinUrlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSocialLinkedinUrl()
        );

    }

    /**
     * @test
     */
    public function setSocialLinkedinUrlForStringSetsSocialLinkedinUrl()
    {
        $this->subject->setSocialLinkedinUrl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'socialLinkedinUrl',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getSocialTwitterUsernameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSocialTwitterUsername()
        );

    }

    /**
     * @test
     */
    public function setSocialTwitterUsernameForStringSetsSocialTwitterUsername()
    {
        $this->subject->setSocialTwitterUsername('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'socialTwitterUsername',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getIsAmazingSpeakerReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getIsAmazingSpeaker()
        );

    }

    /**
     * @test
     */
    public function setIsAmazingSpeakerForBoolSetsIsAmazingSpeaker()
    {
        $this->subject->setIsAmazingSpeaker(true);

        self::assertAttributeEquals(
            true,
            'isAmazingSpeaker',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getAmazingSpeakerSortOrderReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setAmazingSpeakerSortOrderForIntSetsAmazingSpeakerSortOrder()
    {
    }
}
