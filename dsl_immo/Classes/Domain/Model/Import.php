<?php
namespace DslFactory\DslImmo\Domain\Model;

/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * Import
 */
class Import extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $crdate = null;

    /**
     * type
     * 
     * @var int
     */
    protected $type = 0;

    /**
     * datei
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $datei = null;

    /**
     * Returns the type
     * 
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     * 
     * @param int $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the datei
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $datei
     */
    public function getDatei()
    {
        return $this->datei;
    }

    /**
     * Sets the datei
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $datei
     * @return void
     */
    public function setDatei(\TYPO3\CMS\Extbase\Domain\Model\FileReference $datei)
    {
        $this->datei = $datei;
    }

    /**
     * Returns the crdate
     * 
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

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

    }
}
