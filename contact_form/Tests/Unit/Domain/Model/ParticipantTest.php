<?php
namespace LeadGeneration\ContactForm\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class ParticipantTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \LeadGeneration\ContactForm\Domain\Model\Participant
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \LeadGeneration\ContactForm\Domain\Model\Participant();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getGenderReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getGender()
        );
    }

    /**
     * @test
     */
    public function setGenderForStringSetsGender()
    {
        $this->subject->setGender('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'gender',
            $this->subject
        );
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
    public function getAcademicTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAcademicTitle()
        );
    }

    /**
     * @test
     */
    public function setAcademicTitleForStringSetsAcademicTitle()
    {
        $this->subject->setAcademicTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'academicTitle',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFirstNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFirstName()
        );
    }

    /**
     * @test
     */
    public function setFirstNameForStringSetsFirstName()
    {
        $this->subject->setFirstName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'firstName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLastNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLastName()
        );
    }

    /**
     * @test
     */
    public function setLastNameForStringSetsLastName()
    {
        $this->subject->setLastName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lastName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
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
    public function getInterventionalPulmonologistReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getInterventionalPulmonologist()
        );
    }

    /**
     * @test
     */
    public function setInterventionalPulmonologistForBoolSetsInterventionalPulmonologist()
    {
        $this->subject->setInterventionalPulmonologist(true);

        self::assertAttributeEquals(
            true,
            'interventionalPulmonologist',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPneumologistReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getPneumologist()
        );
    }

    /**
     * @test
     */
    public function setPneumologistForBoolSetsPneumologist()
    {
        $this->subject->setPneumologist(true);

        self::assertAttributeEquals(
            true,
            'pneumologist',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getThoracicSurgeonReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getThoracicSurgeon()
        );
    }

    /**
     * @test
     */
    public function setThoracicSurgeonForBoolSetsThoracicSurgeon()
    {
        $this->subject->setThoracicSurgeon(true);

        self::assertAttributeEquals(
            true,
            'thoracicSurgeon',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGeneralPractitionerReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getGeneralPractitioner()
        );
    }

    /**
     * @test
     */
    public function setGeneralPractitionerForBoolSetsGeneralPractitioner()
    {
        $this->subject->setGeneralPractitioner(true);

        self::assertAttributeEquals(
            true,
            'generalPractitioner',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDistributorReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getDistributor()
        );
    }

    /**
     * @test
     */
    public function setDistributorForBoolSetsDistributor()
    {
        $this->subject->setDistributor(true);

        self::assertAttributeEquals(
            true,
            'distributor',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSpecialistOtherReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSpecialistOther()
        );
    }

    /**
     * @test
     */
    public function setSpecialistOtherForStringSetsSpecialistOther()
    {
        $this->subject->setSpecialistOther('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'specialistOther',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInformationProductPortfolioReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getInformationProductPortfolio()
        );
    }

    /**
     * @test
     */
    public function setInformationProductPortfolioForBoolSetsInformationProductPortfolio()
    {
        $this->subject->setInformationProductPortfolio(true);

        self::assertAttributeEquals(
            true,
            'informationProductPortfolio',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInformaztionClinicalEvidenceReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getInformaztionClinicalEvidence()
        );
    }

    /**
     * @test
     */
    public function setInformaztionClinicalEvidenceForBoolSetsInformaztionClinicalEvidence()
    {
        $this->subject->setInformaztionClinicalEvidence(true);

        self::assertAttributeEquals(
            true,
            'informaztionClinicalEvidence',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInformationOtherReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getInformationOther()
        );
    }

    /**
     * @test
     */
    public function setInformationOtherForStringSetsInformationOther()
    {
        $this->subject->setInformationOther('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'informationOther',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getContact()
        );
    }

    /**
     * @test
     */
    public function setContactForBoolSetsContact()
    {
        $this->subject->setContact(true);

        self::assertAttributeEquals(
            true,
            'contact',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactReasonReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContactReason()
        );
    }

    /**
     * @test
     */
    public function setContactReasonForStringSetsContactReason()
    {
        $this->subject->setContactReason('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contactReason',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCapturedByReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCapturedBy()
        );
    }

    /**
     * @test
     */
    public function setCapturedByForStringSetsCapturedBy()
    {
        $this->subject->setCapturedBy('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'capturedBy',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEventReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setEventForSetsEvent()
    {
    }
}
