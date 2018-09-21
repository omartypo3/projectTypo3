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
 * Icon
 */
class Icon extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * element
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * icon
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $icon = null;

    /**
     * titel
     *
     * @var string
     */
    protected $titel = '';

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
     * Returns the titel
     *
     * @return string $titel
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Sets the titel
     *
     * @param string $titel
     * @return void
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }
}
