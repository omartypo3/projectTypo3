<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.08.2018
 * Time: 11:20
 */

namespace Pingag\PingagRealEstate\Form;


use Pingag\PingagRealEstate\Domain\Model\RealEstate;

class ContactForm
{

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $greeting;
    /**
     * @var string
     * @validate NotEmpty
     */
    protected $firstName;
    /**
     * @var string
     * @validate NotEmpty
     */
    protected $lastName;
    /**
     * @var string
     * @validate NotEmpty
     */
    protected $street;
    /**
     * @var string
     * @validate NotEmpty
     * @validate Number
     */
    protected $zip;
    /**
     * @var string
     * @validate NotEmpty
     */
    protected $city;
    /**
     * @var string
     * @validate NotEmpty
     */
    protected $country = 'Schweiz';
    /**
     * @var string
     * @validate NotEmpty
     * @validate EmailAddress
     */
    protected $email;
    /**
     * @var string
     * @validate NotEmpty
     * @validate Alphanumeric
     */
    protected $phone;
    /**
     * @var string
     */
    protected $comment;
    
    /**
     * @var \Pingag\PingagRealEstate\Domain\Model\RealEstate
     */
    protected $realEstate;

    /**
     * ContactForm constructor.
     * @param RealEstate $realEstate
     */
    public function __construct(\Pingag\PingagRealEstate\Domain\Model\RealEstate $realEstate)
    {
        $this->realEstate = $realEstate;
    }

    /**
     * @return string
     */
    public function getGreeting()
    {
        return $this->greeting;
    }

    /**
     * @param string $greeting
     * @return $this
     */
    public function setGreeting($greeting)
    {
        $this->greeting = $greeting;
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
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
     * @return \Pingag\PingagRealEstate\Domain\Model\RealEstate
     */
    public function getRealEstate()
    {
        return $this->realEstate;
    }

    /**
     * @param \Pingag\PingagRealEstate\Domain\Model\RealEstate $realEstate
     * @return $this
     */
    public function setRealEstate($realEstate)
    {
        $this->realEstate = $realEstate;
        return $this;
    }
}