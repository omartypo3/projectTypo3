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
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Anhang
 */
class Anhang extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $crdate = null;

    /**
     * @var int
     */
    protected $tstamp = null;

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
     * Returns the tstamp
     * 
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }
}
