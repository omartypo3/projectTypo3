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
 * Institution
 */
class Institution extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * Institution contact label
     * @var string
     */
    protected $institutionContactLabel;

    /**
     * First Name
     * @var string
     */
    protected $firstName;

    /**
     * Last Name
     * @var string
     */
    protected $lastName;

    /**
     * address
     * @var string
     */
    protected $address;

    /**
     * zipcode
     * @var string
     */
    protected $zip;

    /**
     * city
     * @var string
     */
    protected $city;

    /**
     * company
     * @var string
     */
    protected $company;

    /**
     * phone
     * @var string
     */
    protected $phone;

    /**
     * mobile
     * @var string
     */
    protected $mobile;

    /**
     * fax
     * @var string
     */
    protected $fax;

    /**
     * email
     * @var string
     */
    protected $email;

    /**
     * www
     * @var string
     */
    protected $www;

    /**
     * detailSite
     * @var integer
     */
    protected $detailSite;

    /**
     * main address from tt_address
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagRadialsearch\Domain\Model\Address>
     * @cascade remove
     */
    protected $mainAddress = null;


    /**
     * logo
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logo;

    /**
     *  images
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $images;

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * roles
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Role>
     * @cascade remove
     */
    protected $roles = null;

    /**
     * events
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Event>
     * @cascade remove
     */
    protected $events = null;

	/**
	 * categories
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 * @lazy
	 */
	protected $categories;

    /**
     * links
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Link>
     */
    protected $links;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Link>
     * @lazy
     */
    protected $relatedFrom;

    /**
     * admin
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User>
     */
    protected $admin = null;
    /**
     * feUsers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User>
     */
    protected $feUsers;
    /**
     * document
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $document = null;


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
        $this->roles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->events = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->admin = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->document = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the detailSite
     *
     * @return integer $detailSite
     */
    public function getDetailSite()
    {
        return $this->detailSite;
    }

    /**
     * Sets the detailSite
     *
     * @param integer $detailSite
     * @return void
     */
    public function setDetailSite($detailSite)
    {
        $this->detailSite = $detailSite;
    }

    /**
     * sets the institutionContactLabel attribute
     *
     * @param string $institutionContactLabel
     * @return void
     */
    public function setInstitutionContactLabel($institutionContactLabel)
    {
        $this->institutionContactLabel = $institutionContactLabel;
    }

    /**
     * returns the institutionContactLabel attribute
     *
     * @return string
     */
    public function getInstitutionContactLabel()
    {
        return $this->institutionContactLabel;
    }

    /**
     * sets the firstName attribute
     *
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * returns the firstName attribute
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * sets the lastName attribute
     *
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * returns the lastName attribute
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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
     * Returns the mainAddress
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagRadialsearch\Domain\Model\Address> $mainAddress
     */
    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    /**
     * Sets the mainAddress
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagRadialsearch\Domain\Model\Address> $mainAddress
     * @return void
     */
    public function setMainAddress(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mainAddress)
    {
        $this->mainAddress = $mainAddress;
    }


    /**
     * Returns the logo
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Sets the logo
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     * @return void
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

	/**
	 * Returns the images
	 *
	 * @return  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Sets the images
	 *
	 * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
	 * @return void
	 */
	public function setImages($images) {
		$this->images = $images;
	}

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a
     *
     * @param  $role
     * @return void
     */
    public function addRole($role)
    {
        $this->roles->attach($role);
    }

    /**
     * Removes a
     *
     * @param $roleToRemove The  to be removed
     * @return void
     */
    public function removeRole($roleToRemove)
    {
        $this->roles->detach($roleToRemove);
    }

    /**
     * Returns the roles
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Role> $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Sets the roles
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Role> $roles
     * @return void
     */
    public function setRoles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Adds a Event
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $event
     * @return void
     */
    public function addEvent(\FRONTAL\FagInstitutionManagement\Domain\Model\Event $event)
    {
        $this->events->attach($event);
    }

    /**
     * Removes a Event
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Event $eventToRemove The Event to be removed
     * @return void
     */
    public function removeEvent(\FRONTAL\FagInstitutionManagement\Domain\Model\Event $eventToRemove)
    {
        $this->events->detach($eventToRemove);
    }

    /**
     * Returns the events
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Event> $events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Sets the events
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Event> $events
     * @return void
     */
    public function setEvents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $events)
    {
        $this->events = $events;
    }

	/**
	 * Returns the categories
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
	 */
	public function getCategories() {
	    return $this->categories;
	}

	/**
	 * Sets the categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
	 * @return void
	 */
	public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
	    $this->categories = $categories;
	}

    /**
     * Get related links
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Link>
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set related from
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Link> $relatedFrom
     */
    public function setRelatedFrom($relatedFrom)
    {
        $this->relatedFrom = $relatedFrom;
    }

    /**
     * Get related from
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Link>
     */
    public function getRelatedFrom()
    {
        return $this->relatedFrom;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Adds a User
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $admin
     * @return void
     */
    public function addAdmin(\FRONTAL\FagInstitutionManagement\Domain\Model\User $admin)
    {
        $this->admin->attach($admin);
    }

    /**
     * Removes a User
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $adminToRemove The User to be removed
     * @return void
     */
    public function removeAdmin(\FRONTAL\FagInstitutionManagement\Domain\Model\User $adminToRemove)
    {
        $this->admin->detach($adminToRemove);
    }

    /**
     * Returns the admin
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User> $admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Sets the admin
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User> $admin
     * @return void
     */
    public function setAdmin(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Returns the feUsers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\User> $feUsers
     */
    public function getFeUsers()
    {
        return $this->feUsers;
    }
    /**
     * sets the documents
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $images
     *
     * @return void
     */
    public function setDocument($document) {
        $this->document = $document;
    }

    /**
     * get the documents
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDocument() {
        return $this->document;
    }

    /**
     * Adds a User
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $doc
     * @return void
     */
    public function addDocument(\TYPO3\CMS\Extbase\Domain\Model\FileReference $doc)
    {
        $this->document->attach($doc);
    }

    /**
     * Removes a User
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $doc The User to be removed
     * @return void
     */
    public function removeDocument(\TYPO3\CMS\Extbase\Domain\Model\FileReference $doc)
    {
        $this->document->detach($doc);
    }
}
