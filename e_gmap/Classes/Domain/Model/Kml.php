<?php

namespace Emagineurs\EGmap\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Kml
 */
class Kml extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * picto
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $picto = null;

    /**
     * file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $file = null;

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * note
     *
     * @var string
     */
    protected $note = '';

    /**
     * category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category>
     */
    protected $category = null;

    /**
     * __construct
     *
     * @return Diapos
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the picto
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $picto
     */
    public function getPicto()
    {
        return $this->picto;
    }

    /**
     * Sets the picto
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $picto
     * @return void
     */
    public function setPicto(\TYPO3\CMS\Extbase\Domain\Model\FileReference $picto)
    {
        $this->picto = $picto;
    }

    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->file = $file;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Sets the note
     *
     * @param string $note
     * @return void
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Returns the category
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category> $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EGmap\Domain\Model\Category> $category
     * @return void
     */
    public function setCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $category)
    {
        $this->category = $category;
    }


    /**
     * Returns the kmlfile
     *
     * @return string $kmlfile
     */
    public function getKmlfile()
    {
        if (!empty($this->file)) {
            $file = $this->file->getOriginalResource()->getPublicUrl();
            return \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $file;
        }

        return $this->url;
    }
}