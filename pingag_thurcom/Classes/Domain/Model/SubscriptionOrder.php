<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 23.08.2017
 * Time: 15:18
 */

namespace Pingag\PingagThurcom\Domain\Model;


use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class SubscriptionOrder extends BaseEntity
{

    /**
     * @var \Pingag\PingagThurcom\Domain\Model\InternetPackage
     * @lazy
     */
    protected $internetPackage;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagThurcom\Domain\Model\SubscriptionOption>
     * @lazy
     */
    protected $options;
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagThurcom\Domain\Model\Product>
     * @lazy
     */
    protected $additionalProducts;

    /** @var string */
    protected $firmName;
    /** @var string */
    protected $salutation;
    /** @var string */
    protected $firstName;
    /** @var string */
    protected $lastName;
    /** @var string */
    protected $address;
    /** @var string */
    protected $city;
    /** @var string */
    protected $telephonePrivate;
    /** @var string */
    protected $telephoneOffice;
    /** @var string */
    protected $telephoneMobile;
    /** @var string */
    protected $email;
    /** @var string */
    protected $birthday;
    /** @var string */
    protected $comment;
	/** @var string */
    protected $zubehoer;
	/** @var string */
    protected $zusatzoption;
	/** @var string */
    protected $rufnummer;
	/** @var string */
    protected $costsOnce;
	/** @var string */
    protected $costsMonth;
    /**
     * Image
     *
     * @var  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $image;


    /**
     * SubscriptionOrder constructor.
     */
    public function __construct()
    {
        $this->image = new ObjectStorage();
        $this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->additionalProducts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return InternetPackage
     */
    public function getInternetPackage()
    {
        return $this->internetPackage;
    }

    /**
     * @param InternetPackage $internetPackage
     * @return $this
     */
    public function setInternetPackage($internetPackage)
    {
        $this->internetPackage = $internetPackage;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param ServiceOption $option
     */
    public function addOption(ServiceOption $option)
    {
        $this->getOptions()->attach($option);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getAdditionalProducts()
    {
        return $this->additionalProducts;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $additionalProducts
     * @return $this
     */
    public function setAdditionalProducts($additionalProducts)
    {
        $this->additionalProducts = $additionalProducts;
        return $this;
    }

    public function getFullname()
    {
        return $this->getLastName() . ' ' . $this->getFirstName();
    }

    /**
     * @return string
     */
    public function getFirmName()
    {
        return $this->firmName;
    }

    /**
     * @param string $firmName
     * @return $this
     */
    public function setFirmName($firmName)
    {
        $this->firmName = $firmName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     * @return $this
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephonePrivate()
    {
        return $this->telephonePrivate;
    }

    /**
     * @param string $telephonePrivate
     * @return $this
     */
    public function setTelephonePrivate($telephonePrivate)
    {
        $this->telephonePrivate = $telephonePrivate;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephoneOffice()
    {
        return $this->telephoneOffice;
    }

    /**
     * @param string $telephoneOffice
     * @return $this
     */
    public function setTelephoneOffice($telephoneOffice)
    {
        $this->telephoneOffice = $telephoneOffice;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephoneMobile()
    {
        return $this->telephoneMobile;
    }

    /**
     * @param string $telephoneMobile
     * @return $this
     */
    public function setTelephoneMobile($telephoneMobile)
    {
        $this->telephoneMobile = $telephoneMobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     * @return $this
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getZubehoer()
    {
        return $this->zubehoer;
    }

    /**
     * @param string $zubehoer
     * @return $this
     */
    public function setZubehoer($zubehoer)
    {
        $this->zubehoer = $zubehoer;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getZusatzoption()
    {
        return $this->zusatzoption;
    }

    /**
     * @param string $zusatzoption
     * @return $this
     */
    public function setZusatzoption($zusatzoption)
    {
        $this->zusatzoption = $zusatzoption;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getRufnummer()
    {
        return $this->rufnummer;
    }

    /**
     * @param string $rufnummer
     * @return $this
     */
    public function setRufnummer($rufnummer)
    {
        $this->rufnummer = $rufnummer;
        return $this;
    }
	/**
     * @return string
     */
    public function getCostsOnce()
    {
        return $this->costsOnce;
    }

    /**
     * @param string $costsOnce
     * @return $this
     */
    public function setCostsOnce($costsOnce)
    {
        $this->costsOnce = $costsOnce;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getCostsMonth()
    {
        return $this->costsMonth;
    }

    /**
     * @param string $costsMonth
     * @return $this
     */
    public function setCostsMonth($costsMonth)
    {
        $this->costsMonth = $costsMonth;
        return $this;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}