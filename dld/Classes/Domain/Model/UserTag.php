<?php
namespace DLD\Dld\Domain\Model;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * UsetTag
 */
class UserTag extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Variable userid
     *
     * @var int
     */
    protected $userid = NULL;

    /**
     * Variable highrisetag
     *
     * @var string
     */
    protected $highrisetag = NULL;

    /**
     * Variable highrisetagcreatedat
     *
     * @var \Datetime
     */
    protected $highrisetagcreatedat = NULL;

    /**
     * Variable emailsentat
     *
     * @var \Datetime
     */
    protected $emailsentat = NULL;

    /**
     * Variable emailsent
     *
     * @var bool
     */
    protected $emailsent = NULL;

    /**
     * Variable mailchimpplaceholders
     *
     * @var string
     */
    protected $mailchimpplaceholders = NULL;
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

    }
    /**
     * Returns the userid
     *
     * @return int $userid
     */
    public function getUserid() {
        return $this->userid;
    }

    /**
     * Sets the userid
     *
     * @param int $userid
     * @return void
     */
    public function setUserid($userid) {
        $this->userid = $userid;
    }

    /**
     * Returns the highrisetag
     *
     * @return string $highrisetag
     */
    public function getHighrisetag() {
        return $this->highrisetag;
    }

    /**
     * Sets the highrisetag
     *
     * @param string $highrisetag
     * @return void
     */
    public function setHighrisetag($highrisetag) {
        $this->highrisetag = $highrisetag;
    }

    /**
     * Returns the emailsentat
     *
     * @return \Datetime $emailsentat
     */
    public function getEmailsentat() {
        return $this->emailsentat;
    }

    /**
     * Sets the emailsentat
     *
     * @param \Datetime $emailsentat
     * @return void
     */
    public function setEmailsentat($emailsentat) {
        $this->emailsentat = $emailsentat;
    }


    /**
     * Returns the highrisetagcreatedat
     *
     * @return \Datetime $highrisetagcreatedat
     */
    public function getHighriseTagcreatedat() {
        return $this->highrisetagcreatedat;
    }

    /**
     * Sets the highrisetagcreatedat
     *
     * @param \Datetime $highrisetagcreatedat
     * @return void
     */
    public function setHighriseTagcreatedat($highrisetagcreatedat) {
        $this->highrisetagcreatedat = $highrisetagcreatedat;
    }


    /**
     * Returns the emailsent
     *
     * @return bool $emailsent
     */
    public function getEmailsent() {
        return $this->emailsent;
    }

    /**
     * Sets the emailsent
     *
     * @param bool $emailsent
     * @return void
     */
    public function setEmailsent($emailsent) {
        $this->emailsent = $emailsent;
    }


    /**
     * Returns the mailchimpplaceholders
     *
     * @return string $mailchimpplaceholders
     */
    public function getMailchimpPlaceholders() {
        return $this->mailchimpplaceholders;
    }

    /**
     * Sets the mailchimpplaceholders
     *
     * @param string $mailchimpplaceholders
     * @return void
     */
    public function setMailchimpPlaceholders($mailchimpplaceholders) {
        $this->mailchimpplaceholders = $mailchimpplaceholders;
    }

}
