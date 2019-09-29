<?php
namespace Silcoplastproduct\SilcoplastProduct\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
/***
 *
 * This file is part of the "Silcoplast_Product" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
/**
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    
    /**
     * @var int
     */
    protected $sysLanguageUid;

    /**
     * @var int
     */
    protected $l10nParent;

    /**
     * @var Silcoplastproduct\SilcoplastProduct\Domain\Model\Category
     * @lazy
     */
    protected $parentcategory;

    /**
     * icong
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $icong = null;

    /**
     * icon
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $icon = null;
  
    
    /**
     * type
     *
     * @var string
     * @validate NotEmpty
     */
    protected $type = '';


    /**
     * Get sys language
     *
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->_languageUid;
    }

    /**
     * Set sys language
     *
     * @param int $sysLanguageUid language uid
     */
    public function setSysLanguageUid($sysLanguageUid)
    {
        $this->_languageUid = $sysLanguageUid;
    }

    /**
     * Get language parent
     *
     * @return int
     */
    public function getL10nParent()
    {
        return $this->l10nParent;
    }

    /**
     * Set language parent
     *
     * @param int $l10nParent l10nParent
     */
    public function setL10nParent($l10nParent)
    {
        $this->l10nParent = $l10nParent;
    }

    /**
     * Returns the icon
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     * @return void
     */
    public function setIcon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icon)
    {
        $this->icon = $icon;
    }

    /**
     * Returns the icong
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icong
     */
    public function getIcong()
    {
        return $this->icong;
    }

    /**
     * Sets the icong
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icong
     * @return void
     */
    public function setIcong(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icong)
    {
        $this->icong = $icong;
    }

    /**
     * Get parent category
     *
     * @return \Silcoplastproduct\SilcoplastProduct\Domain\Model\Category
     */
    public function getParentcategory()
    {
        return ($this->parentcategory instanceof LazyLoadingProxy ? $this->parentcategory->_loadRealInstance() : $this->parentcategory);
    }

    /**
     * Set parent category
     *
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Category $category parent category
     */
    public function setParentcategory(self $category)
    {
        $this->parentcategory = $category;
    }

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

    



}
