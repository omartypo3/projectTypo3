<?php
namespace Emagineurs\EComment\Domain\Repository;

use Emagineurs\EComment\Domain\Model\Demand;
use Emagineurs\EComment\Domain\Model\Message;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class MessageRepository extends Repository
{


    
    
    /**
     * @param Message $object
     */
    public function add($object)
    {
        parent::add($object);
    }

    /**
     * @param Message $modifiedObject
     */
    public function update($modifiedObject)
    {
        parent::update($modifiedObject);
    }

    /**
     * @param Message $object
     */
    public function remove($object)
    {
        parent::remove($object);
    }

    /**
     * @param Demand $demand
     * @return QueryResultInterface
     */
    public function findByDemand(Demand $demand) {
        $query = $this->createQuery();

        $contraints = array();

        //Keywords
        if(!empty($demand->getSearchKeywords()) AND !empty($demand->getSearchFields())) {
            $keywordConstraints = array();
            //Search main message
            foreach($demand->getSearchFields() as $field) {
                $keywordConstraints[] = $query->like($field, '%' . $demand->getSearchKeywords() . '%');
            }

            //Search into children
            $childrenQuery = $this->createQuery();
            $childrenQuery->getQuerySettings()->setRespectStoragePage(false);

            $keywordChildrenConstraints = array();
            foreach($demand->getSearchFields() as $field) {
                $keywordChildrenConstraints[] = $childrenQuery->like($field, '%' . $demand->getSearchKeywords() . '%');
            }

            $childrenConstraints = [
                $childrenQuery->logicalNot($childrenQuery->equals('parent', '')),
                $childrenQuery->logicalOr(...$keywordChildrenConstraints),
                $childrenQuery->equals('validationtoken', '')
            ];
            $childrenQuery->matching($childrenQuery->logicalAnd(...$childrenConstraints));
            $matchingChildren = $childrenQuery->execute();

            if(!empty($matchingChildren)) {
                $keywordConstraints[] = $query->contains('children', $matchingChildren);
            }

            $contraints[] = $query->logicalOr(...$keywordConstraints);
        }

        //Categories
        $categoryConstraints = [];
        foreach ($demand->getCategories() as $category) {
            $categoryConstraints[] = $query->contains('categories', $category);
        }

        $singleCategory = $demand->getCategory();
        if ($singleCategory !== null) {
            $categoryConstraints[] = $query->contains('categories', $singleCategory);
        }

        if (!empty($categoryConstraints)) {
            $contraints[] = $query->logicalOr(...$categoryConstraints);
        }

        //Storage pid
        if(!empty($demand->getStoragePid())) {
            $pidList = array_filter(
                array_map('intval', explode(',', $demand->getStoragePid())),
                static fn($pid) => $pid > 0
            );
            if (!empty($pidList)) {
                $contraints[] = $query->in('pid', $pidList);
            }
        }

        //Unvalidated
        $contraints[] = $query->equals('validationtoken', '');

        //Only main message
        $contraints[] = $query->equals('parent', '');

        //Filter using param
        if(!empty($demand->getParamfilter()) AND !empty($demand->getParamvalue())) {
            $contraints[] = $query->equals('paramfilter', $demand->getParamfilter());
            $contraints[] = $query->equals('paramvalue', $demand->getParamvalue());
        } else {
            $contraints[] = $query->equals('paramfilter', '');
            $contraints[] = $query->equals('paramvalue', '');
        }

        if (!empty($contraints)) {
            $query->matching($query->logicalAnd(...$contraints));
        }



        //Ordering
        if(!empty($demand->getOrderBy())) {
            $query->setOrderings(array($demand->getOrderBy() => (($demand->getOrderDirection() != 'desc') ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING)));
        }

        $query->getQuerySettings()->setRespectStoragePage(false);


        return $query->execute();
    }

    /**
     * @param Message $message
     * @return QueryResultInterface
     */
    public function findReply(Message $message) {
        $query = $this->createQuery();

        $contraints = array();

        //Storage pid
        $messagePid = (int)ObjectAccess::getProperty($message, 'pid');
        if($messagePid > 0) {
            $contraints[] = $query->equals('pid', $messagePid);
        }

        //Unvalidated
        $contraints[] = $query->equals('validationtoken', '');

        //Only main message
        $contraints[] = $query->equals('parent', '');

        //Filter using param
        if(!empty($message->getParamfilter()) AND !empty($message->getParamvalue())) {
            $contraints[] = $query->equals('paramfilter', $message->getParamfilter());
            $contraints[] = $query->equals('paramvalue', $message->getParamvalue());
        } else {
            $contraints[] = $query->equals('paramfilter', '');
            $contraints[] = $query->equals('paramvalue', '');
        }

        if (!empty($contraints)) {
            $query->matching($query->logicalAnd(...$contraints));
        }

        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->execute();
    }

}