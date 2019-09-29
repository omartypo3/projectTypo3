<?php

namespace Pingag\PingagJobs\Controller;

use Pingag\PingagJobs\Api\PicklistApi;
use Pingag\PingagJobs\Api\VacancyApi;
use Pingag\PingagJobs\Api\JobPublicationApi;
use Pingag\PingagJobs\Domain\Model\Job;
use Pingag\PingagJobs\Domain\Model\JobSubscription;
use Pingag\PingagJobs\Domain\Model\Location;
use Pingag\PingagJobs\Domain\Model\Vacancy;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 16:41
 */
class VacancyController extends ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \Pingag\PingagJobs\Domain\Repository\VacancyRepository
     * @inject
     */
    protected $vacancyRepo;

    /**
     * @var \Pingag\PingagJobs\Domain\Repository\PropertyRepository
     * @inject
     */
    protected $propertyRepo;

    /**
     * @return mixed
     */
    public function listAction()
    {
        $vacancies = $this->vacancyRepo->findAll();
        foreach ($vacancies as $vacancy){
            $this->setDetailPidBySection($vacancy);
        }
        $this->view->assign('vacancies', $vacancies);

        $types = $this->propertyRepo->findAllByType('type');
        $this->view->assign('types', $types);

        $sections = $this->propertyRepo->findAllByType('section');
        $this->view->assign('sections', $sections);

        $cities = $this->propertyRepo->findAllByType('city');
        $this->view->assign('cities', $cities);
        
        return $this->view->render();
    }
    
    protected function setDetailPidBySection(Vacancy $vacancy)
    {
        $pages = $this->settings['detailPages'];
        $detailPid = $pages['default'];
        
        foreach ($pages as $pageUid=>$sections){
            $sections = explode(',', $sections);
            if($vacancy->getSection() && in_array($vacancy->getSection()->getUid(), $sections)){
                $detailPid = $pageUid;
                break;
            }
        }
        
        $vacancy->setDetailPid($detailPid);
    }

    /**
     * @param Vacancy $vacancy
     * @return string
     */     
    
    public function showAction(Vacancy $vacancy)
    {
        $this->view->assign('job', $vacancy);
        return $this->view->render();
    }
    
    

/*
    public function showAction($importId)
    {
        $v = NULL;
        $vacancies = $this->vacancyRepo->findAll();
        foreach ($vacancies as $va_loop){
            if(strcmp($va_loop["importId"], $importId) == 0)
            {
                $v = $va_loop;
            }
        }
        $this->view->assign('job', $v);
        return $this->view->render();
        
    }
   */



    protected static function getLocale()
    {
        return $GLOBALS['TSFE']->config['config']['language'];
    }

    public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response)
    {
        try {
            parent::processRequest($request, $response);
        } catch (\TYPO3\CMS\Extbase\Property\Exception $exception) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Vacancy not found.');
        } catch (\TYPO3\CMS\Extbase\Mvc\Controller\Exception\RequiredArgumentMissingException $e){
            $GLOBALS['TSFE']->pageNotFoundAndExit('No vacancy object.');
        }
    }
}