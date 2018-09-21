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
 * Partner
 */
class Partner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * logo
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     *
     */
    protected $logo = null;

    /**
     * country
     * 
     * @var string
     */
    protected $country = '';

    /**
     * city
     * 
     * @var string
     */
    protected $city = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

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
     * operationfield
     *
     * @var string
     */
    protected $operationfield = '';

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
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function setLogo( $logo)
    {
        $this->logo = $logo;
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
     * Returns the operationfield
     *
     * @return string $operationfield
     */
    public function getOperationfield() {
        return $this->operationfield;
    }

    /**
     * Sets the operationfield
     *
     * @param string $operationfield
     * @return void
     */
    public function setOperationfield($operationfield) {
        $this->operationfield = $operationfield;
    }
}
