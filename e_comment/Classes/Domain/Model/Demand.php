<?php
namespace Emagineurs\EComment\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Demand extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * Search keywords
     *
     * @var string
     */
    protected $searchKeywords;

	/**
	 * Search fields
	 *
	 * @var string|array|null
	 */
	protected $searchFields;

    /**
     * Categories
     *
     * @var ObjectStorage<Category>|null
     */
    protected $categories = null;

    /**
     * Selected category
     *
     * @var Category|null
     */
    protected $category;

    /**
     * Storage pid
     *
     * @var string
     */
    protected $storagePid;

    /**
     * Search into children
     *
     * @var boolean
     */
    protected $recursiveSearch;

    /**
     * paramfilter
     *
     * @var string
     */
    protected $paramfilter;

    /**
     * paramvalue
     *
     * @var string
     */
    protected $paramvalue;

    /**
     * Order by
     *
     * @var string
     */
    protected $orderBy;

    /**
     * Order direction
     *
     * @var string
     */
    protected $orderDirection;

    /**
     * Complete filter data with flexform settings
     *
     * @param array $settings Plugin settings array
     */
    public function completeWithSettings($settings)
    {
        /*$this->setFolder(!empty($this->getFolder()) ? $this->getFolder() : $settings['folder']);
        $this->setRecursiveFind(!empty($settings['recursiveFind']) AND $settings['recursiveFind']);*/

        /*if(empty($this->getCategory()) AND !empty($settings['categories'])) {
            /** @var ObjectManager $objectManager *
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            /** @var CategoryRepository $categoryRepository *
            $categoryRepository = $objectManager->get(CategoryRepository::class);

            $query = $categoryRepository->createQuery();
            $query->matching($query->in('uid', explode(',', $settings['categories'])));

            $result = $query->execute();
            $objectStorage = self::fillObjectStorageFromQueryResult($result);

            $this->setCategories($objectStorage);
        }*/

        if (!empty($settings['categories'] ?? '') && $this->getCategories()->count() === 0) {
            $categoryUids = GeneralUtility::intExplode(',', (string)$settings['categories'], true);
            if (!empty($categoryUids)) {
                /** @var PersistenceManager $persistenceManager */
                $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                $categories = GeneralUtility::makeInstance(ObjectStorage::class);
                foreach ($categoryUids as $uid) {
                    $category = $persistenceManager->getObjectByIdentifier($uid, Category::class, false);
                    if ($category instanceof Category) {
                        $categories->attach($category);
                    }
                }
                if ($categories->count() > 0) {
                    $this->setCategories($categories);
                }
            }
        }

        if (!empty($settings['storagePid'])) {
            $this->setStoragePid($settings['storagePid']);
        }

        if (!empty($settings['orderBy']) && empty($this->getOrderBy())) {
            $this->setOrderBy($settings['orderBy']);
        }

        if (!empty($settings['orderDirection']) && empty($this->getOrderDirection())) {
            $this->setOrderDirection($settings['orderDirection']);
        }

        if (!empty($settings['filterByParam']) && !empty($settings['filterByValue'])) {
            $this->setParamfilter($settings['filterByParam']);
            $this->setParamvalue($settings['filterByValue']);
        }
    }

    /**
     * @return string
     */
    public function getSearchKeywords()
    {
        return $this->searchKeywords;
    }

    /**
     * @param string $searchKeywords
     */
    public function setSearchKeywords($searchKeywords)
    {
        $this->searchKeywords = $searchKeywords;
    }

    /**
     * @return array
     */
    public function getSearchFields()
    {
        if(is_array($this->searchFields)) {
            return $this->searchFields;
        } else {
            return explode(',', $this->searchFields);
        }
    }

    /**
     * @param string $searchFields
     */
    public function setSearchFields($searchFields)
    {
        $this->searchFields = $searchFields;
    }

    /**
     * @return Category|null
     */
    public function getCategory()
    {
        if ($this->category instanceof Category) {
            return $this->category;
        }
        $categories = $this->getCategories();
        if ($categories->count() > 0) {
            $categories->rewind();
            $first = $categories->current();
            if ($first instanceof Category) {
                return $first;
            }
        }
        return null;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        if ($category instanceof Category) {
            $this->getCategories()->attach($category);
        }
    }

    public function addCategory(Category $category): void
    {
        $this->getCategories()->attach($category);
        if ($this->category === null) {
            $this->category = $category;
        }
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ObjectStorage
    {
        if (!($this->categories instanceof ObjectStorage)) {
            $this->categories = GeneralUtility::makeInstance(ObjectStorage::class);
        }

        return $this->categories;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
        if ($categories->count() > 0) {
            $categories->rewind();
            $first = $categories->current();
            if ($first instanceof Category) {
                $this->category = $first;
            }
        }
    }

    /**
     * @return string
     */
    public function getStoragePid()
    {
        return $this->storagePid;
    }

    /**
     * @param mixed $storagePid
     */
    public function setStoragePid($storagePid)
    {
        if (is_array($storagePid)) {
            $pidList = $storagePid;
        } else {
            $pidList = GeneralUtility::trimExplode(',', (string)$storagePid, true);
        }

        $pidList = array_map(
            static function ($pid) {
                $pid = (string)$pid;
                if (str_starts_with($pid, 'pages_')) {
                    $pid = substr($pid, 6);
                }
                return (int)$pid;
            },
            $pidList
        );
        $pidList = array_filter($pidList, static fn ($pid) => $pid > 0);
        $this->storagePid = implode(',', $pidList);
    }

    /**
     * @return bool
     */
    public function getRecursiveSearch()
    {
        return $this->recursiveSearch;
    }

    /**
     * @param bool $recursiveSearch
     */
    public function setRecursiveSearch($recursiveSearch)
    {
        $this->recursiveSearch = $recursiveSearch;
    }

    /**
     * @return string
     */
    public function getParamfilter()
    {
        return $this->paramfilter;
    }

    /**
     * @param string $paramfilter
     */
    public function setParamfilter($paramfilter)
    {
        $this->paramfilter = $paramfilter;
    }

    /**
     * @return string
     */
    public function getParamvalue()
    {
        return $this->paramvalue;
    }

    /**
     * @param string $paramvalue
     */
    public function setParamvalue($paramvalue)
    {
        $this->paramvalue = $paramvalue;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * @param string $orderDirection
     */
    public function setOrderDirection($orderDirection)
    {
        $this->orderDirection = $orderDirection;
    }
}