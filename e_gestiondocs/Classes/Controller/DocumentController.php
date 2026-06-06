<?php
namespace Emagineurs\EGestiondocs\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Emagineurs\EGestiondocs\Domain\Model\Filter;
use Emagineurs\EGestiondocs\Domain\Repository\CategoryRepository;
use Emagineurs\EGestiondocs\Domain\Repository\DocumentRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class DocumentController extends ActionController
{
    public function __construct(
        protected readonly DocumentRepository $documentRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly StorageRepository $storageRepository,
        protected readonly ResourceFactory $resourceFactory
    ) {}

   
    public function initializeListAction(): void
    {
        if ($this->request->hasArgument('filter')) {
            $propertyMappingConfiguration = $this->arguments->getArgument('filter')->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->allowAllProperties();
            $propertyMappingConfiguration->setTypeConverterOption(
                \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
                \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                true
            );
        }
    }

    /**
     * action list files
     *
     * @param Filter|null $filter
     * @param string $folder
     * @param string $category
     * @param string $keywords
     * @param int $currentPage
     * @return ResponseInterface
     */
    public function listAction(Filter $filter = null, $folder = null, $category = null, $keywords = null, int $currentPage = 1): ResponseInterface {
        $foldersList = [];
        $folderName = '';
        
        if(empty($filter)) {
            $filter = GeneralUtility::makeInstance(Filter::class);
        } else if($filter->isSearch()) {
            $this->view->assign('isSearch', true);
        }

        $filter->completeWithSettings($this->settings);

        if(!empty($folder)) {
            $filter->setFolder(array($folder));
        }

        if(!empty($keywords)) {
            $filter->setKeywords($keywords);
        }
        
        if(!empty($category)) {
            $query = $this->categoryRepository->createQuery();
            $query->getQuerySettings()->setRespectSysLanguage(false);
            $query->matching($query->in('uid', array($category)));
            $categories = $query->execute();
            $filter->setCategories($categories);
            foreach ($categories as $onecat) {
                $filter->setCategory($onecat);
            }
        }

        if(!empty($filter->getFolderstring())) {
            $filter->setFolder(array($filter->getFolderstring()));

        }

        if(!empty($this->settings['folder'])){
            $trueString = str_replace("1:/", "/", $this->settings['folder']);
            $foldersList = $this->getListFolder($trueString);
        }
        else{
            if(!empty($this->settings['syscollection'])){
                $resultQuerry = $this->documentRepository->findFolderByUid($this->settings["syscollection"]);
                if (!empty($resultQuerry)) {
                    $folders = "1:/".$resultQuerry[0]["folder"];
                    $foldersList = $this->getListFolder($resultQuerry[0]["folder"]);
                }
            }
        }

        if (!empty($filter->getFolder())) {
            $folderNameFirst = $filter->getFolder()[0];
            $folderNoLast = substr($folderNameFirst, 0, -1);
            $folderArrayName = explode("/", $folderNoLast);
            $folderName = end($folderArrayName);
        }
		
		$filterFolders = $filter->getFolder();
		if (is_array($filterFolders) && !empty($filterFolders)) {
			foreach ($filterFolders as $onefolder) {
				$trueStrings = str_replace("1:/", "/", $onefolder);
				$oneroad = $this->getListFolder($trueStrings);
				$resultSubfolder = [];
				foreach ($oneroad as $onesubfolder) {
					$resultSubfolder = $onesubfolder->getSubfolders(0,0,0,true);
				}
				$folderArray = $filter->getFolder();
				if (!empty($resultSubfolder)) {
					foreach ($resultSubfolder as $key => $value) {
						array_push($folderArray ,"1:".$key);
					}
					$filter->setFolder($folderArray);
				}
			}
		}
		
        $documents = $this->documentRepository->findByFilter($filter);

        $itemsPerPage = (int)($this->settings['itemsPerPage'] ?? 0);
        if ($itemsPerPage > 0 && !empty($this->settings['pagination'])) {
            $paginator = new ArrayPaginator($documents, $currentPage, $itemsPerPage);
            $pagination = new SimplePagination($paginator);
            
            $maxNumberOfLinks = 5; 
            $paginationData = [
                'currentPageNumber' => $currentPage,
                'numberOfPages' => $paginator->getNumberOfPages(),
                'firstPageNumber' => 1,
                'lastPageNumber' => $paginator->getNumberOfPages(),
                'previousPageNumber' => $pagination->getPreviousPageNumber(),
                'nextPageNumber' => $pagination->getNextPageNumber(),
                'displayRangeStart' => max(1, $currentPage - floor($maxNumberOfLinks / 2)),
                'displayRangeEnd' => min($paginator->getNumberOfPages(), $currentPage + floor($maxNumberOfLinks / 2)),
                'pages' => []
            ];
            
            $allPages = $pagination->getAllPageNumbers();
            $displayStart = max(1, $currentPage - floor($maxNumberOfLinks / 2));
            $displayEnd = min($paginator->getNumberOfPages(), $currentPage + floor($maxNumberOfLinks / 2));
            
            if ($displayEnd - $displayStart + 1 < $maxNumberOfLinks) {
                if ($currentPage <= ceil($maxNumberOfLinks / 2)) {
                    $displayEnd = min($maxNumberOfLinks, $paginator->getNumberOfPages());
                } elseif ($currentPage >= $paginator->getNumberOfPages() - floor($maxNumberOfLinks / 2)) {
                    $displayStart = max(1, $paginator->getNumberOfPages() - $maxNumberOfLinks + 1);
                }
            }
            
            $paginationData['displayRangeStart'] = $displayStart;
            $paginationData['displayRangeEnd'] = $displayEnd;
            
            foreach ($allPages as $pageNumber) {
                if ($pageNumber >= $displayStart && $pageNumber <= $displayEnd) {
                    $paginationData['pages'][] = [
                        'number' => $pageNumber,
                        'isCurrent' => ($pageNumber === $currentPage)
                    ];
                }
            }
            
            $this->view->assign('paginator', $paginator);
            $this->view->assign('pagination', (object)$paginationData);
        }

        $this->view->assign('filter', $filter);
        $this->view->assign('folder', $folder);
        $this->view->assign('folderName', $folderName);
        $this->view->assign('foldersList', $foldersList);
        $this->view->assign('documents', $documents);
        $this->view->assign('settings', $this->settings);
        
        return $this->htmlResponse();
    }

    public function getListFolder($currentFolderObj = null){
        if($currentFolderObj === null || $currentFolderObj === ''){
            $currentFolderObj = '/';
        }

        $storageRepo = $this->storageRepository->findByUid(1);
        if ($storageRepo === null) {
            return [];
        }
        
        $folder = $storageRepo->getFolder($currentFolderObj);
        $folders = $storageRepo->getFoldersInFolder($folder);
        $folderArray = array();
        $folderArray[$folder->getIdentifier()] = $folder;
        /*foreach ($folders as $oneFolder) {
            $folderArray[$oneFolder->getIdentifier()] = $oneFolder;
        }*/
        unset($currentFolderObj);
        return $folderArray;
    }

    /**
     * action search form
     *
     * @param Filter|null $filter
     * @param string $folder
     * @return ResponseInterface
     */
    public function searchAction(Filter $filter = null, $folder = null): ResponseInterface {
        
        
        if(empty($filter)) {
            $filter = GeneralUtility::makeInstance(Filter::class);
        }
       
        $filter->completeWithSettings($this->settings);

        $body = array_merge(
            (array)($this->request->getParsedBody()['tx_egestiondocs_list'] ?? []),
            (array)($this->request->getQueryParams()['tx_egestiondocs_list'] ?? [])
        );

        $categoryIds = $body['filter']['category'] ?? $body['category'] ?? null;
        $keywords    = $body['filter']['keywords'] ?? $body['keywords'] ?? null;
        $folder      = $body['folder'] ?? null;
        
        if($categoryIds){
            $query = $this->categoryRepository->createQuery();
            $query->getQuerySettings()->setRespectSysLanguage(false);
            $query->matching($query->in('uid', explode(',', $categoryIds)));
            $result = $query->execute();
            $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
            foreach($result AS $object) {
                $objectStorage->attach($object);
            }
            $filter->setCategories($objectStorage);
            $filter->setCategory($this->categoryRepository->findByUid($categoryIds));
        }
        if($keywords){
            $filter->setKeywords($keywords);
        }
        if($folder){
            $filter->setFolder($folder);
        }

        


        $query = $this->categoryRepository->createQuery();
		$query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching($query->in('uid', explode(',', $this->settings['categories'])));
        $categories = $query->execute();

        $propertyMappingConfiguration = $this->arguments->getArgument('filter')->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowProperties('categories');

        $this->view->assign('categories', $categories);
        $this->view->assign('filter', $filter);
        $this->view->assign('settings', $this->settings);
        
        return $this->htmlResponse();
    }

    /**
     * action list new files
     *
     * @param Filter|null $filter
     * @param string $folder
     * @return ResponseInterface
     */
    public function listNewAction(Filter $filter = null, $folder = null): ResponseInterface {
        $foldersList = [];
        $folderName = '';
        
        if(empty($filter)) {
            $filter = GeneralUtility::makeInstance(Filter::class);
        } else if($filter->isSearch()) {
            $this->view->assign('isSearch', true);
        }

        $filter->completeWithSettings($this->settings);

        if(!empty($folder)) {
            $filter->setFolder(array($folder));
        }
        if(!empty($filter->getFolderstring())) {
            $filter->setFolder(array($filter->getFolderstring()));
        }
        $folderTitle = $filter->getFolder();


        if(!empty($this->settings['folder'])){
            $trueString = str_replace("1:/", "/", $this->settings['folder']);
            $foldersList = $this->getListFolder($trueString);
        }
        else{
            if(!empty($this->settings['syscollection'])){
                $resultQuerry = $this->documentRepository->findFolderByUid($this->settings["syscollection"]);
                if (!empty($resultQuerry)) {
                    $folders = "1:/".$resultQuerry[0]["folder"];
                    $foldersList = $this->getListFolder($resultQuerry[0]["folder"]);
                }
            }
        }

        if (!empty($filter->getFolder())) {
            $folderNameFirst = $filter->getFolder()[0];
            $folderNoLast = substr($folderNameFirst, 0, -1);
            $folderArrayName = explode("/", $folderNoLast);
            $folderName = end($folderArrayName);
        }

        $minDatetime = new \DateTime('now');
        $minDatetime->modify('-' . $this->settings['newPeriod'] . ' day');
        $filter->setMinDatetime($minDatetime);

        $documents = $this->documentRepository->findByFilter($filter);

        $this->view->assign('filter', $filter);
        $this->view->assign('folder', $folder);
        $this->view->assign('folderName', $folderName);
        $this->view->assign('foldersList', $foldersList);
        $this->view->assign('documents', $documents);
        $this->view->assign('settings', $this->settings);
        
        return $this->htmlResponse();
    }

    /**
     * action browse directories
     *
     * @param string $folder
     * @return ResponseInterface
     */
    public function browseAction($folder = null): ResponseInterface {
        $filter = GeneralUtility::makeInstance(Filter::class);
        $filter->completeWithSettings($this->settings);

        if(!empty($folder)) {
            $folder = $this->resourceFactory->getFolderObjectFromCombinedIdentifier($folder);
        } else {
            $filterFolders = $filter->getFolder();
            if (!empty($filterFolders) && is_array($filterFolders)) {
                $folderIdentifier = $filterFolders[0];
            } else {
                $folderIdentifier = '1:/';
            }
            $folder = $this->resourceFactory->getFolderObjectFromCombinedIdentifier($folderIdentifier);
        }

        $this->view->assign('filter', $filter);
        $this->view->assign('folder', $folder);
        $this->view->assign('settings', $this->settings);
        
        return $this->htmlResponse();
    }

    /**
     * action list selected files
     *
     * @param Filter|null $filter
     * @param string $folder
     * @return ResponseInterface
     */
    public function listSelectedAction(Filter $filter = null): ResponseInterface {
        if(empty($filter)) {
            $filter = GeneralUtility::makeInstance(Filter::class);
        } else if($filter->isSearch()) {
            $this->view->assign('isSearch', true);
        }

        $filesUids = $this->documentRepository->GetFilesInstance($this->request);
        $this->settings['files'] = $filesUids;
        $filter->completeWithSettings($this->settings);
        $filter->setFiles(explode(',', $this->settings['files']));

        $documents = $this->documentRepository->findByFilter($filter);

        $this->view->assign('filter', $filter);
        $this->view->assign('documents', $documents);
        $this->view->assign('settings', $this->settings);
        
        return $this->htmlResponse();
    }
}