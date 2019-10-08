<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 17.08.2017
 * Time: 14:01
 */
class ProductConsultation extends BaseEntity
{
	/** @var string */
    protected $title;
	
    /** @var string */
    protected $abo;

	/** @var string */
    protected $living;
	
	/** @var string */
    protected $internet;
	
	/** @var string */
    protected $tv;
	
	/** @var string */
    protected $phone;
	
	/** @var string */
    protected $group;
	
	/** @var string */
    protected $television;
	
	/** @var string */
    protected $telephone;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\FileReference>
     * @lazy
     */
    protected $image;

    public function __construct()
    {
        $this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
    public function getAbo()
    {
        return $this->abo;
    }

    /**
     * @param string $abo
     * @return $this
     */
    public function setAbo($abo)
    {
        $this->abo = $abo;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getLiving()
    {
        return $this->living;
    }

    /**
     * @param string $living
     * @return $this
     */
    public function setLiving($living)
    {
        $this->living = $living;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * @param string $internet
     * @return $this
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * @param string $tv
     * @return $this
     */
    public function setTv($tv)
    {
        $this->tv = $tv;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getTelevision()
    {
        return $this->television;
    }

    /**
     * @param string $television
     * @return $this
     */
    public function setTelevision($television)
    {
        $this->television = $television;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }
}