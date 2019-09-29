<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 06.08.2018
 * Time: 11:46
 */

namespace Pingag\PingagJobs\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Vacancy extends AbstractEntity
{
    /** @var string */
    protected $validFrom;
    /** @var string */
    protected $title;
    /** @var string */
    protected $intro;
    /** @var string */
    protected $tasks;
    /** @var string */
    protected $profile;
    /** @var string */
    protected $offer;
    /** @var string */
    protected $location;
    /** @var string */
    protected $contact;
    /** @var string */
    protected $importId;
    /** @var string */
    protected $applyFormUrl;
    /** @var int */
    protected $detailPid;
    
    /**
     * @var \Pingag\PingagJobs\Domain\Model\PropertyType
     */
    protected $type;
    
    /**
     * @var \Pingag\PingagJobs\Domain\Model\PropertySection
     */
    protected $section;

    /**
     * @var \Pingag\PingagJobs\Domain\Model\PropertyCity
     */
    protected $city;

    /**
     * @return string
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * @param string $validFrom
     * @return $this
     */
    public function setValidFrom($validFrom)
    {
        $this->validFrom = $validFrom;
        return $this;
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @param string $intro
     * @return $this
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
        return $this;
    }

    /**
     * @return string
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param string $tasks
     * @return $this
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return string
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param string $offer
     * @return $this
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportId()
    {
        return $this->importId;
    }

    /**
     * @param string $importId
     * @return $this
     */
    public function setImportId($importId)
    {
        $this->importId = $importId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getApplyFormUrl()
    {
        return $this->applyFormUrl;
    }

    /**
     * @param string $applyFormUrl
     * @return $this
     */
    public function setApplyFormUrl($applyFormUrl)
    {
        $this->applyFormUrl = $applyFormUrl;
        return $this;
    }

    /**
     * @return PropertyType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param PropertyType $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return PropertySection
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param PropertySection $section
     * @return $this
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return PropertyCity
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param PropertyCity $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return int
     */
    public function getDetailPid()
    {
        return $this->detailPid;
    }

    /**
     * @param int $detailPid
     * @return $this
     */
    public function setDetailPid($detailPid)
    {
        $this->detailPid = $detailPid;
        return $this;
    }
}