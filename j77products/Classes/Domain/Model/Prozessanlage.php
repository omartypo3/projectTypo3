<?php
namespace J77\J77products\Domain\Model;

/***
 *
 * This file is part of the "Produkte" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * Prozessanlage
 */
class Prozessanlage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * element
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * teaserbild
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $teaserbild = null;

    /**
     * elemente
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Anlagenelemente>
     * @cascade remove
     */
    protected $elemente = null;

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
        $this->elemente = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
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
     * Returns the teaserbild
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserbild
     */
    public function getTeaserbild()
    {
        return $this->teaserbild;
    }

    /**
     * Sets the teaserbild
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserbild
     * @return void
     */
    public function setTeaserbild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserbild)
    {
        $this->teaserbild = $teaserbild;
    }

    /**
     * Adds a Anlagenelemente
     *
     * @param \J77\J77products\Domain\Model\Anlagenelemente $elemente
     * @return void
     */
    public function addElemente(\J77\J77products\Domain\Model\Anlagenelemente $elemente)
    {
        $this->elemente->attach($elemente);
    }

    /**
     * Removes a Anlagenelemente
     *
     * @param \J77\J77products\Domain\Model\Anlagenelemente $elementeToRemove The Anlagenelemente to be removed
     * @return void
     */
    public function removeElemente(\J77\J77products\Domain\Model\Anlagenelemente $elementeToRemove)
    {
        $this->elemente->detach($elementeToRemove);
    }

    /**
     * Returns the elemente
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Anlagenelemente> $elemente
     */
    public function getElemente()
    {
        return $this->elemente;
    }

    /**
     * Sets the elemente
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Anlagenelemente> $elemente
     * @return void
     */
    public function setElemente(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $elemente)
    {
        $this->elemente = $elemente;
    }

   	/**
	 * Variable detailseite
	 *
	 * @var string
	 */
	protected $detailseite = NULL;

	/**
	 * Returns the detailseite
	 *
	 * @return string $detailseite
	 */
	public function getDetailseite() {
		return $this->detailseite;
	}

	/**
	 * Sets the detailseite
	 *
	 * @param string $detailseite
	 * @return void
	 */
	public function setDetailseite($detailseite) {
		$this->detailseite = $detailseite;
	}
	
	
	/**
	 * Variable category
	 *
	 * @var \J77\J77products\Domain\Model\Category
	 */
	protected $category = NULL;
	
	/**
	 * Returns the category
	 *
	 * @return \J77\J77products\Domain\Model\Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \J77\J77products\Domain\Model\Category $category
	 * @return void
	 */
	public function setCategory($category) {
		$this->category = $category;
	}
	

}
