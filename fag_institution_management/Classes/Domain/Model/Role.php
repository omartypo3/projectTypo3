<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***
 *
 * This file is part of the "FRONTAL / Institutionen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Roland Kneubühler <rk@frontal.ch>, Agentur Frontal AG
 *
 ***/

/**
 * Function
 */
class Role extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * address
     * @var string
     */
    protected $address;

    /**
     * @var bool
     */
    protected $hideAddress;

    /**
     * zipcode
     * @var string
     */
    protected $zip;

    /**
     * @var bool
     */
    protected $hideZip;

    /**
     * city
     * @var string
     */
    protected $city;

    /**
     * @var bool
     */
    protected $hideCity;

    /**
     * company
     * @var string
     */
    protected $company;

    /**
     * @var bool
     */
    protected $hideCompany;

    /**
     * phone
     * @var string
     */
    protected $phone;

    /**
     * @var bool
     */
    protected $hidePhone;

    /**
     * mobile
     * @var string
     */
    protected $mobile;

    /**
     * @var bool
     */
    protected $hideMobile;

    /**
     * fax
     * @var string
     */
    protected $fax;

    /**
     * @var bool
     */
    protected $hideFax;

    /**
     * email
     * @var string
     */
    protected $email;

    /**
     * @var bool
     */
    protected $hideEmail;

    /**
     * www
     * @var string
     */
    protected $www;

    /**
     * @var bool
     */
    protected $hideWww;

    /**
     * @var bool
     */
    protected $showInRegister;

    /**
     * user
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User>
     * @cascade remove
     */
    protected $user = null;
    /**
     * @var bool
     */
    protected $isadmin;
    /**
     * institution
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Institution
     */
    protected $institution = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->user = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
     * sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * returns the address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * sets the hideAddress
     *
     * @param string $hideAddress
     * @return void
     */
    public function setHideAddress($hideAddress)
    {
        $this->hideAddress = $hideAddress;
    }

    /**
     * returns the hideAddress
     *
     * @return string
     */
    public function getHideAddress()
    {
        return $this->hideAddress;
    }

    /**
     * sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * returns the zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * sets the hideZip
     *
     * @param string $hideZip
     * @return void
     */
    public function setHideZip($hideZip)
    {
        $this->hideZip = $hideZip;
    }

    /**
     * returns the hideZip
     *
     * @return string
     */
    public function getHideZip()
    {
        return $this->hideZip;
    }

    /**
     * sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * returns the city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * sets the hideCity
     *
     * @param string $hideCity
     * @return void
     */
    public function setHideCity($hideCity)
    {
        $this->hideCity = $hideCity;
    }

    /**
     * returns the hideCity
     *
     * @return string
     */
    public function getHideCity()
    {
        return $this->hideCity;
    }

    /**
     * sets the company attribute
     *
     * @param string $company
     * @return void
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * returns the company attribute
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * sets the hideCompany attribute
     *
     * @param string $hideCompany
     * @return void
     */
    public function setHideCompany($hideCompany)
    {
        $this->hideCompany = $hideCompany;
    }

    /**
     * returns the hideCompany attribute
     *
     * @return string
     */
    public function getHideCompany()
    {
        return $this->hideCompany;
    }

    /**
     * sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * returns the phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get hide phone flag
     *
     * @return bool
     */
    public function getHidePhone()
    {
        return $this->hidePhone;
    }
    /**
     * Set hide phone flag
     *
     * @param bool $hidePhone hide phone flag
     */
    public function setHidePhone($hidePhone)
    {
        $this->hidePhone = $hidePhone;
    }

    /**
     * sets the mobile
     *
     * @param string $mobile
     * @return void
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * returns the mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Get hide mobile flag
     *
     * @return bool
     */
    public function getHideMobile()
    {
        return $this->hideMobile;
    }

    /**
     * Set hide mobile flag
     *
     * @param bool $hideMobile hide mobile flag
     */
    public function setHideMobile($hideMobile)
    {
        $this->hideMobile = $hideMobile;
    }

    /**
     * sets the fax
     *
     * @param string $fax
     * @return void
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * returns the fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Get hide fax flag
     *
     * @return bool
     */
    public function getHideFax()
    {
        return $this->hideFax;
    }
    
    /**
     * Set hide fax flag
     *
     * @param bool $hideFax hide fax flag
     */
    public function setHideFax($hideFax)
    {
        $this->hideFax = $hideFax;
    }

    /**
     * sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * returns the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get hide email flag
     *
     * @return bool
     */
    public function getHideEmail()
    {
        return $this->hideEmail;
    }
    
    /**
     * Set hide email flag
     *
     * @param bool $hideEmail hide email flag
     */
    public function setHideEmail($hideEmail)
    {
        $this->hideEmail = $hideEmail;
    }

    /**
     * sets the www
     *
     * @param string $www
     * @return void
     */
    public function setWww($www)
    {
        $this->www = $www;
    }

    /**
     * returns the www
     *
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * Get hide www flag
     *
     * @return bool
     */
    public function getHideWww()
    {
        return $this->hideWww;
    }
    
    /**
     * Set hide www flag
     *
     * @param bool $hideWww hide www flag
     */
    public function setHideWww($hideWww)
    {
        $this->hideWww = $hideWww;
    }

    /**
     * Get show_in_register flag
     *
     * @return bool
     */
    public function getShowInRegister()
    {
        return $this->showInRegister;
    }

    /**
     * Set show_in_register flag
     *
     * @param bool $showInRegister show_in_register flag
     */
    public function setShowInRegister($showInRegister)
    {
        $this->showInRegister = $showInRegister;
    }

    /**
     * Adds a User
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $user
     * @return void
     */
    public function addUser(\FRONTAL\FagInstitutionManagement\Domain\Model\User $user)
    {
        $this->user->attach($user);
    }

    /**
     * Removes a User
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $userToRemove The User to be removed
     * @return void
     */
    public function removeUser(\FRONTAL\FagInstitutionManagement\Domain\Model\User $userToRemove)
    {
        $this->user->detach($userToRemove);
    }

    /**
     * Returns the user
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User> $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User> $user
     * @return void
     */
    public function setUser(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $user)
    {
        $this->user = $user;
    }

    /**
     * Returns the institution
     *
     * @return \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Sets the institution
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     * @return void
     */
    public function setInstitution(\FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution)
    {
        $this->institution = $institution;
    }

    /**
     * Set isadmin
     *
     * @param bool $isadmin
     */
    public function setIsadmin($isadmin)
    {
        $this->isadmin = $isadmin;
    }

    /**
     * Get isadmin flag
     *
     * @return bool
     */
    public function getIsadmin()
    {
        return $this->isadmin;
    }
}
