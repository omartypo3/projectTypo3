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
 * User
 */
class User extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
    /**
     * roles
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Role>
     */
    protected $roles = null;


    /**
     * privilege
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Institution
     */
    protected $privilege = null;

    /**
     * @var bool
     */
    protected $iscitycouncil;

    /**
     * @var bool
     */
    protected $showInRegister;

    /**
     * @var bool
     */
    protected $ismanagement;

    /**
     * @var string
     */
    protected $managementPosition;

    /**
     * @var bool
     */
    protected $ismanagementDeputy;

    /**
     * @var string
     */
    protected $managementDeputyPosition;

    /**
     * @var bool
     */
    protected $noFrontendLogin;

    /**
     * Number of mobilephone
     *
     * @var string
     */
    protected $mobilephone;

    /**
     * title agency
     *
     * @var string
     */
    protected $titleAgency;

    /**
     * secondary image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $secondaryImage = null;

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
    }

    /**
     * Returns the privilege
     *
     * @return \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $privilege
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Sets the privilege
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $privilege
     * @return void
     */
    public function setPrivilege(\FRONTAL\FagInstitutionManagement\Domain\Model\Institution $privilege)
    {
        $this->privilege = $privilege;
    }

    /**
     * Adds a
     *
     * @param  \FRONTAL\FagInstitutionManagement\Domain\Model\Role $role
     * @return void
     */
    public function addRole($role)
    {
        $this->roles->attach($role);
    }

    /**
     * Removes a
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Role $role The  to be removed
     * @return void
     */
    public function removeRole($role)
    {
        $this->roles->detach($role);
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
     * Get citycouncil flag
     *
     * @return bool
     */
    public function getIscitycouncil()
    {
        return $this->iscitycouncil;
    }

    /**
     * Set citycouncil flag
     *
     * @param bool $iscitycouncil top news flag
     */
    public function setIscitycouncil($iscitycouncil)
    {
        $this->iscitycouncil = $iscitycouncil;
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
     * @param bool $showInRegister top news flag
     */
    public function setShowInRegister($showInRegister)
    {
        $this->showInRegister = $showInRegister;
    }

    /**
     * Get management flag
     *
     * @return bool
     */
    public function getIsmanagement()
    {
        return $this->ismanagement;
    }

    /**
     * Set management flag
     *
     * @param bool $ismanagement top news flag
     */
    public function setIsmanagement($ismanagement)
    {
        $this->ismanagement = $ismanagement;
    }

    /**
     * Get managementPosition flag
     *
     * @return bool
     */
    public function getManagementPosition()
    {
        return $this->managementPosition;
    }

    /**
     * Set managementPosition flag
     *
     * @param bool $managementPosition top news flag
     */
    public function setManagementPosition($managementPosition)
    {
        $this->managementPosition = $managementPosition;
    }

    /**
     * Get managementDeputy flag
     *
     * @return bool
     */
    public function getIsmanagementDeputy()
    {
        return $this->ismanagementDeputy;
    }

    /**
     * Set managementDeputy flag
     *
     * @param bool $ismanagementDeputy
     */
    public function setIsmanagementDeputy($ismanagementDeputy)
    {
        $this->ismanagementDeputy = $ismanagementDeputy;
    }

    /**
     * Get managementDeputyPosition flag
     *
     * @return bool
     */
    public function getManagementDeputyPosition()
    {
        return $this->managementDeputyPosition;
    }

    /**
     * Set managementDeputyPosition flag
     *
     * @param bool $managementDeputyPosition
     */
    public function setManagementDeputyPosition($managementDeputyPosition)
    {
        $this->managementDeputyPosition = $managementDeputyPosition;
    }

    /**
     * Get no_frontend_login flag
     *
     * @return bool
     */
    public function getNoFrontendLogin()
    {
        return $this->noFrontendLogin;
    }

    /**
     * Set no_frontend_login flag
     *
     * @param bool $showInRegister top news flag
     */
    public function setNoFrontendLogin($noFrontendLogin)
    {
        $this->noFrontendLogin = $noFrontendLogin;
    }

    /**
     * Getter for mobilphone
     *
     * @return string
     */
    public function getMobilephone()
    {
        return $this->mobilephone;
    }

    /**
     * Setter for mobilphone
     *
     * @param string $mobilephone
     * @return void
     */
    public function setMobilephone($mobilephone)
    {
        $this->mobilephone = $mobilephone;
    }

    /**
     * Getter for title agency
     *
     * @return string
     */
    public function getTitleAgency()
    {
        return $this->titleAgency;
    }

    /**
     * Setter for title agency
     *
     * @param string $titleAgency
     * @return void
     */
    public function setTitleAgency($titleAgency)
    {
        $this->titleAgency = $titleAgency;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $secondaryImage
     */
    public function getSecondaryImage() {
        return $this->secondaryImage;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $secondaryImage
     * @return void
     */
    public function setSecondaryImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $secondaryImage) {
        $this->secondaryPicture = $secondaryImage;
    }
}
