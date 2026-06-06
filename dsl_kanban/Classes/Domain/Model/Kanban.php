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
 * Kanban
 */
class Kanban extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * titel
     *
     * @var string
     */
    protected $titel = '';

    /**
     * board
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Board>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $board = null;

    /**
     * itemsAusgeblendet
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $itemsAusgeblendet = null;

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
        $this->board = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->itemsAusgeblendet = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Board
     *
     * @param \DslFactory\DslKanban\Domain\Model\Board $board
     * @return void
     */
    public function addBoard(\DslFactory\DslKanban\Domain\Model\Board $board)
    {
        $this->board->attach($board);
    }

    /**
     * Removes a Board
     *
     * @param \DslFactory\DslKanban\Domain\Model\Board $boardToRemove The Board to be removed
     * @return void
     */
    public function removeBoard(\DslFactory\DslKanban\Domain\Model\Board $boardToRemove)
    {
        $this->board->detach($boardToRemove);
    }

    /**
     * Returns the board
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Board> $board
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Sets the board
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Board> $board
     * @return void
     */
    public function setBoard(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $board)
    {
        $this->board = $board;
    }

    /**
     * Returns the boardByUid
     *
     * @param \integer $uid
     * @return \DslFactory\DslKanban\Domain\Model\Board $board
     */
    public function getBoardByUid($uid)
    {
        foreach($this->board as $item) if($uid == $item->getUid()) return $item;
        return NULL;
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
     * Adds a Item
     *
     * @param \DslFactory\DslKanban\Domain\Model\Item $itemsAusgeblendet
     * @return void
     */
    public function addItemsAusgeblendet(\DslFactory\DslKanban\Domain\Model\Item $itemsAusgeblendet)
    {
        $this->itemsAusgeblendet->attach($itemsAusgeblendet);
    }

    /**
     * Removes a Item
     *
     * @param \DslFactory\DslKanban\Domain\Model\Item $itemsAusgeblendetToRemove The Item to be removed
     * @return void
     */
    public function removeItemsAusgeblendet(\DslFactory\DslKanban\Domain\Model\Item $itemsAusgeblendetToRemove)
    {
        $this->itemsAusgeblendet->detach($itemsAusgeblendetToRemove);
    }

    /**
     * Returns the itemsAusgeblendet
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item> $itemsAusgeblendet
     */
    public function getItemsAusgeblendet()
    {
        return $this->itemsAusgeblendet;
    }

    /**
     * Returns the itemAusgeblendet
     *
     * @param \integer $uid
     * @return \DslFactory\DslKanban\Domain\Model\Item $itemAusgeblendet
     */
    public function getItemAusgeblendetByUid($uid)
    {
        foreach($this->itemsAusgeblendet as $item) if($uid == $item->getUid()) return $item;
        return NULL;
    }

    /**
     * Sets the itemsAusgeblendet
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslKanban\Domain\Model\Item> $itemsAusgeblendet
     * @return void
     */
    public function setItemsAusgeblendet(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $itemsAusgeblendet)
    {
        $this->itemsAusgeblendet = $itemsAusgeblendet;
    }

    /**
     * Move Board Before and return if changed
     *
     * @param \integer $boardUid
     * @param \integer $beforeUid
     * @return bool
     */
    public function moveBoardBefore($boardUid,$beforeBoardUid)
    {
        $completed = false;
        foreach($this->board as $board){

            if($board->getUid() == $boardUid) $boardToMove = $board;

        }
        if($boardToMove){
            $newBoards = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            foreach($this->board as $board){
                if($board->getUid() != $boardToMove->getUid()){
                    if($board->getUid()==$beforeBoardUid) {
                        $newBoards->attach($boardToMove);
                        $completed = true;
                    }
                    $newBoards->attach($board);
                }
            }
        }
        if($completed) {
            $this->setBoard($newBoards);
        }
        return $completed;
      
    }


    /**
     * Move Board To End and return if changed
     *
     * @param \integer $boardUid
     * @param \integer $beforeUid
     * @return bool
     */
    public function moveBoardToEnd($boardUid)
    {
        $completed = false;
        foreach($this->board as $board){

            if($board->getUid() == $boardUid) $boardToMove = $board;

        }
        if($boardToMove){
            $newBoards = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            foreach($this->board as $board){
                if($board->getUid() != $boardToMove->getUid()){
                    $newBoards->attach($board);
                }
            }
            $newBoards->attach($boardToMove);
            $completed = true;
        }
        if($completed) {
            $this->setBoard($newBoards);
        }
        return $completed;
      
    }
    


}
