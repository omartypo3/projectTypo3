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
 * Maschine
 */
class Maschine extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * teasertext
     *
     * @var string
     */
    protected $teasertext = '';

    /**
     * vorschaugrafik
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $vorschaugrafik = null;

    /**
     * elemente
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschinenelemente>
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
     * Returns the teasertext
     *
     * @return string $teasertext
     */
    public function getTeasertext()
    {
        return $this->teasertext;
    }

    /**
     * Sets the teasertext
     *
     * @param string $teasertext
     * @return void
     */
    public function setTeasertext($teasertext)
    {
        $this->teasertext = $teasertext;
    }

    /**
     * Returns the vorschaugrafik
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $vorschaugrafik
     */
    public function getVorschaugrafik()
    {
        return $this->vorschaugrafik;
    }

    /**
     * Sets the vorschaugrafik
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $vorschaugrafik
     * @return void
     */
    public function setVorschaugrafik(\TYPO3\CMS\Extbase\Domain\Model\FileReference $vorschaugrafik)
    {
        $this->vorschaugrafik = $vorschaugrafik;
    }

    /**
     * Adds a Maschinenelemente
     *
     * @param \J77\J77products\Domain\Model\Maschinenelemente $elemente
     * @return void
     */
    public function addElemente(\J77\J77products\Domain\Model\Maschinenelemente $elemente)
    {
        $this->elemente->attach($elemente);
    }

    /**
     * Removes a Maschinenelemente
     *
     * @param \J77\J77products\Domain\Model\Maschinenelemente $elementeToRemove The Maschinenelemente to be removed
     * @return void
     */
    public function removeElemente(\J77\J77products\Domain\Model\Maschinenelemente $elementeToRemove)
    {
        $this->elemente->detach($elementeToRemove);
    }

    /**
     * Returns the elemente
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschinenelemente> $elemente
     */
    public function getElemente()
    {
        return $this->elemente;
    }

    /**
     * Sets the elemente
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\J77\J77products\Domain\Model\Maschinenelemente> $elemente
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


}
