<?php
namespace Emagineurs\EGestiondocs\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Emagineurs\EGestiondocs\Domain\Repository\CategoryRepository;

class Filter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * Keywords
     *
     * @var string
     */
    protected $keywords;

    /**
     * Keywords fields
     *
     * @var array
     */
    protected $keywordsFields;

    /**
     * Folder
     *
     * @var array
     */
    protected $folder;


    /**
     * Folderstring
     *
     * @var string
     */
    protected $folderstring;

    /**
     * Files
     *
     * @var array
     */
    protected $files;

    /**
     * Folder
     *
     * @var boolean
     */
    protected $recursiveFind;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * Category
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\Category
     */
    protected $category;

    /**
     * Minimum time
     *
     * @var \DateTime
     */
    protected $minDatetime;

    /**
     * Limit
     *
     * @var integer
     */
    protected $limit;

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
     * Offset
     *
     * @var integer
     */
    protected $offset;

    /**
     * Item per page
     *
     * @var integer
     */
    protected $itemsPerPage;

    /**
     * Image format, 1 for landscape, 2 for portrait, 3 for square
     *
     * @var integer
     */
    protected $imageFormat;

    const IMAGE_FORMAT_LANDSCAPE = 1;
    const IMAGE_FORMAT_PORTRAIT = 2;
    const IMAGE_FORMAT_SQUARE = 3;

    /**
     * Complete filter data with flexform settings
     *
     * @param array $settings Plugin settings array
     */
    public function completeWithSettings($settings)
    {
        $folderSetting = $settings['folder'] ?? '';
        $this->setFolder(!empty($this->getFolder()) ? $this->getFolder() : explode(',', $folderSetting));
        
        $this->setRecursiveFind(!empty($settings['recursiveFind']) AND $settings['recursiveFind']);
        
        $keywordsFieldsSetting = $settings['keywordsFields'] ?? 'title,description,alternative';
        $this->setKeywordsFields(explode(',', $keywordsFieldsSetting));
        
        $limitSetting = $settings['limit'] ?? 0;
        $this->setLimit(!empty($this->getLimit()) ? $this->getLimit() : (!empty(intval($limitSetting)) ? intval($limitSetting) : false));

        if(empty($this->getCategories()) AND !empty($settings['categories'])) {
            /** @var CategoryRepository $categoryRepository */
            $categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class);

            $query = $categoryRepository->createQuery();
            $query->matching($query->in('uid', explode(',', $settings['categories'])));

            $result = $query->execute();
            $objectStorage = self::fillObjectStorageFromQueryResult($result);

            $this->setCategories($objectStorage);
        }

        if(!empty($settings['orderBy']) AND empty($this->getOrderBy())) {
            $this->setOrderBy($settings['orderBy']);
            $this->setOrderDirection($settings['orderDirection'] ?? 'asc');
        }
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return array
     */
    public function getKeywordsFields()
    {
        return $this->keywordsFields;
    }

    /**
     * @param array $keywordsFields
     */
    public function setKeywordsFields($keywordsFields)
    {
        $this->keywordsFields = $keywordsFields;
    }

    /**
     * @return array
     */
    public function getFolder()
    {
        return $this->folder ?? [];
    }

    /**
     * @param array $folder
     */
    public function setFolder($folder)
    {
        $this->folder = is_array($folder) ? $folder : [];
    }

    /**
     * @return string
     */
    public function getFolderstring()
    {
        return $this->folderstring;
    }

    /**
     * @param string $folder
     */
    public function setFolderstring($folderstring)
    {
        $this->folderstring = $folderstring;
    }



    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return bool
     */
    public function getRecursiveFind()
    {
        return $this->recursiveFind;
    }

    /**
     * @param bool $recursiveFind
     */
    public function setRecursiveFind($recursiveFind)
    {
        $this->recursiveFind = $recursiveFind;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     */
    public function setCategory($category)
    {
        if(!empty($category)) {
            $array = array($category);
            $objectStorage = self::fillObjectStorageFromQueryResult($array);
            $this->setCategories($objectStorage);

            $this->category = $category;
        }
    }

    /**
     * @return \DateTime
     */
    public function getMinDatetime()
    {
        return $this->minDatetime;
    }

    /**
     * @param \DateTime $minDatetime
     */
    public function setMinDatetime($minDatetime)
    {
        $this->minDatetime = $minDatetime;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
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

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    /**
     * @param int $imageFormat
     */
    public function setImageFormat($imageFormat)
    {
        $this->imageFormat = $imageFormat;
    }

    /**
     * @return bool
     */
    public function isSearch()
    {
        return !empty($this->getKeywords()) OR !empty($this->getFolder()) OR !empty($this->getCategories() OR !empty($this->getImageFormat()));
    }

    /**
     * Fill objectStorage from QueryResult
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $queryResult
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected static function fillObjectStorageFromQueryResult($queryResult = NULL) {
        /* @var $objectStorage \TYPO3\CMS\Extbase\Persistence\ObjectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);

        if (NULL!==$queryResult) {
            foreach($queryResult AS $object) {
                $objectStorage->attach($object);
            }
        }

        return $objectStorage;
    }
}