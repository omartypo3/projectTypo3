<?php

namespace Pingag\PingagThurcom\Domain\Model;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 17.08.2017
 * Time: 13:44
 */
class SubscriptionOption extends BaseProduct implements ProductInterface
{

    /** @var string */
    protected $description;
    /** @var string */
    protected $detailText;
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\FileReference>
     * @lazy
     */
    protected $icon;
	/**
     * @var bool
     */
    protected $radiobutton;

	/**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\FileReference>
     * @lazy
     */
    protected $cornericon;
	
	/**
     * @var bool
     */
    protected $single;
	

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
    public function getDetailText()
    {
        return $this->detailText;
    }

    /**
     * @param string $detailText
     * @return $this
     */
    public function setDetailText($detailText)
    {
        $this->detailText = $detailText;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
	
	/**
     * @return bool
     */
    public function getRadiobutton()
    {
        return $this->radiobutton;
    }

    /**
     * @param bool $radiobutton
     * @return $this
     */
    public function setRadiobutton($radiobutton)
    {
        $this->radiobutton = $radiobutton;
        return $this;
    }
	/**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCornericon()
    {
        return $this->cornericon;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $icon
     * @return $this
     */
    public function setCornericon($cornericon)
    {
        $this->cornericon = $cornericon;
        return $this;
    }
	/**
     * @return bool
     */
    public function getSingle()
    {
        return $this->single;
    }

    /**
     * @param bool $single
     * @return $this
     */
    public function setSingle($single)
    {
        $this->single = $single;
        return $this;
    }
	
}