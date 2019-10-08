<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 14.08.2017
 * Time: 09:49
 */
class ChannelPackage extends BaseEntity
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $price;

    /** @var string */
    protected $channels;
	
	/** @var string */
    protected $section;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param string $channels
     * @return $this
     */
    public function setChannels($channels)
    {
        $this->channels = $channels;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     * @return $this
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }
}