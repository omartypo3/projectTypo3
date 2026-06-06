<?php
namespace Emagineurs\ENews\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Xavier Ley <xley@e-magineurs.com>, e-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Emagineurs\ENews\Domain\Model\Category;
use Emagineurs\ENews\Domain\Model\Dto\NewsDemandEnews;
use Emagineurs\ENews\Domain\Model\Enews;
use Emagineurs\ENews\Domain\Validator\NewsValidator;
use Emagineurs\ENews\Event\AfterValidateEvent;
use Emagineurs\ENews\Utility\MailUtility;
use Emagineurs\ENews\Utility\StringUtility;
use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use In2code\Femanager\Domain\Model\User;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use GeorgRinger\News\Utility\Cache;
use TYPO3\CMS\Extbase\Validation\Error;
use GeorgRinger\News\Event\NewsListActionEvent;
use GeorgRinger\News\Event\CreateDemandObjectFromSettingsEvent;
use GeorgRinger\News\Pagination\QueryResultPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use In2code\Femanager\Domain\Repository\UserRepository;
use GeorgRinger\News\Domain\Repository\CategoryRepository;

/**
 * EnewsController
 */
class EnewsController extends \GeorgRinger\News\Controller\NewsController {
	

    /**
     * enewsCategoryRepository - custom category repository for e_news
     * Note: Parent class has $categoryRepository typed as GeorgRinger\News\Domain\Repository\CategoryRepository
     *
     * @var \Emagineurs\ENews\Domain\Repository\CategoryRepository
     */
    protected $enewsCategoryRepository;

    /**

     * @var \GeorgRinger\News\Domain\Repository\CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * Note: Parent class has $tagRepository typed as GeorgRinger\News\Domain\Repository\TagRepository
     * Our custom Emagineurs\ENews\Domain\Repository\TagRepository extends it, so we use parent's property
     */

	/**
	 * Note: Parent ActionController already has $configurationManager property
	 * typed as TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * We use the inherited property from parent class
	 */

	/**
	 * enewsRepository
	 *
	 * @var \Emagineurs\ENews\Domain\Repository\EnewsRepository
	 */
	protected $enewsRepository;


	/**
	 * communeRepository
	 *
	 * @var \Emagineurs\ENews\Domain\Repository\CommuneRepository
	 */
	protected $communeRepository;

	/**
	 * UserRepository
	 *
	 * @var \In2code\Femanager\Domain\Repository\UserRepository
	 */
	protected $frontendUserRepository;
	/**
	 * context
	 *
	 * @var \TYPO3\CMS\Core\Context\Context 
	 */
	protected $context;
   
	 /**
     * @var PersistenceManager
     */
    protected $persistenceManager;



