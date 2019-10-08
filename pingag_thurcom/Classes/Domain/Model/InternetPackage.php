<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 23.08.2017
 * Time: 15:05
 */

namespace Pingag\PingagThurcom\Domain\Model;

class InternetPackage extends BaseProduct implements ProductInterface
{
    /**
     * @var string
     */
    protected $downloadSpeed;
    /**
     * @var string
     */
    protected $uploadSpeed;
	/**
     * @var string
     */
    protected $speedvalue;
	/**
     * @var string
     */
    protected $speedtext;
    /**
     * @var string
     */
    protected $detailText;
    /**
     * @var string
     */
    protected $shortcut;
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\GeorgRinger\News\Domain\Model\FileReference>
     * @lazy
     */
    protected $image;

    /**
     * @var bool
     */
    protected $default;

    /**
     * @return string
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * @param string $downloadSpeed
     * @return $this
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;
        return $this;
    }

    /**
     * @return string
     */
    public function getUploadSpeed()
    {
        return $this->uploadSpeed;
    }

    /**
     * @param string $uploadSpeed
     * @return $this
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getSpeedvalue()
    {
        return $this->speedvalue;
    }

    /**
     * @param string $speedvalue
     * @return $this
     */
    public function setSpeedvalue($speedvalue)
    {
        $this->speedvalue = $speedvalue;
        return $this;
    }
	
	/**
     * @return string
     */
    public function getSpeedtext()
    {
        return $this->speedtext;
    }

    /**
     * @param string $speedtext
     * @return $this
     */
    public function setSpeedtext($speedtext)
    {
        $this->speedtext = $speedtext;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetailText()
    {
        return $this->detailText;
    }

    /**
     * @param mixed $detailText
     * @return $this
     */
    public function setDetailText($detailText)
    {
        $this->detailText = $detailText;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * @param string $shortcut
     * @return $this
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;
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
     * @return bool
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }
}