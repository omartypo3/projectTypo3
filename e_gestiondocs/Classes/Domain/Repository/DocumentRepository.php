<?php
namespace Emagineurs\EGestiondocs\Domain\Repository;

use Emagineurs\EGestiondocs\Domain\Model\Filter;
use Emagineurs\EGestiondocs\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Resource\AbstractFile;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Frontend\DataProcessing\FilesProcessor;
class DocumentRepository
{
    /**
     * categoryRepository
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * resourceFactory
     *
     * @var ResourceFactory
     */
    protected $resourceFactory;

    /**
     * FilesProcessor
     *
     * @var FilesProcessor
     */
    protected $filesProcessor;

    /**
     * Constructor - dependency injection
     */
    public function __construct(CategoryRepository $categoryRepository, ResourceFactory $resourceFactory, FilesProcessor $filesProcessor)
    {
        $this->categoryRepository = $categoryRepository;
        $this->resourceFactory = $resourceFactory;
        $this->filesProcessor = $filesProcessor;
    }
    /**
     * @param Filter $filter
     * @return \TYPO3\CMS\Core\Resource\File[]
     */
    public function findByFilter(Filter $filter) {
		$resourceFactory = $this->resourceFactory;

        $documents = array();
        $files = $filter->getFiles();
        if(!empty($files) && is_array($files)) {
            foreach($files as $fileIdentifier) {
                $fileIdentifier = trim((string)$fileIdentifier);
                if($fileIdentifier === '') {
                    continue;
                }

                $documents[] = $resourceFactory->getFileObject($fileIdentifier);
            }
        } else {
            $folders = $filter->getFolder();
            if(!is_array($folders)) {
                $folders = array($folders);
            }

            $documents = array();
            foreach($folders as $folder) {
                $folder = $resourceFactory->getFolderObjectFromCombinedIdentifier($folder);
                $documents = array_merge($documents, $folder->getStorage()->getFilesInFolder($folder, 0, 0, false, $filter->getRecursiveFind()));
            }
        }

        //Filter by keywords
        if(!empty($filter->getKeywords())) {
            $keyword = strtolower($filter->getKeywords());

            $documents = array_filter($documents, function ($file) use ($keyword, $filter) {
                $keywordsFields = $filter->getKeywordsFields();
                if (empty($keywordsFields) || !is_array($keywordsFields)) {
                    $keywordsFields = ['title', 'description', 'alternative'];
                }
                
                foreach($keywordsFields as $field) {
                    $field = trim($field);
                    if (empty($field)) {
                        continue;
                    }
                    
                    $propertyValue = $file->getProperty($field);
                    if ($propertyValue !== null && strpos(strtolower((string)$propertyValue), $keyword) !== false) {
                        return true;
                    }
                }
                
                return false;
            });
        }

        //Filter by categories
        if(!empty($filter->getCategories())) {
            $documents = array_filter($documents, function ($file) use ($filter) {
                $fileCategories = $this->categoryRepository->findByFile($file);
                $expectedCategories = $filter->getCategories();

                if(!empty($fileCategories)) {
                    foreach($fileCategories as $fileCategory) {
                        foreach($expectedCategories as $expectedCategory) {
                            if($fileCategory->getUid() == $expectedCategory->getUid()) {
                                return true;
                            }
                        }
                    }
                }
                return false;
            });
        }

        //Filter by date
        if(!empty($filter->getMinDatetime())) {
            $documents = array_filter($documents, function ($file) use ($filter) {
                return $filter->getMinDatetime()->getTimestamp() <= $file->getCreationTime();
            });
        }

        //Filter by image format
        if(!empty($filter->getImageFormat())) {
            switch($filter->getImageFormat()) {
                case Filter::IMAGE_FORMAT_LANDSCAPE :
                    $documents = array_filter($documents, function ($file) use ($filter) {
                        return $file->getType() == AbstractFile::FILETYPE_IMAGE AND ($file->_getMetaData()['width'] / $file->_getMetaData()['height']) >= 1.2;
                    });
                    break;
                case Filter::IMAGE_FORMAT_PORTRAIT :
                    $documents = array_filter($documents, function ($file) use ($filter) {
                        return $file->getType() == AbstractFile::FILETYPE_IMAGE AND ($file->_getMetaData()['height'] / $file->_getMetaData()['width']) >= 1.2;
                    });
                    break;
                case Filter::IMAGE_FORMAT_SQUARE :
                    $documents = array_filter($documents, function ($file) use ($filter) {
                        return $file->getType() == AbstractFile::FILETYPE_IMAGE AND $file->_getMetaData()['width'] == $file->_getMetaData()['height'];
                    });
                    break;
            }
        }

        //Ordering
        if(!empty($filter->getOrderBy())) {
            usort($documents, function ($a, $b) use ($filter) {
                if($a->getProperty($filter->getOrderBy()) == $b->getProperty($filter->getOrderBy())) {
                    return 0;
                }

                //For extension, we group images together
                if($filter->getOrderBy() == 'extension') {
                    if($this->isImage($a) AND !$this->isImage($b)) {
                        return -1;
                    } else if(!$this->isImage($a) AND $this->isImage($b)) {
                        return 1;
                    }
                }

                return ($a->getProperty($filter->getOrderBy()) < $b->getProperty($filter->getOrderBy())) ? -1 : 1;
            });

            if($filter->getOrderDirection() == 'desc') {
                $documents = array_reverse($documents);
            }
        }

        //Limit
        if(!empty($filter->getLimit())) {
            $documents = array_slice($documents, 0, $filter->getLimit());
        }

		return $documents;
	}

	private function isImage($file) {
        return strtolower($file->getProperty('extension')) == 'jpg' OR strtolower($file->getProperty('extension')) == 'jpeg' OR strtolower($file->getProperty('extension')) == 'png' OR strtolower($file->getProperty('extension')) == 'tif' OR strtolower($file->getProperty('extension')) == 'bmp' OR strtolower($file->getProperty('extension')) == 'gif';
    }

    /**
     * Find folder by sys_file_collection UID
     *
     * @param int $uidSysFileCollection
     * @return array
     */
    public function findFolderByUid($uidSysFileCollection){
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_file_collection');

        $references = $queryBuilder
            ->select('uid', 'folder', 'storage')
            ->from('sys_file_collection')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uidSysFileCollection, \PDO::PARAM_INT))
            )
            ->executeQuery()
            ->fetchAllAssociative();

        return $references;
    }



    /**
     * Retrieves the UIDs of files referenced in the "settings.files" field of a content element.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return string Comma-separated list of original file UIDs
     */
    public function GetFilesInstance($request)
    {
        $fileUids = '';
        $files = $this->filesProcessor->process(
            $request->getAttribute('currentContentObject'),
            [],
            [
                'references.' => [
                    'fieldName' => 'settings.files',
                    'table' => 'tt_content',
                ],
                'as' => 'file',
            ],
            []
        );
        if (isset($files['file']) && !empty($files['file']) ) {
            foreach($files['file'] as $file){
                //put the uids in string seperated by , 
                $fileUids .= $file->getOriginalFile()->getUid().',';
            }
        }
        return $fileUids;
    }
    
}