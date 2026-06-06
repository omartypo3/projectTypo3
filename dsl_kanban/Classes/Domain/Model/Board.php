<?php
namespace DslFactory\DslKanban\Domain\Model;

/***
 *
 * This file is part of the "Kanban" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 mz@dsl-factory.de <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * Board
 */
class Board extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * kuerzel
     *
     * @var string
     */
    protected $kuerzel = '';

    /**
     * Boardtitel
     *
     * @var string
     */
    protected $titel = '';

    /**
     * fixiert
     *
     * @var bool
     */
    protected $fixiert = false;

    /**
     * items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $items = null;

    //entfernt durch mike@cascade remove
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
     * Returns the fixiert
     *
     * @return bool $fixiert
     */
    public function getFixiert()
    {
        return $this->fixiert;
    }

    /**
     * Sets the fixiert
     *
     * @param bool $fixiert
     * @return void
     */
    public function setFixiert($fixiert)
    {
        $this->fixiert = $fixiert;
    }

    /**
     * Returns the boolean state of fixiert
     *
     * @return bool
     */
    public function isFixiert()
    {
        return $this->fixiert;
    }

    /**
     * Returns the kuerzel
     *
     * @return string $kuerzel
     */
    public function getKuerzel()
    {
        return $this->kuerzel;
    }

    /**
     * Sets the kuerzel
     *
     * @param string $kuerzel
     * @return void
     */
    public function setKuerzel($kuerzel)
    {
        $this->kuerzel = $kuerzel;
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
        $this->items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Item
     *
     * @param \DslFactory\DslKanban\Domain\Model\Item $item
     * @return void
     */
    public function addItem(\DslFactory\DslKanban\Domain\Model\Item $item)
    {
        $this->items->attach($item);
    }

    /**
     * Removes a Item
     *
     * @param \DslFactory\DslKanban\Domain\Model\Item $itemToRemove The Item to be removed
     * @return void
     */
    public function removeItem(\DslFactory\DslKanban\Domain\Model\Item $itemToRemove)
    {
        $this->items->detach($itemToRemove);
    }

    /**
     * Returns the items
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item> $items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets the items
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item> $items
     * @return void
     */
    public function setItems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $items)
    {
        $this->items = $items;
    }
}
