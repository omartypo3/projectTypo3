<?php
namespace DslFactory\DslJobs\Domain\Model;

/***
 *
 * This file is part of the "Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * JobSite
 */
class JobSite extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * jobsiteUid
     *
     * @var int
     */
    protected $jobsiteUid = 0;

    /**
     * company
     *
     * @var string
     */
    protected $company = '';

    /**
     * shortname
     *
     * @var string
     */
    protected $shortname = '';

    /**
     * country
     *
     * @var string
     */
    protected $country = '';

    /**
     * state
     *
     * @var string
     */
    protected $state = '';

    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * street
     *
     * @var string
     */
    protected $street = '';

    /**
     * streetnumber
     *
     * @var string
     */
    protected $streetnumber = '';

    /**
     * Returns the jobsiteUid
     *
     * @return int $jobsiteUid
     */
    public function getJobsiteUid()
    {
        return $this->jobsiteUid;
    }

    /**
     * Sets the jobsiteUid
     *
     * @param int $jobsiteUid
     * @return void
     */
    public function setJobsiteUid($jobsiteUid)
    {
        $this->jobsiteUid = $jobsiteUid;
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
     * Returns the shortname
     *
     * @return string $shortname
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Sets the shortname
     *
     * @param string $shortname
     * @return void
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;
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
     * Returns the state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets the state
     *
     * @param string $state
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
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
     * Returns the street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the streetnumber
     *
     * @return string $streetnumber
     */
    public function getStreetnumber()
    {
        return $this->streetnumber;
    }

    /**
     * Sets the streetnumber
     *
     * @param string $streetnumber
     * @return void
     */
    public function setStreetnumber($streetnumber)
    {
        $this->streetnumber = $streetnumber;
    }

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
}
