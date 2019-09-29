<?php
namespace LeadGeneration\ContactForm\Domain\Model;

/***
 *
 * This file is part of the "Lead Generation contact form" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * Participant
 */
class Participant extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @validate NotEmpty
     * @var string
     */
    protected $title = '';


    /**
     * firstName
     *
     * @validate NotEmpty
     * @var string
     */
    protected $firstName = '';

    /**
     * lastName
     *
     * @validate NotEmpty
     * @var string
     */
    protected $lastName = '';

    /**
     * email
     *
     * @validate NotEmpty
     * @validate EmailAddress
     * @var string
     */
    protected $email = '';

    /**
     * company
     * 
     * @var string
     */
    protected $company = '';

    /**
     * city
     * 
     * @var string
     */
    protected $city = '';

    /**
     * contact
     * 
     * @var bool
     */
    protected $contact = false;

    /**
     * contactReason
     * 
     * @var string
     */
    protected $contactReason = '';

    /**
     * capturedBy
     * 
     * @var string
     */
    protected $capturedBy = '';

    /**
     * event
     * @validate NotEmpty
     * @var \LeadGeneration\ContactForm\Domain\Model\Event
     */
    protected $event = null;

    /**
     * gender
     * @validate NotEmpty
     * @var string
     */
    protected $gender = '';

    /**
     * country
     * 
     * @var string
     */
    protected $country = '';

    /**
     * interventionalPulmonologist
     * 
     * @var bool
     */
    protected $interventionalPulmonologist = false;

    /**
     * pneumologist
     * 
     * @var bool
     */
    protected $pneumologist = false;

    /**
     * thoracicSurgeon
     * 
     * @var bool
     */
    protected $thoracicSurgeon = false;

    /**
     * generalPractitioner
     * 
     * @var bool
     */
    protected $generalPractitioner = false;

    /**
     * distributor
     * 
     * @var bool
     */
    protected $distributor = false;

    /**
     * specialistOther
     * 
     * @var string
     */
    protected $specialistOther = '';

    /**
     * informationProductPortfolio
     * 
     * @var bool
     */
    protected $informationProductPortfolio = false;

    /**
     * informaztionClinicalEvidence
     * 
     * @var bool
     */
    protected $informaztionClinicalEvidence = false;

    /**
     * informationOther
     * 
     * @var string
     */
    protected $informationOther = '';

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }




    /**
     * Returns the firstName
     * 
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the firstName
     * 
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the lastName
     * 
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the lastName
     * 
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the company
     * 
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     * 
     * @param string $company
     * @return void
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Returns the city
     * 
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     * 
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the contact
     * 
     * @return bool $contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Sets the contact
     * 
     * @param bool $contact
     * @return void
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Returns the boolean state of contact
     * 
     * @return bool
     */
    public function isContact()
    {
        return $this->contact;
    }

    /**
     * Returns the contactReason
     * 
     * @return string $contactReason
     */
    public function getContactReason()
    {
        return $this->contactReason;
    }

    /**
     * Sets the contactReason
     * 
     * @param string $contactReason
     * @return void
     */
    public function setContactReason($contactReason)
    {
        $this->contactReason = $contactReason;
    }

    /**
     * Returns the capturedBy
     * 
     * @return string $capturedBy
     */
    public function getCapturedBy()
    {
        return $this->capturedBy;
    }

    /**
     * Sets the capturedBy
     * 
     * @param string $capturedBy
     * @return void
     */
    public function setCapturedBy($capturedBy)
    {
        $this->capturedBy = $capturedBy;
    }

    /**
     * Returns the event
     * 
     * @return \LeadGeneration\ContactForm\Domain\Model\Event event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the event
     * 
     * @param \LeadGeneration\ContactForm\Domain\Model\Event $event
     * @return void
     */
    public function setEvent( \LeadGeneration\ContactForm\Domain\Model\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Returns the gender
     * 
     * @return string $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the gender
     * 
     * @param string $gender
     * @return void
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Returns the country
     * 
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     * 
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the interventionalPulmonologist
     * 
     * @return bool $interventionalPulmonologist
     */
    public function getInterventionalPulmonologist()
    {
        return $this->interventionalPulmonologist;
    }

    /**
     * Sets the interventionalPulmonologist
     * 
     * @param bool $interventionalPulmonologist
     * @return void
     */
    public function setInterventionalPulmonologist($interventionalPulmonologist)
    {
        $this->interventionalPulmonologist = $interventionalPulmonologist;
    }

    /**
     * Returns the boolean state of interventionalPulmonologist
     * 
     * @return bool
     */
    public function isInterventionalPulmonologist()
    {
        return $this->interventionalPulmonologist;
    }

    /**
     * Returns the pneumologist
     * 
     * @return bool $pneumologist
     */
    public function getPneumologist()
    {
        return $this->pneumologist;
    }

    /**
     * Sets the pneumologist
     * 
     * @param bool $pneumologist
     * @return void
     */
    public function setPneumologist($pneumologist)
    {
        $this->pneumologist = $pneumologist;
    }

    /**
     * Returns the boolean state of pneumologist
     * 
     * @return bool
     */
    public function isPneumologist()
    {
        return $this->pneumologist;
    }

    /**
     * Returns the thoracicSurgeon
     * 
     * @return bool $thoracicSurgeon
     */
    public function getThoracicSurgeon()
    {
        return $this->thoracicSurgeon;
    }

    /**
     * Sets the thoracicSurgeon
     * 
     * @param bool $thoracicSurgeon
     * @return void
     */
    public function setThoracicSurgeon($thoracicSurgeon)
    {
        $this->thoracicSurgeon = $thoracicSurgeon;
    }

    /**
     * Returns the boolean state of thoracicSurgeon
     * 
     * @return bool
     */
    public function isThoracicSurgeon()
    {
        return $this->thoracicSurgeon;
    }

    /**
     * Returns the generalPractitioner
     * 
     * @return bool $generalPractitioner
     */
    public function getGeneralPractitioner()
    {
        return $this->generalPractitioner;
    }

    /**
     * Sets the generalPractitioner
     * 
     * @param bool $generalPractitioner
     * @return void
     */
    public function setGeneralPractitioner($generalPractitioner)
    {
        $this->generalPractitioner = $generalPractitioner;
    }

    /**
     * Returns the boolean state of generalPractitioner
     * 
     * @return bool
     */
    public function isGeneralPractitioner()
    {
        return $this->generalPractitioner;
    }

    /**
     * Returns the distributor
     * 
     * @return bool $distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * Sets the distributor
     * 
     * @param bool $distributor
     * @return void
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * Returns the boolean state of distributor
     * 
     * @return bool
     */
    public function isDistributor()
    {
        return $this->distributor;
    }

    /**
     * Returns the specialistOther
     * 
     * @return string $specialistOther
     */
    public function getSpecialistOther()
    {
        return $this->specialistOther;
    }

    /**
     * Sets the specialistOther
     * 
     * @param string $specialistOther
     * @return void
     */
    public function setSpecialistOther($specialistOther)
    {
        $this->specialistOther = $specialistOther;
    }

    /**
     * Returns the informationProductPortfolio
     * 
     * @return bool $informationProductPortfolio
     */
    public function getInformationProductPortfolio()
    {
        return $this->informationProductPortfolio;
    }

    /**
     * Sets the informationProductPortfolio
     * 
     * @param bool $informationProductPortfolio
     * @return void
     */
    public function setInformationProductPortfolio($informationProductPortfolio)
    {
        $this->informationProductPortfolio = $informationProductPortfolio;
    }

    /**
     * Returns the boolean state of informationProductPortfolio
     * 
     * @return bool
     */
    public function isInformationProductPortfolio()
    {
        return $this->informationProductPortfolio;
    }

    /**
     * Returns the informaztionClinicalEvidence
     * 
     * @return bool $informaztionClinicalEvidence
     */
    public function getInformaztionClinicalEvidence()
    {
        return $this->informaztionClinicalEvidence;
    }

    /**
     * Sets the informaztionClinicalEvidence
     * 
     * @param bool $informaztionClinicalEvidence
     * @return void
     */
    public function setInformaztionClinicalEvidence($informaztionClinicalEvidence)
    {
        $this->informaztionClinicalEvidence = $informaztionClinicalEvidence;
    }

    /**
     * Returns the boolean state of informaztionClinicalEvidence
     * 
     * @return bool
     */
    public function isInformaztionClinicalEvidence()
    {
        return $this->informaztionClinicalEvidence;
    }

    /**
     * Returns the informationOther
     * 
     * @return string $informationOther
     */
    public function getInformationOther()
    {
        return $this->informationOther;
    }

    /**
     * Sets the informationOther
     * 
     * @param string $informationOther
     * @return void
     */
    public function setInformationOther($informationOther)
    {
        $this->informationOther = $informationOther;
    }
}
