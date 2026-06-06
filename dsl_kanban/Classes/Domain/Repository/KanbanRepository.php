<?php
namespace DslFactory\DslKanban\Domain\Repository;

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
 * The repository for Kanbans
 */
class KanbanRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param string $titel
     */
    public function findByTitel($titel)
    {
        // echo "KanbanRepository->findByTitel(".$titel.")<br>";
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($query->equals('titel', $titel)));
        //$query->matching();//$query->equals('titel', $titel)
        //echo "KanbanRepository beforeexecute<br>";
        //  $posts = $query->execute();
        //echo "KanbanRepository beforegetfirst<br>";
        return $query->execute()->getFirst();
    }
}
