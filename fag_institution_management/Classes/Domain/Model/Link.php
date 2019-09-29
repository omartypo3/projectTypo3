<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***
 *
 * This file is part of the "FRONTAL/ Online-Schalter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Patrick Crausaz <info@frontal.ch>, Agentur Frontal AG
 *
 ***/

/**
 * Link
 */
class Link extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * linkType
     * @var integer
     */
    protected $linkType = 0;

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * linkTarget
     *
     * @var string
     */
    protected $linkTarget = '';

    /**
     * linkDownload
     *
     * @var string
     */
    protected $linkDownload = '';

    /**
     * linkDownloadIcon
     *
     * @var string
     */
    protected $linkDownloadIcon = 'pdf';

    /**
     * linkForm
     *
     * @var string
     */
    protected $linkForm = '';

    /**
     * pirce
     *
     * @var double
     */
    protected $price;

    /**
     * sys_categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
     * Returns the link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Returns the linkDownload
     *
     * @return string $linkDownload
     */
    public function getLinkDownload()
    {
        return $this->linkDownload;
    }

    /**
     * Sets the linkDownload
     *
     * @param string $linkDownload
     * @return void
     */
    public function setLinkDownload($linkDownload)
    {
        $this->linkDownload = $linkDownload;
    }

    /**
     * Returns the linkForm
     *
     * @return string $linkForm
     */
    public function getLinkForm()
    {
        return $this->linkForm;
    }

    /**
     * Sets the linkForm
     *
     * @param string $linkForm
     * @return void
     */
    public function setLinkForm($linkForm)
    {
        $this->linkForm = $linkForm;
    }

    /**
     * Adds a
     *
     * @param  $category
     * @return void
     */
    public function addCategory($category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a
     *
     * @param $categoryToRemove The  to be removed
     * @return void
     */
    public function removeCategory($categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }
 
    /**
    * Gets the linkTarget.
    *
    * @return string
    */
    public function getLinkTarget(){
        return $this->linkTarget;
    }
     
    /**
    * Sets the linkTarget.
    *
    * @param string $linkTarget the link target
    */
    public function setLinkTarget($linkTarget){
        $this->linkTarget = $linkTarget;
    }
    
 
    /**
    * Gets the linkDownloadIcon.
    *
    * @return string
    */
    public function getLinkDownloadIcon(){
        return $this->linkDownloadIcon;
    }
     
    /**
    * Sets the linkDownloadIcon.
    *
    * @param string $linkDownloadIcon the link download icon
    */
    public function setLinkDownloadIcon($linkDownloadIcon){
        $this->linkDownloadIcon = $linkDownloadIcon;
    }
    
 
    /**
    * Gets the pirce.
    *
    * @return double
    */
    public function getPrice(){
        return $this->price;
    }
     
    /**
    * Sets the pirce.
    *
    * @param double $price the price
    */
    public function setPrice($price){
        $this->price = $price;
    }
    
 
    /**
    * Gets the linkType.
    *
    * @return integer
    */
    public function getLinkType(){
        return $this->linkType;
    }
     
    /**
    * Sets the linkType.
    *
    * @param integer $linkType the link type
    */
    public function setLinkType($linkType){
        $this->linkType = $linkType;
    }
    
}
