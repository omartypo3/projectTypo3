<?php
namespace DslFactory\DslJobs\Controller;

/***
 *
 * This file is part of the "Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * JobsController
 */
class JobsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    CONST STANDORT_BRUMBY_UID = 66;
    CONST STANDORT_CRIMMITSCHAU_UID = 67;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->jobsRepository  = $this->objectManager->get('DslFactory\\DslJobs\\Domain\\Repository\\JobsRepository');
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {   
        $this->view->assign('standorte', $this->getJobsByStandorte());
    }


    /**
     * action listBrumby
     *
     * @return void
     */
    public function listBrumbyAction()
    {
        $this->view->assign('standorte', $this->getJobsByStandorte(self::STANDORT_BRUMBY_UID));
    }

    /**
     * action listCrimmitschau
     *
     * @return void
     */
    public function listCrimmitschauAction()
    {
        $this->view->assign('standorte', $this->getJobsByStandorte(self::STANDORT_CRIMMITSCHAU_UID));
    }

    private function getJobsByStandorte($standort = null)
    {
        $standorte = array();

        $jobs = $this->jobsRepository->findAll();
        foreach ($jobs as $job) {
            //$standort->attach($board);

            if(!$standort || $standort === $job->getJobSite()->getJobsiteUid()) {
                $jobSiteUid = $job->getJobSite()->getUid();
                $jobLevelUid = $job->getJobLevel()->getUid();
                if (!isset($standorte[$jobSiteUid])) {
                    $standorte[$jobSiteUid] = array(
                        'jobsite' => $job->getJobSite(),
                        'joblevels' => array()
                    );
                }
                if (!isset($standorte[$jobSiteUid]['joblevels'][$jobLevelUid])) {
                    $standorte[$jobSiteUid]['joblevels'][$jobLevelUid] = array(
                        'joblevel' => $job->getJobLevel(),
                        'jobs' => array()
                    );
                }
                $standorte[$jobSiteUid]['joblevels'][$jobLevelUid]['jobs'][] = $job;
            }
        }

        return $standorte;
    }
}
