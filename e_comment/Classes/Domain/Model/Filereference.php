<?php
namespace Emagineurs\EComment\Domain\Model;

class Filereference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $size;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $alternative;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var bool
     */
    protected $showinpreview;

    /**
     * Set File uid
     *
     * @param int $fileUid
     */
    public function setFileUid($fileUid)
    {
        $this->uidLocal = $fileUid;
    }

    /**
     * Get File UID
     *
     * @return int
     */
    public function getFileUid()
    {
        return $this->uidLocal;
    }

    /**
     * Set alternative
     *
     * @param string $alternative
     */
    public function setAlternative($alternative)
    {
        $this->alternative = $alternative;
    }

    /**
     * Get alternative
     *
     * @return string
     */
    public function getAlternative()
    {
        return $this->alternative !== null ? $this->alternative : $this->getOriginalResource()->getAlternative();
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description !== null ? $this->description : $this->getOriginalResource()->getDescription();
    }

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->link !== null ? $this->link : $this->getOriginalResource()->getLink();
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title !== null ? $this->title : $this->getOriginalResource()->getTitle();
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Set showinpreview
     *
     * @param bool $showinpreview
     */
    public function setShowinpreview($showinpreview)
    {
        $this->showinpreview = $showinpreview;
    }

    /**
     * Get showinpreview
     *
     * @return bool
     */
    public function getShowinpreview()
    {
        return $this->showinpreview;
    }
}