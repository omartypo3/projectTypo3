<?php

namespace Emagineurs\EGmap\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Emagineurs\EGmap\Domain\Repository\CategoryRepository;
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
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images = null;

    /**
     * @var \Emagineurs\EGmap\Domain\Model\Category|NULL
     * 
     */
    protected $parentcategory = null;

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images)
    {
        $this->images = $images;
    }

    /**
     * Returns the marker icon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $iconmarker
     */
    public function getIconmarker()
    {
        if (!empty($this->images)) {
            return $this->images;
        }

        $parentcategory = $this->getParentcategory();
        if ($parentcategory !== null) {
            return $parentcategory->getIconmarker();
        }

        return $this->images;
    }

    /**
     * Gets the parentcategory category.
     *
     * @return \Emagineurs\EGmap\Domain\Model\Category|NULL the parentcategory category
     * @api
     */
    public function getParentcategory()
    {
        if ($this->parentcategory instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->parentcategory->_loadRealInstance();
        }
        return $this->parentcategory;
    }

    /**
     * Sets the parentcategory category.
     *
     * @param \Emagineurs\EGmap\Domain\Model\Category $parentcategory the parentcategory category
     * @return void
     * @api
     */
    public function setParentcategory(\Emagineurs\EGmap\Domain\Model\Category $parentcategory)
    {
        $this->parentcategory = $parentcategory;
    }

    /**
     * Returns the childrens cat
     *
     * @return array
     */
    public function getChildren()
    {
        /** @var CategoryRepository $catRepo */
        $catRepo = GeneralUtility::makeInstance(CategoryRepository::class);
        return $catRepo->findChildren($this->getUid());
    }

}