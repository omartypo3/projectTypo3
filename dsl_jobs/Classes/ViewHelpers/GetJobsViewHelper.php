<?php
namespace DslFactory\DslJobs\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetJobsViewHelper extends AbstractViewHelper{

    public function render() {
        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$jobsRepository = $objectManager->get('DslFactory\\DslJobs\\Domain\\Repository\\JobsRepository');

        $querySettings = $jobsRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(FALSE);
        $jobsRepository->setDefaultQuerySettings($querySettings);

        $jobs = $jobsRepository->findAll();

        $standorte = array();
        foreach ($jobs as $job) {
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

        return $standorte;
	}
}