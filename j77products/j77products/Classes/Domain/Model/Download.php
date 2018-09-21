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
 * Download
 */
class Download extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * element
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * titel
     *
     * @var string
     */
    protected $titel = '';

    /**
     * datei
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $datei = null;

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
}
