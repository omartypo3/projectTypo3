<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 14.08.2017
 * Time: 09:49
 */
class Channel extends BaseEntity
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $lang;

    /** @var string */
    protected $icon;
	
	/** @var string */
    protected $description;
	
	/** @var string */
    protected $frequency;
	
	/** @var string */
    protected $url;
	
	/** @var string */
    protected $hbb;
	
	/** @var string */
    protected $hd;
	
	/** @var string */
    protected $dolby;

	/**
     * @var \Pingag\PingagThurcom\Domain\Model\ChannelPackage
     * @lazy
     */
    protected $packages;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\Category>
     * @lazy
     */
    protected $categories;

    public function __construct()
    {
        $this->icon = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
	
	/**
     * @return Packages
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param Packages $packages
     * @return $this
     */
    public function setPackage($packages)
    {
        $this->packages = $packages;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
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
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param string $frequency
     * @return $this
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getHbb()
    {
        return $this->hbb;
    }

    /**
     * @param string $hbb
     * @return $this
     */
    public function setHbb($hbb)
    {
        $this->hbb = $hbb;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getHd()
    {
        return $this->hd;
    }

    /**
     * @param string $hd
     * @return $this
     */
    public function setHd($hd)
    {
        $this->hd = $hd;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getDolby()
    {
        return $this->dolby;
    }

    /**
     * @param string $dolby
     * @return $this
     */
    public function setDolby($dolby)
    {
        $this->dolby = $dolby;
        return $this;
    }
}