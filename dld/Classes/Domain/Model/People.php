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
 * People
 */
class People extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * emailPrivate
     *@validate EmailAddress
     * @var string
     */
    protected $emailPrivate = '';

    /**
     * emailDefaultCc
     *@validate EmailAddress
     * @var string
     */
    protected $emailDefaultCc = '';

    /**
     * socialLinkedinUrl
     *
     * @var string
     */
    protected $socialLinkedinUrl = '';

    /**
     * socialTwitterUsername
     *
     * @var string
     */
    protected $socialTwitterUsername = '';

    /**
     * isAmazingSpeaker
     *
     * @var bool
     */
    protected $isAmazingSpeaker = false;

    /**
     * isDldTeam
     *
     * @var bool
     */
    protected $isDldTeam = false;

    /**
     * amazingSpeakerSortOrder
     *
     * @var int
     */
    protected $amazingSpeakerSortOrder = 0;

    /**
     * gender
     *
     * @var int
     */
    protected $gender = 0;

    /**
     * biography
     *
     * @var string
     */
    protected $biography = '';
    /**
     * highrisePersonId
     *
     * @var int
     */
    protected $highrisePersonId;

    /**
     * youtubevideos
     *
     * @var string
     */
    protected $youtubevideos = '';



    /**
     * Returns the emailPrivate
     *
     * @return string $emailPrivate
     */
    public function getEmailPrivate()
    {
        return $this->emailPrivate;
    }

    /**
     * Sets the emailPrivate
     *
     * @param string $emailPrivate
     * @return void
     */
    public function setEmailPrivate($emailPrivate)
    {
        $this->emailPrivate = $emailPrivate;
    }

    /**
     * Returns the emailDefaultCc
     *
     * @return string $emailDefaultCc
     */
    public function getEmailDefaultCc()
    {
        return $this->emailDefaultCc;
    }

    /**
     * Sets the emailDefaultCc
     *
     * @param string $emailDefaultCc
     * @return void
     */
    public function setEmailDefaultCc($emailDefaultCc)
    {
        $this->emailDefaultCc = $emailDefaultCc;
    }

    /**
     * Returns the socialLinkedinUrl
     *
     * @return string $socialLinkedinUrl
     */
    public function getSocialLinkedinUrl()
    {
        return $this->socialLinkedinUrl;
    }

    /**
     * Sets the socialLinkedinUrl
     *
     * @param string $socialLinkedinUrl
     * @return void
     */
    public function setSocialLinkedinUrl($socialLinkedinUrl)
    {
        $this->socialLinkedinUrl = $socialLinkedinUrl;
    }

    /**
     * Returns the socialTwitterUsername
     *
     * @return string $socialTwitterUsername
     */
    public function getSocialTwitterUsername()
    {
        return $this->socialTwitterUsername;
    }

    /**
     * Sets the socialTwitterUsername
     *
     * @param string $socialTwitterUsername
     * @return void
     */
    public function setSocialTwitterUsername($socialTwitterUsername)
    {
        $this->socialTwitterUsername = $socialTwitterUsername;
    }

    /**
     * Returns the isAmazingSpeaker
     *
     * @return bool $isAmazingSpeaker
     */
    public function getIsAmazingSpeaker()
    {
        return $this->isAmazingSpeaker;
    }

    /**
     * Sets the isAmazingSpeaker
     *
     * @param bool $isAmazingSpeaker
     * @return void
     */
    public function setIsAmazingSpeaker($isAmazingSpeaker)
    {
        $this->isAmazingSpeaker = $isAmazingSpeaker;
    }

    /**
     * Returns the boolean state of isAmazingSpeaker
     *
     * @return bool
     */
    public function isIsAmazingSpeaker()
    {
        return $this->isAmazingSpeaker;
    }

    /**
     * Returns the isDldTeam
     *
     * @return bool $isDldTeam
     */
    public function getIsDldTeam()
    {
        return $this->isDldTeam;
    }
    /**
     * Sets the isDldTeam
     *
     * @param bool $isDldTeam
     * @return void
     */
    public function setIsDldTeam($isDldTeam)
    {
        $this->isDldTeam = $isDldTeam;
    }

    /**
     * Returns the boolean state of iisDldTeam
     *
     * @return bool
     */
    public function IsDldTeam()
    {
        return $this->isDldTeam;
    }

    /**
     * Returns the amazingSpeakerSortOrder
     *
     * @return int $amazingSpeakerSortOrder
     */
    public function getAmazingSpeakerSortOrder()
    {
        return $this->amazingSpeakerSortOrder;
    }

    /**
     * Sets the amazingSpeakerSortOrder
     *
     * @param int $amazingSpeakerSortOrder
     * @return void
     */
    public function setAmazingSpeakerSortOrder($amazingSpeakerSortOrder)
    {
        $this->amazingSpeakerSortOrder = $amazingSpeakerSortOrder;
    }

    /**
     * Returns the gender
     *
     * @return int $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the gender
     *
     * @param int $gender
     * @return void
     */
    public function setgender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('saltedpasswords')) {
            $saltedpasswordsInstance = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance();
            $encryptedPassword = $saltedpasswordsInstance->getHashedPassword($password);
            $this->password = $encryptedPassword;
        } else {
            parent::setPassword($password);
        }
    }
    /**
     * Returns the biography
     *
     * @return string $biography
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Sets the biography
     *
     * @param string $biography
     * @return void
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }
    /**
     * Returns the highrisePersonId
     *
     * @return int $highrisePersonId
     */

    public function getHighrisePersonId()
    {
        return $this->highrisePersonId;
    }

    /**
     * Sets the highrisePersonId
     *
     * @param int $highrisePersonId
     * @return void
     */
    public function setHighrisePersonId($highrisePersonId)
    {
        $this->highrisePersonId = $highrisePersonId;
    }

    /**
     * Returns the youtubevideos
     *
     * @return string $youtubevideos
     */
    public function getYoutubeVideos()
    {
        return $this->youtubevideos;
    }

    /**
     * Sets the youtubevideos
     *
     * @param string $youtubevideos
     * @return void
     */
    public function setYoutubeVideos($youtubevideos)
    {
        $this->youtubevideos = $youtubevideos;
    }

}