<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***
 *
 * This file is part of the "aaaaa" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 aaaaaa <chaari.ons93@gmail.com>
 *
 ***/

/**
 * Docs
 */
class Docs extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * doc
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $doc = null;

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the doc
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $doc
     */
    public function getDoc()
    {
        return $this->doc;
    }

    /**
     * Sets the doc
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $doc
     * @return void
     */
    public function setDoc(\TYPO3\CMS\Extbase\Domain\Model\FileReference $doc)
    {
        $this->doc = $doc;
    }
}
