<?php
namespace Silcoplastproduct\SilcoplastProduct\Domain\Model;


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
 * Categoryproduct
 */
class Categoryproduct extends \TYPO3\CMS\Extbase\Domain\Model\Category
{

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
     * Returns the icon
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * type
     *
     * @var string
     * @validate NotEmpty
     */
    protected $type = '';
    
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
