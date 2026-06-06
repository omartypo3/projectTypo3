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
 * Item
 */
class Item extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * relationName
     *
     * @var string
     */
    protected $relationName = '';

    /**
     * relation
     */
    protected $relationModel = '';

    /**
     * titel
     *
     * @var string
     */
    protected $titel = '';

    /**
     * untertitel
     *
     * @var string
     */
    protected $untertitel = '';

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz = '';

    /**
     * relation
     *
     * @var string
     */
    protected $relation = '';

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
     * Returns the untertitel
     *
     * @return string $untertitel
     */
    public function getUntertitel()
    {
        return $this->untertitel;
    }

    /**
     * Sets the untertitel
     *
     * @param string $untertitel
     * @return void
     */
    public function setUntertitel($untertitel)
    {
        $this->untertitel = $untertitel;
    }

    /**
     * Returns the notiz
     *
     * @return string $notiz
     */
    public function getNotiz()
    {
        return $this->notiz;
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz($notiz)
    {
        $this->notiz = $notiz;
    }

    /**
     * Returns the relation
     *
     * @return string $relation
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Sets the relation
     *
     * @param string $relation
     * @return void
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    /**
     * Returns the relationName
     *
     * @return string $relatioNname
     */
    public function getRelationName()
    {
        return $this->relationName;
    }

    /**
     * Sets the relationName
     *
     * @param string $relationName
     * @return void
     */
    public function setRelationName($relationName)
    {
        $this->relationName = $relationName;
    }

    /**
     * Returns the relation
     *
     * @return $relationModel
     */
    public function getRelationModel()
    {
        return $this->relationModel;
    }

    /**
     * Sets the relation
     *
     * @param $relationModel
     * @return void
     */
    public function setRelationModel($relationModel)
    {
        $this->relationModel = $relationModel;
    }
}