	    public function __construct(
        \In2code\Femanager\Domain\Repository\UserRepository $frontendUserRepository,
		\Emagineurs\ENews\Domain\Repository\CommuneRepository $communeRepository,
		\Emagineurs\ENews\Domain\Repository\EnewsRepository $enewsRepository,
		\TYPO3\CMS\Core\Context\Context $context,
		\Emagineurs\ENews\Domain\Repository\CategoryRepository $enewsCategoryRepository,
		CategoryRepository $categoryRepository,
		PersistenceManager $persistenceManager
    ) {
        $this->frontendUserRepository = $frontendUserRepository;
        $this->communeRepository = $communeRepository;
        $this->enewsRepository = $enewsRepository;
        $this->context = $context;
		$this->enewsCategoryRepository = $enewsCategoryRepository;
		$this->categoryRepository = $categoryRepository;
		$this->persistenceManager = $persistenceManager;
    }

	
	/**
	 * Override processRequest to manually handle search arguments before property mapping
	 */
	public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request): \Psr\Http\Message\ResponseInterface
	{
		if ($request->getControllerActionName() === 'searchForm' || $request->getControllerActionName() === 'searchResult') {
			$arguments = $request->getArguments();
			if (isset($arguments['search']) && is_array($arguments['search'])) {
				$searchEnews = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class);
				
				foreach ($arguments['search'] as $property => $value) {
					$setter = 'set' . ucfirst($property);
					if (method_exists($searchEnews, $setter)) {
						$searchEnews->$setter($value);
					}
				}
				
				$arguments['search'] = $searchEnews;
				$request = $request->withArguments($arguments);
			}
		}
		
		return parent::processRequest($request);
	}

	protected function initializeAction(): void
	{
		parent::initializeAction();
		if ($this->request->getControllerName() === 'Enews') {
			$this->request = $this->request->withControllerName('ENews');
		}
	}

	/**
	 * Initialize searchForm action - configure argument mappings
	 */
	public function initializeSearchFormAction(): void
	{
		parent::initializeSearchFormAction();
		if ($this->arguments->hasArgument('search')) {
			$propertyMappingConfiguration = $this->arguments['search']->getPropertyMappingConfiguration();
			
			$propertyMappingConfiguration->setTypeConverterOption(
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_TARGET_TYPE,
				\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class
			);
			
			$propertyMappingConfiguration->allowAllProperties();
			
			$propertyMappingConfiguration->setTypeConverterOption(
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_OVERRIDE_TARGET_TYPE_ALLOWED,
				true
			);
		}
	}

	/**
	 * Initialize searchResult action - configure argument mappings
	 */
	public function initializeSearchResultAction(): void
	{
		parent::initializeSearchResultAction();
		if ($this->arguments->hasArgument('search')) {
			$propertyMappingConfiguration = $this->arguments['search']->getPropertyMappingConfiguration();
			
			$propertyMappingConfiguration->setTypeConverterOption(
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_TARGET_TYPE,
				\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class
			);
			
			$propertyMappingConfiguration->allowAllProperties();
			
			$propertyMappingConfiguration->setTypeConverterOption(
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_OVERRIDE_TARGET_TYPE_ALLOWED,
				true
			);
		}
	}

	/**
	 * Create the demand object which define which records will get shown
	 *
	 * @param array $settings
	 * @return \GeorgRinger\News\Domain\Model\Dto\NewsDemand
	 */
	 /**
     * Create the demand object which define which records will get shown
     *
     * @param string $class optional class which must be an instance of \GeorgRinger\News\Domain\Model\Dto\NewsDemand
     */
    protected function createDemandObjectFromSettings(
        array $settings,
        $class = NewsDemand::class
    ): NewsDemand {
        $class = isset($settings['demandClass']) && !empty($settings['demandClass']) ? $settings['demandClass'] : $class;

        /* @var $demand NewsDemand */
        $demand = GeneralUtility::makeInstance($class, $settings);
        if (!$demand instanceof NewsDemand) {
            throw new \UnexpectedValueException(
                sprintf(
                    'The demand object must be an instance of %s, but %s given!',
                    NewsDemand::class,
                    $class
                ),
                1423157953
            );
        }

        $demand->setCategories(GeneralUtility::trimExplode(',', $settings['categories'] ?? '', true));
        $demand->setCategoryConjunction((string)($settings['categoryConjunction'] ?? ''));
        $demand->setIncludeSubCategories((bool)($settings['includeSubCategories'] ?? false));
        $demand->setTags((string)($settings['tags'] ?? ''));

        $demand->setTopNewsRestriction((int)($settings['topNewsRestriction'] ?? 0));
        $demand->setTimeRestriction($settings['timeRestriction'] ?? '');
        $demand->setTimeRestrictionHigh($settings['timeRestrictionHigh'] ?? '');
        $demand->setArchiveRestriction((string)($settings['archiveRestriction'] ?? ''));
        $demand->setExcludeAlreadyDisplayedNews((bool)($settings['excludeAlreadyDisplayedNews'] ?? false));
        $demand->setHideIdList((string)($settings['hideIdList'] ?? ''));

        if ($settings['orderBy'] ?? '') {
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }
        $demand->setOrderByAllowed((string)($settings['orderByAllowed'] ?? ''));

        $demand->setTopNewsFirst((bool)($settings['topNewsFirst'] ?? false));

        $demand->setLimit((int)($settings['limit'] ?? 0));
        $demand->setOffset((int)($settings['offset'] ?? 0));

        $demand->setSearchFields((string)($settings['search']['fields'] ?? ''));
        $demand->setDateField((string)($settings['dateField'] ?? ''));
        $demand->setMonth((int)($settings['month'] ?? 0));
        $demand->setYear((int)($settings['year'] ?? 0));

        $startingPoint = (string)($settings['startingpoint'] ?? '');
        $recursive = (int)($settings['recursive'] ?? 0);
        if (!empty($startingPoint)) {
            $extendedPidList = \Emagineurs\ENews\Utility\PageUtility::extendPidListByChildren($startingPoint, $recursive);
            $demand->setStoragePage($extendedPidList);
        } else {
            $demand->setStoragePage('');
        }

        if ($hooks = $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Controller/NewsController.php']['createDemandObjectFromSettings'] ?? []) {
            trigger_error('The hook $GLOBALS[\'TYPO3_CONF_VARS\'][\'EXT\'][\'news\'][\'Controller/NewsController.php\'][\'createDemandObjectFromSettings\'] has been deprecated, use event CreateDemandObjectFromSettingsEvent instead', E_USER_DEPRECATED);
            $params = [
                'demand' => $demand,
                'settings' => $settings,
                'class' => $class,
            ];
            foreach ($hooks as $reference) {
                GeneralUtility::callUserFunction($reference, $params, $this);
            }
        }

        $event = new CreateDemandObjectFromSettingsEvent($demand, $settings, $class);
        $this->eventDispatcher->dispatch($event);
        $demand = $event->getDemand();

        return $demand;
    }
    
	/**
	 * Output a list view of news
	 *
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function listAction(?array $overwriteDemand = NULL): ResponseInterface {
        $this->enewsRepository->setSettings($this->settings);
		$demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, get_parent_class(__CLASS__));

		if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
			$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
		}
		$newsRecords = $this->enewsRepository->findDemanded($demand);

        if($this->settings['orderBy'] == 'dates'){
            $newsRecords = $this->orderNewsByDates($newsRecords);
        }

        $assignedValues = [
            'news' => $newsRecords,
            'overwriteDemand' => $overwriteDemand,
            'demand' => $demand,
        ];

        if ($demand->getCategories() !== '') {
            $categoriesList = $demand->getCategories();

            if (!empty($categoriesList)) {
                $assignedValues['categories'] = $this->enewsCategoryRepository->findByIdList($categoriesList);
            }
        }

        if ($demand->getTags() !== '') {
            $tagList = $demand->getTags();
            if (!is_array($tagList)) {
                $tagList = GeneralUtility::trimExplode(',', $tagList);
            }
            if (!empty($tagList)) {
                $assignedValues['tags'] = $this->tagRepository->findByIdList($tagList);
            }
        }
		
		$event = $this->eventDispatcher->dispatch(new NewsListActionEvent($this, $assignedValues, $this->request));
        $this->view->assignMultiple($event->getAssignedValues());

        // pagination
        if ((int)($this->settings['hidePagination'] ?? 0) === 0) {
            $paginationConfiguration = $this->settings['list']['paginate'] ?? [];
            $itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 10);
            $maximumNumberOfLinks = (int)($paginationConfiguration['maximumNumberOfLinks'] ?? 0);

            $currentPage = max(1, $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1);
            $paginator = GeneralUtility::makeInstance(QueryResultPaginator::class, $event->getAssignedValues()['news'], $currentPage, $itemsPerPage, (int)($this->settings['limit'] ?? 0), (int)($this->settings['offset'] ?? 0));
            $paginationClass = $paginationConfiguration['class'] ?? SimplePagination::class;
            $pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);
            $this->view->assign('pagination', [
                'currentPage' => $currentPage,
                'paginator' => $paginator,
                'pagination' => $pagination,
            ]);
        }

        Cache::addPageCacheTagsByDemandObject($demand);
        
        return $this->htmlResponse();
	}

    /**
     * Re-order the news according the differents ocurrences of the dates
     *
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $newsRecords news items
     * @return array
     */
    public function orderNewsByDates($newsRecords){
        $preOrderArray = [];

        // On génère un nouveau tableau ayant comme clé les dates des ocurrences et comme valeur la news correspondante
        foreach($newsRecords as $currentNews){
            if(!empty($currentNews->getDates())){
                foreach($currentNews->getDates() as $currentDateCurrentNews){
                    // $currentNews->setCurrentdate($currentDateCurrentNews->getBegindate());
                    $preOrderArray[$currentDateCurrentNews->getBegindate()] = $currentNews;
                }
            }
        }

        // On va trier le tableau par clé de façon a trier les dates
        if(count($preOrderArray) > 0){
            if($this->settings['orderDirection'] == 'desc'){
                krsort($preOrderArray);
            } else {
                ksort($preOrderArray);
            }

            // On extrait la portion de tableau requise si on nombre max d'enregistrement a été défini
            $orderedNewsArraySliced = $this->settings['limit'] ? array_slice($preOrderArray, 0, $this->settings['limit'], true) : $preOrderArray;

            return $orderedNewsArraySliced;
        } else {
            return $newsRecords->toArray();
        }
    }

    /**
	 * Single view of a news record
	 *
	 * @param \GeorgRinger\News\Domain\Model\News $news news item
	 * @param integer $currentPage current page for optional pagination
	 * @return ResponseInterface
	 */
	public function detailAction(?\GeorgRinger\News\Domain\Model\News $news = null, $currentPage = 1): ResponseInterface {
		/// Surcharge Tristan - prend en compte le fait que si on force l'affichage d'une news en particulier, on ne prend plus en compte le paramètre de l'url
		$params = $this->request->getArguments();
		if (isset($this->settings['singleNews']) && $this->settings['singleNews'] !== NULL  && trim($this->settings['singleNews']) !== '') {
			$params['news'] = $this->settings['singleNews'];
		}
        
		if(!empty($params['news'])){
			$news = $this->enewsRepository->findByUid(intval($params['news']));	 
		}else if(!empty($params['news_preview'])){	 
			$news = $this->enewsRepository->findByUid(intval($params['news_preview']), FALSE);
		}            
		
		if (!is_null($news)) {
            // La surcharge de GeorgRinger\Domain\Model\FileReference n'a pas tres bien marché,
            // Du coup on ajoute "à la main", les propriétés manquantes (faute de temps pour tout faire parfaitement proprement)
            $media = $news->getFalMedia();        
            foreach($media as $key => $value){
               $arrayInfoMedia = $value->getOriginalResource()->getReferenceProperties();

               foreach($arrayInfoMedia as $field => $infoMedia){
                    $setter = 'set' . str_replace('_', '', ucwords($field, '_'));
                    if (method_exists($value, $setter)) {
                        $value->$setter($infoMedia);
                    }
               }
            }
            $news->setFalMedia($media);
        }
		
 		$news = $this->increaseViewCounter($news);
 		
        return parent::detailAction($news, $currentPage);
    }

    /**
     * Increase news view counter
     *
     * @param $news
     * @return mixed
     */
 	public function increaseViewCounter($news){
 		if($news instanceof \Emagineurs\ENews\Domain\Model\Enews){
 			$news->setCountview($news->getCountview() + 1);
 			$this->enewsRepository->update($news);
 			GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();
 		}

        return $news;
 	}
    
	/**
	 * Output a list view of news, filtered by date (news happening today only)
	 *
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function filterTodayAction($overwriteDemand = NULL): ResponseInterface {
        return $this->filterPeriode($overwriteDemand, 'day');
	}

	/**
	 * Output a list view of news, filtered by date (news happening the next week end only)
	 *
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function filterWeekendAction($overwriteDemand = NULL): ResponseInterface {
		return $this->filterPeriode($overwriteDemand, 'week-end');
	}

	/**
	 * Output a list view of news, filtered by date (news happening this week only)
	 *
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function filterWeekAction($overwriteDemand = NULL): ResponseInterface {
        return $this->filterPeriode($overwriteDemand, 'week');
	}

	/**
	 * Output a list view of news, filtered by date (news happening this month only)
	 *
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function filterMonthAction($overwriteDemand = NULL): ResponseInterface {
		return $this->filterPeriode($overwriteDemand, 'month');
	}
	
	/**
	 * Output a list view of news, filtered by date, depending on the given period
	 *
	 * @param string $period
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function filterPeriode($overwriteDemand = NULL, $period = 'month'): ResponseInterface {
		$demand = $this->createDemandObjectFromSettings($this->settings);

		if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
			$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
		}

        $this->enewsRepository->setSettings($this->settings, array('periode' => $period));
        $eNews= $this->enewsRepository->findDemanded($demand);

        // Clean the attribute Periode after finding yout news. Avoid problems if multiple list on the same page
		$this->enewsRepository->setSettings($this->settings, array('periode' => ''));

		$assignedValues = array(
			'news' => $eNews,
			'overwriteDemand' => $overwriteDemand,
			'demand' => $demand,
		);
		
		$this->view->assignMultiple($assignedValues);
		
		// pagination
		if ((int)($this->settings['hidePagination'] ?? 0) === 0) {
			$paginationConfiguration = $this->settings['list']['paginate'] ?? [];
			$itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 10);
			$maximumNumberOfLinks = (int)($paginationConfiguration['maximumNumberOfLinks'] ?? 0);

			$currentPage = max(1, $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1);
			$paginator = GeneralUtility::makeInstance(QueryResultPaginator::class, $eNews, $currentPage, $itemsPerPage, (int)($this->settings['limit'] ?? 0), (int)($this->settings['offset'] ?? 0));
			$paginationClass = $paginationConfiguration['class'] ?? SimplePagination::class;
			$pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);

			$this->view->assign('pagination', [
				'currentPage' => $currentPage,
				'paginator' => $paginator,
				'pagination' => $pagination,
			]);
		}
		
		return $this->htmlResponse();
	}

	/**
	 * Display the search form
	 *
	 * @param \GeorgRinger\News\Domain\Model\Dto\Search $search
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */
	public function searchFormAction(?\GeorgRinger\News\Domain\Model\Dto\Search $search = null, array $overwriteDemand = []): ResponseInterface {
		$demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, get_parent_class(__CLASS__));
		if (isset($this->settings['disableOverrideDemand'])) {
			if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
				$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
			}
		}
		// On récupère les tableaux avec les listes des communes et des catégories
		// On ajoute d'abord un tableau avec un clé et une valeur vide afin d'avoir un champ vide dans le menu déroulant
        
        //$categories = $this->getCategoriesFromSettings();
        $categories = $this->getCategoriesArray();
        
        $arrayCities = array(0 => '')+$this->getCityList();	
						
		if (is_null($search)) {
			$search = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class);
		} elseif (!($search instanceof \Emagineurs\ENews\Domain\Model\Dto\SearchEnews)) {
			$searchEnews = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class);
			$searchEnews->setSubject($search->getSubject());
			$searchEnews->setFields($search->getFields());
			$searchEnews->setMinimumDate($search->getMinimumDate());
			$searchEnews->setMaximumDate($search->getMaximumDate());
			$search = $searchEnews;
		}
		$demand->setSearch($search);

		$assignedValues = array(
			'categories' => $categories,
			'commune' => $arrayCities,
			'search' => $search,
			'overwriteDemand' => $overwriteDemand,
			'demand' => $demand,
		);

        $this->view->assignMultiple($assignedValues);
        
        return $this->htmlResponse();
	}

	/**
	 * Displays the search result
	 *
	 * @param \GeorgRinger\News\Domain\Model\Dto\Search $search
	 * @param array $overwriteDemand
	 * @return ResponseInterface
	 */	 
	public function searchResultAction(
		?\GeorgRinger\News\Domain\Model\Dto\Search $search = null,
        array $overwriteDemand = []
    ): ResponseInterface {
    	$periode = $this->settings['periode'] ?? '';
        $this->enewsRepository->setSettings($this->settings, array('periode' => $periode));
	
		$demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, get_parent_class(__CLASS__));
	
		if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
			$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
		}
		
		if (!is_null($search) && !($search instanceof \Emagineurs\ENews\Domain\Model\Dto\SearchEnews)) {
			$searchEnews = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class);
			$searchEnews->setSubject($search->getSubject());
			$searchEnews->setFields($search->getFields());
			$searchEnews->setMinimumDate($search->getMinimumDate());
			$searchEnews->setMaximumDate($search->getMaximumDate());
			$search = $searchEnews;
		}
							
		if (!is_null($search)) {
			// $this->settings était vide, du coup je récupère les valeurs de conf "à la main"
			$search->setFields($this->settings['search']['fields']);
		}
        
		$demand->setSearch($search);
		
		$postVars = $this->request->getArguments();
		$postVarsSearch = $postVars['search'] ?? null;
			
		$this->enewsRepository->setSettings($this->settings, array('agenda' => '1', 'agendaSearch' => '1'));
       
        $eNews = $this->enewsRepository->findDemanded($demand);
				
		$assignedValues = array(
			'news' => $eNews,
			'overwriteDemand' => $overwriteDemand,
			'search' => $search,
			'demand' => $demand,
			'postVars' => $postVarsSearch
		);

        $this->view->assignMultiple($assignedValues);
        
        // pagination
		if ((int)($this->settings['hidePagination'] ?? 0) === 0) {
			$paginationConfiguration = $this->settings['list']['paginate'] ?? [];
			$itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 10);
			$maximumNumberOfLinks = (int)($paginationConfiguration['maximumNumberOfLinks'] ?? 0);

			$currentPage = max(1, $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1);
			$paginator = GeneralUtility::makeInstance(QueryResultPaginator::class, $eNews, $currentPage, $itemsPerPage, (int)($this->settings['limit'] ?? 0), (int)($this->settings['offset'] ?? 0));
			$paginationClass = $paginationConfiguration['class'] ?? SimplePagination::class;
			$pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);

			$this->view->assign('pagination', [
				'currentPage' => $currentPage,
				'paginator' => $paginator,
				'pagination' => $pagination,
			]);
		}
        
        return $this->htmlResponse();
	}

	/**
	 * Display news creation form
	 *
	 * @param \Emagineurs\ENews\Domain\Model\Enews $news
	 * @return ResponseInterface
	 */
	public function createAction(?\Emagineurs\ENews\Domain\Model\Enews $news = null): ResponseInterface {


		$frontendUserAspect = $this->context->getAspect('frontend.user');
        $userId = $frontendUserAspect->get('id');

        $user = $this->frontendUserRepository->findByUid($userId);
        $categories = $this->getCategoriesFromSettings();

        if(empty($news)) {
            $news = GeneralUtility::makeInstance(Enews::class);
        } else {
            /** @var NewsValidator $validator */
            $validator = GeneralUtility::makeInstance(NewsValidator::class);
            $errors = $validator->validate($news);

		
			if(!$errors->hasErrors()) {
				return $this->addAction($news);
			} else {
				/** @var Error $error */
				foreach($errors->getErrors() as $error) {
					$this->addFlashMessage($error->getMessage(), '', 2);
				}
			}
        }
   		$this->view->assign('categories', $categories);
       	$this->view->assign('news', $news);
       	$this->view->assign('user', $user);
       	
       	return $this->htmlResponse();
	}

	/**
	 * Add a news into the database
	 *
	 * @param \Emagineurs\ENews\Domain\Model\Enews $news
	 * @return ResponseInterface
	 */
	#[Extbase\Validate(['validator' => NewsValidator::class, 'param' => 'news'])]
	public function addAction(\Emagineurs\ENews\Domain\Model\Enews $news): ResponseInterface {


	    /** @var User $user */
		$frontendUserAspect = $this->context->getAspect('frontend.user');
        $userId = $frontendUserAspect->get('id');

        $user = $this->frontendUserRepository->findByUid($userId);
        $allTyposArray = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$currentRequest = $this->request->getArguments();

		$files = [];
		$postVars = [];
		$media = null;
		$imagefolderName = '';
		$changeMedia = false;

		if (!empty($_FILES)) {
			$files = $_FILES;
		} elseif (!empty($currentRequest['files'])) {
			$files = $currentRequest['files'];
		}

		if(!empty($news->getUservalidationtoken() )){
			$imagetitle = $news->getUservalidationtoken();
			$news->setUservalidationtoken("");
		}
		else{
			$imagetitle = null;
		}

		if(!empty($news->getAdminvalidationtoken() )){
			$imagecopyright = $news->getAdminvalidationtoken();
			$news->setAdminvalidationtoken("");
		}
		else{
			$imagecopyright = null;
		}
		
		if(!empty($files)){
		   $mediaArray = $this->insertFiles($files,$postVars,$media,'media',$imagetitle,$imagefolderName,$news);
		   $media = $mediaArray[0];
		   $changeMedia = $mediaArray[1];
		}
		if($changeMedia && !empty($media)){
			$media->setDescription($imagecopyright);
			$media->setTitle($imagetitle);
			$emptyStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
			$emptyStorage->attach($media);
			$news->setFalMedia($emptyStorage);
	  	}  

			// Ajout de la catégorie sélectionnée dans le formulaire
			if($this->request->hasArgument('news')) {
				$newsArgs = $this->request->getArgument('news');	
				if (isset($newsArgs['categories'])){
					$categoryUid = (int)$newsArgs['categories'];
					if($categoryUid){
						$categoryModel = $this->categoryRepository->findByUid($categoryUid);
						$news->addCategory($categoryModel);
					}
				}
			} 


        $news->setType(0); //todo : tobe checked
		if (empty($this->settings['startingpoint'])) {
			$this->settings['startingpoint'] = '1';
		}
        $news->setPid(explode(',', $this->settings['startingpoint'])[0]);
		$news->setDatetime(new \DateTime('now'));
		$news->setCrdate(new \DateTime('now'));
		if ($user) {
			$news->setFeuser($user);
		}
        $news->setAdminvalidation($this->settings['validation']['admin']['enabled'] ? 0 : 1);
        $news->setAdminvalidationtoken(StringUtility::generateRandomString(10));
        $news->setUservalidation($this->settings['validation']['user']['enabled'] ? 0 : 1);
        $news->setUservalidationtoken(StringUtility::generateRandomString(10));
        $news->setHidden($news->getUservalidation() != 1 OR $news->getAdminvalidation() != 1);
        $this->enewsRepository->add($news);
        $this->persistenceManager->persistAll();
        if($news->getUservalidation() == 0) {
            MailUtility::sendMail(
                array($user->getEmail() => $user->getUsername()),
                array($this->settings['validation']['user']['senderEmail'] => $this->settings['validation']['user']['senderName']),
                $this->settings['validation']['user']['subject'],
                $this->settings['validation']['user']['template'],
                array(
                    'news' => $news,
                    'validationPid' => !empty($this->settings['validation']['user']['page']) ? $this->settings['validation']['user']['page'] : $GLOBALS["TSFE"]->id,
                    'settings' => $this->settings,
				)       ,
				$this->uriBuilder
			     );
        } else if($news->getAdminvalidation() == 0) {
        	$arrayEmail = explode(";", $this->settings['validation']['admin']['adminEmail']);
        	foreach ($arrayEmail as $oneMail) {
	            MailUtility::sendMail(
	                array($oneMail => $this->settings['validation']['admin']['adminName']),
	                array($this->settings['validation']['admin']['senderEmail'] => $this->settings['validation']['admin']['senderName']),
	                $this->settings['validation']['admin']['subject'],
	                $this->settings['validation']['admin']['template'],
	                array(
	                    'news' => $news,
	                    'validationPid' => !empty($this->settings['validation']['admin']['page']) ? $this->settings['validation']['admin']['page'] : $GLOBALS["TSFE"]->id,
	                    'settings' => $this->settings,
					),
					$this->uriBuilder

	            );

        	}
        }


		$tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
		$tce->start([], []);
		$tce->clear_cacheCmd('cacheTag:tx_news');


        $this->redirect('','','',array(),(int)$this->settings['backPid']);
        //$this->view->assign('messagenews', $messagenews);
        $this->view->assign('news', $news);
        $this->view->assign('user', $user);
        $this->view->assign('settings', $this->settings);
		
       	return $this->htmlResponse();

        //$this->redirect(null, null, null, array('status' => 'add', 'news' => $news), $this->settings['backPid']);
    }

    /**
     * action validate a news
     *
     * @param int $news
     * @param string $token
     * @param bool $validate if false, the news validation is declined and the news is removed
     * @param string $validationType use "admin" for admin validation, use "user" for user validation
     * @return ResponseInterface
     */
    public function validateAction($news = null, $token = null, $validate = true, $validationType = 'user'): ResponseInterface {
        $success = false;
        $newsObject = null;


        if (!empty($news) && !empty($token)) {
            $query = $this->enewsRepository->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(false);
            $query->getQuerySettings()->setIgnoreEnableFields(true);
            $query->matching($query->equals('uid', $news));
            /** @var Enews $newsObject */
            $newsObject = $query->execute()->getFirst();
        }



        if(!empty($newsObject)) {
            if ($validationType == 'user' AND $newsObject->getUservalidation() == 0 AND $newsObject->getUservalidationtoken() == $token) {
                if ($validate) {
                    $newsObject->setUservalidation(1);
                    $newsObject->setHidden($newsObject->getUservalidation() != 1 OR $newsObject->getAdminvalidation() != 1);
                    $this->enewsRepository->update($newsObject);
                    if ($newsObject->getAdminvalidation() == 0) {
                    	$arrayEmail = explode(";", $this->settings['validation']['admin']['adminEmail']);
        				foreach ($arrayEmail as $oneMail) {
	                        MailUtility::sendMail(
	                            array($oneMail => $this->settings['validation']['admin']['adminName']),
	                            array($this->settings['validation']['admin']['senderEmail'] => $this->settings['validation']['admin']['senderName']),
	                            $this->settings['validation']['admin']['subject'],
	                            $this->settings['validation']['admin']['template'],
	                            array(
	                                'news' => $newsObject,
	                                'validationPid' => !empty($this->settings['validation']['admin']['page']) ? $this->settings['validation']['admin']['page'] : $GLOBALS["TSFE"]->id,
	                                'settings' => $this->settings,
								),
				$this->uriBuilder

	                        );
	                    }
                    }
                } else {
                    $newsObject->setUservalidation(2);
                    $this->enewsRepository->update($newsObject);
                }

                $success = true;
            } else if ($validationType == 'admin' AND $newsObject->getAdminvalidation() == 0 AND $newsObject->getAdminvalidationtoken() == $token) {
                if ($validate) {
                    $newsObject->setAdminvalidation(1);
                    $newsObject->setHidden($newsObject->getUservalidation() != 1 OR $newsObject->getAdminvalidation() != 1);
                    $this->enewsRepository->update($newsObject);
                } else {
                    $newsObject->setAdminvalidation(2);
                    $this->enewsRepository->update($newsObject);
                }

                $success = true;
            }
        }

		$event = new AfterValidateEvent($newsObject, $validate, $validationType);
		$this->eventDispatcher->dispatch($event);

        $this->view->assign('news', $newsObject);
        $this->view->assign('validate', $validate);
        $this->view->assign('validationType', $validationType);
        $this->view->assign('success', $success);
        
        return $this->htmlResponse();
    }

    /**
     * action delete a news
     *
     * @param \Emagineurs\ENews\Domain\Model\Enews $news
     * @return ResponseInterface
     */
    public function deleteAction(\Emagineurs\ENews\Domain\Model\Enews $news): ResponseInterface {
        if(empty($news->getFeuser()) OR empty($GLOBALS['TSFE']->fe_user->id) OR $GLOBALS['TSFE']->fe_user->id != $news->getFeuser()->getUid()) {
            $this->view->assign('success', false);
        } else {
            $this->enewsRepository->remove($news);
            $this->view->assign('success', true);
        }

        //$this->redirect(null, null, null, array(), $this->settings['backPid']);
        
        return $this->htmlResponse();
    }

	/**
	 *
	 * Renvoie la liste des villes pour le formulaire de recherche
	 *
	 */
	public function getCityList() {		
		$cityList = array();

		// communeRepository is already injected via injectCommuneRepository()
        
		$arrayCommune = $this->communeRepository->findAll()->toArray();
		
		foreach($arrayCommune as $city){
			$cityList[$city->getUid()] = $city->getTitle();
		}
		
		return $cityList;
	}

    /**
     * Categories list for frontend news creation form
     *
     * @return array
     */
    public function getCategoriesFromSettings() {
        $categoriesIds = explode(',', $this->settings['categories']);

        $query = $this->enewsCategoryRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('uid', $categoriesIds));
        $results = $query->execute()->toArray();

        if(empty($this->settings['includeSubCategories'])) {
            return $results;
        } else if(count($results) > 1) {
            $categories = array();
            foreach($results as $category) {
                $this->addCategoryAndChildren($categories, $category);
            }
            return $categories;
        } else {
            $categories = array();
            /** @var Category $category */
            $category = $results[0];
            // Initialize custom category repository for findChildren method
            if (!$this->enewsCategoryRepository) {
                $this->enewsCategoryRepository = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Repository\CategoryRepository::class);
            }
            $children = $this->enewsCategoryRepository->findChildren($category->getUid());
            foreach($children as $child) {
                $this->addCategoryAndChildren($categories, $child);
            }
        }
        return $categories;
    }

    /**
     * Build categories array including subcategories, used by getCategoriesFromSettings
     *
     * @param array $array
     * @param Category $category
     * @param string $titlePrefix
     */
    private function addCategoryAndChildren(&$array, $category, $titlePrefix = '')
    {
        $category->setTitle($titlePrefix . $category->getTitle());
        $array[] = $category;

        // Initialize custom category repository for findChildren method
        if (!$this->enewsCategoryRepository) {
            $this->enewsCategoryRepository = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Repository\CategoryRepository::class);
        }
        $children = $this->enewsCategoryRepository->findChildren($category->getUid());
        foreach($children as $child) {
            $this->addCategoryAndChildren($array, $child, '--' . $titlePrefix);
        }
    }


    public function insertFiles($files,$postVars,$object,$type,$legend,$namefolder, $news = NULL){
		$resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);

		if(!empty($files['tx_news_pi1']['name']['file'][$type])){

			$fileMedia = $files['tx_news_pi1']['name']['file'][$type];
			$fileTmpMedia = $files['tx_news_pi1']['tmp_name']['file'][$type];
			$storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
			$storage = $storageRepository->findByUid(1);
			// On va placé l'image dans le repertoire fileadmin/Agenda-Essonne-Front, que l'on va créer s'il n'existe pas
			
			if(empty($namefolder)){
				$namefolder = 'media_upload';
			}
			//La variable dans lequel on ranger les imagees
			//$identifier = '/'.$namefolder;
			$identifier = '/'.$namefolder;
			//La variable qui va nous servir à chercher le dossier 
			$research = 'fileadmin'.$identifier;

			$absoluteIdentiferPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($research);

			if (file_exists($absoluteIdentiferPath)) {
				$folder = $storage->getFolder($identifier);  
			} 
			else {
				$folder = $storage->createFolder($identifier);  
			}

			// On ajoute l'image/le fichier
			$file = $storage->addFile($fileTmpMedia, $folder, $fileMedia);

			// On crée la reference correspondante (ne s'execute que pour les edit car c'est le cas ou l'uid existe, pour les new, ce traitement a lieu après la création de la news)
			if(!empty($news)) {

				$object = GeneralUtility::makeInstance(\GeorgRinger\News\Domain\Model\FileReference::class);
				$fieldname = $type = 'media' ? 'fal_media' : 'fal_related_files';
				$fileReference = $this->createFileReference($news, $file, $legend, $object, 1, $fieldname);

				$object->setOriginalResource($fileReference);
				$object->setShowinpreview(TRUE);
			}

			$change = true;
		} 
		$content = array($object,$change);
	  return $content;
	 }

	 public function createFileReference($news, $file, $title, $object = null, $renderObj = 0, $fieldname = 'fal_media') { 	  
	  $resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
	  $data = array(
	   'uid_local' => $file->getUid(),
	   'uid_foreign' => $news->getUid(),
	   'tablenames' =>  'tx_news_domain_model_news',
	   'fieldname' => $fieldname,
	   'showinpreview' => 1,
	   'title' => $title,
	   'pid' => $news->getPid(),
	   'table_local' => 'sys_file',
	  );

	  $uid = $resourceFactory->createFileReferenceObject($data);
	  return $uid;
	}



	public function getCategoriesArray(){
        if($this->settings['filtreCatParent']){
		
            if(is_array($this->settings['filtreCatParent']['multiple'])){
                $arrayCategories = array();
                foreach($this->settings['filtreCatParent']['multiple'] as $currentCatParent){
                    $arrayCategories[] = $this->generateCategoriesArray($currentCatParent);
                }
            } else {
				$arrayCategories = $this->generateCategoriesArray($this->settings['filtreCatParent']['single']);
            }
        }
            
        return $arrayCategories;
    }
    
    public function generateCategoriesArray($catParent){
        $catListe = $this->getCategoryList(array($catParent));

        unset($catListe[$catParent]);
        if(isset($this->settings['disableNullCategorie']) && $this->settings['disableNullCategorie'] == 1){
        	$arrayCategories = array()+$catListe;
        }
        else{
        	$arrayCategories = array(0 => '')+$catListe;
        }
        
        return $arrayCategories;
    }
	
	/***
	*
	* Renvoie la liste des catégories pour le formulaire de recherche
	*
	***/
	public function getCategoryList($parentCat = array(), $prefix='-1') {
		$categoriesRepo = GeneralUtility::makeInstance(\Emagineurs\ENews\Domain\Repository\CategoriesRepository::class);
			
		if(count($parentCat) < 1){
			$idList = explode(',', $this->settings['categories']);
		} else {
			$idList = $parentCat;
		}
		                
		$arrayCat = $categoriesRepo->findTree($idList);

        $categoryList = $this->getChildCatsRecursively($arrayCat,$prefix);	
		
		return $categoryList;
	}
    
    function getChildCatsRecursively($arrayCat,$prefix){	
		$categoryList = array();
		foreach($arrayCat as $cat){
			if($prefix == -1){
                $categoryList[$cat['item']->getUid()] = $cat['item']->getTitle();
            } else {
                $categoryList[$cat['item']->getUid()] = $prefix.$cat['item']->getTitle();
            }
			
			if($prefix == -1){
                $prefix = '';
            } else if($prefix == '') {
                $prefix = '- ';
            } else {
                $prefix = '- '.$prefix;
            }
			if(isset($cat['children']) && $cat['children']){	
                $categoryList = $this->getCatChildren($categoryList,$cat,$prefix);				
			}
		}
        
        return $categoryList;
    }
    
    function getCatChildren($categoryList,$cat,$prefix){                
        foreach($cat['children'] as $child){
            $arrayChild = $this->getCategoryList(array($child['item']->getUid()), $prefix);
            $categoryList = $categoryList+$arrayChild;	
        }
        
        return $categoryList;
    }
}