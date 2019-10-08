<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 09:14
 */
class SimpleServiceLocation extends BaseEntity
{

    /** @var string */
    protected $title;
    /** @var string */
    protected $description;

    /** @var string */
    protected $zip;
    /** @var string */
    protected $city;
	
	/** @var string */
    protected $changemodem;

    /** @var float */
    protected $lat;
    /** @var float */
    protected $lng;

    /**
     * ServiceLocation constructor.
     */
    public function __construct()
    {
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getChangemodem()
    {
        return $this->changemodem;
    }

    /**
     * @param float $changemodem
     * @return $this
     */
    public function setChangemodem($changemodem)
    {
        $this->changemodem = $changemodem;
        return $this;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return $this
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     * @return $this
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }
}