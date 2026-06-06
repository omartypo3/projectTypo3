<?php
namespace DslFactory\DslJobs\Task;

use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use DslFactory\DslJobs\Domain\Repository\JobsRepository;
use DslFactory\DslJobs\Domain\Repository\JobSiteRepository;
use DslFactory\DslJobs\Domain\Repository\JobLevelRepository;


class ImportTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	
	/**
     * importRepository
     * 
     * @var \DslFactory\DslJobs\Domain\Repository\JobsRepository
     */
    protected $jobsRepository;
	
	/**
     * artikelgruppeRepository
     * 
     * @var \DslFactory\DslJobs\Domain\Repository\JobSiteRepository
     *
     */
    protected $jobSiteRepository;

	/**
     * artikelRepository
     * 
     * @var \DslFactory\DslJobs\Domain\Repository\JobLevelRepository
     *
     */
    protected $jobLevelRepository;
	

	/**
     * beginTime
     * 
     * @var \DateTime
     */
    protected $begin;			
	
	
	
	protected $objectManager;
	protected $persistenceManager;
	protected $flashMessageService;
	protected $messageQueue;	   
	   
	   
	 private function initializeCommand() {
		
		$this->begin = new \DateTime();
		 
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
		$this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		  
		
		$this->jobsRepository= $this->objectManager->get(JobsRepository::class);
		$this->jobSiteRepository= $this->objectManager->get(JobSiteRepository::class);		 
		$this->jobLevelRepository= $this->objectManager->get(JobLevelRepository::class);
		 
		
		$this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		$this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
			
		
      
    }	
    
    private function curlUrlContent($url){
        if(!$url) {
            echo "abbruch";
            return false;
        }

		$ch = curl_init();
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,120);
        curl_setopt ($ch,CURLOPT_TIMEOUT,120);
        curl_setopt ($ch,CURLOPT_MAXREDIRS,10);
     
        $content = curl_exec($ch);
        if($content) return $content; else return false;
        
    }

	public function execute() {
	  
		  
/*?><br><br><br><br><br><br><?php 		  */
		 //löschen alter importe 
		$this->initializeCommand();
        
        
        $jobListContent = $this->curlUrlContent('http://www.salzgitter-ag.com/fileadmin/scripts/jobexport/v2/joblist.php?hc[]=67');

        
        if($jobListContent){
            //echo "ja";
            $jobListXml = new \SimpleXMLElement($jobListContent);
            //echo count($jobListXml);

            $jobs = $this->jobsRepository->findAll();
            foreach($jobs as $job){
                $job->setHidden(true);
                $this->jobsRepository->update($job);
            }
            //$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

            foreach($jobListXml as $jobLink){

                //echo "<hr>each:";
                //echo $jobLink;
                if($jobContent = $this->curlUrlContent((string)$jobLink)){
                    $jobXml = new \SimpleXMLElement($jobContent);
                    if(count($jobXml)){
                        $jobid = (int)$jobXml->general->jobid;
                        echo (int)$jobXml->general->jobid;
                        echo (string)$jobXml->general->jobtitle;
                        $jobsiteUid = (int)$jobXml->general->jobsite->uid;
                        $joblevelId = (int)$jobXml->general->joblevel;

                        //Joblevel aus DB holen oder ggfls neu anlegen und die daten Aktualisieren
                        //0 Praktikum / 1 Ausbildung / 2 Stellenangebot

                        if(!$joblevel = $this->jobLevelRepository->findByJoblevelId($joblevelId)){
                            $joblevel = new \DslFactory\DslJobs\Domain\Model\JobLevel();
                            $joblevel->setJobLevel($joblevelId);
                            $this->jobLevelRepository->add($joblevel);
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        }
                        switch($joblevelId){
                            case 0: $joblevel->setBezeichnung('Praktikumsstellen'); break;//Praktikumsangebte
                            case 1: $joblevel->setBezeichnung('Ausbildungsberufe'); break;//Ausbildungsangebote
                            case 2: $joblevel->setBezeichnung('Berufserfahrene'); break;//Stellenangebote
                        }
                        $this->jobLevelRepository->update($joblevel);

                        //Unternehmen aus DB holen oder ggfls neu anlegen und die daten Aktualisieren
                        if(!$jobsite = $this->jobSiteRepository->findByJobsiteuid($jobsiteUid)){
                            $jobsite = new \DslFactory\DslJobs\Domain\Model\JobSite();
                            $jobsite->setJobsiteUid($jobsiteUid);
                            $this->jobSiteRepository->add($jobsite);
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        }
                        $jobsite->setCompany((string)$jobXml->general->jobsite->company);
                        $jobsite->setShortname((string)$jobXml->general->jobsite->shortname);
                        $jobsite->setCountry((string)$jobXml->general->jobsite->country);
                        $jobsite->setState((string)$jobXml->general->jobsite->state);
                        $jobsite->setZip((string)$jobXml->general->jobsite->zip);
                        $jobsite->setCity((string)$jobXml->general->jobsite->city);
                        $jobsite->setStreet((string)$jobXml->general->jobsite->street);
                        $jobsite->setStreetnumber((string)$jobXml->general->jobsite->streetnumber);
                        
                        $this->jobSiteRepository->update($jobsite);

                        //Jobangebot aus DB holen oder ggfls neu anlegen und die daten Aktualisieren
                        if(!$job = $this->jobsRepository->findByJobid($jobid)){
                            $job = new \DslFactory\DslJobs\Domain\Model\Jobs();
                            $job->setJobid($jobid);
                            $this->jobsRepository->add($job);
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        }


                        $job->setHidden((bool)$jobXml->general->inactive);
                        $job->setStarttime((int)$jobXml->general->start);
                        $job->setEndtime((int)$jobXml->general->end);
                        $job->setJobtitle((string)$jobXml->general->jobtitle);
                        $job->setDescriptionIntroHeading((string)$jobXml->description->intro->heading);
                        $job->setDescriptionIntroBody((string)$jobXml->description->intro->body);
                        $job->setDescriptionTasksHeading((string)$jobXml->description->tasks->heading);
                        $job->setDescriptionTasksBody((string)$jobXml->description->tasks->body);
                        $job->setDescriptionQualificationsHeading((string)$jobXml->description->qualifications->heading);
                        $job->setDescriptionQualificationsBody((string)$jobXml->description->qualifications->body);
                        $job->setDescriptionBenefitsHeading((string)$jobXml->description->benefits->heading);
                        $job->setDescriptionBenefitsBody((string)$jobXml->description->benefits->body);
                        $job->setDescriptionOutroBody((string)$jobXml->description->outro->body);

                        $job->setApplylinkLabel((string)$jobXml->description->applylink->label);
                        $job->setApplylinkUrl((string)$jobXml->description->sharelink);
                        $job->setSysLanguageUid(-1);
                        $job->setJobSite($jobsite);
                        $job->setJobLevel($joblevel);
//                        public function setJobSite(\DslFactory\DslJobs\Domain\Model\JobSite $jobSite)
//                        public function setJobLevel(\DslFactory\DslJobs\Domain\Model\JobLevel $jobLevel)

                        $job->setHidden(false);
                        $this->jobsRepository->update($job);

                        
                        


                    }
                    //echo "jaaa";
                    //echo count($jobXml);
                }

                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

                /*if($jobLinkPathinfo = parse_url($jobLink,PHP_URL_QUERY)){
                    echo "each";
                    echo $joblink;
                    ?><pre><?php print_r($jobLinkPathinfo);?></pre><?php 
                }*/
                
            }
        } else {
            //echo "nein";
        }
        
    
     //   foreach($xml->HAUPTKATEGORIE->KATEGORIE->ARTIKEL as $xmlArtikel){

       // }

//		$moduleSetup = \DslFactory\DslShopinterface\Utility\SettingsUtility::init()->getSetupForModule('tx_dslshopinterface_web_dslshopinterfaceinterface');
		//$exportLagerBestandToCSV = (string)$moduleSetup['settings.']['lagerBestandCsvFilename'];
/*?><pre><?php print_r(array(1,2,3,213,1,23,123,12,3,3,1231,31,23,123,1,23,123,));	?></pre><?php */
        //debug
		$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'ImportTask ausgeführt','DSL Jobs' ,	\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,false);
		$this->messageQueue->addMessage($message);
		
		
			
				
			//	$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'ImportTask ausgeführt','Zip Datei: '.$fileProperties['name'] ,	\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,false);
			//	$this->messageQueue->addMessage($message);
			

		
						
		//				if(!($merkmaleArr[$merkmalSchluessel] = $this->merkmaleRepository->findBySchluessel($merkmalSchluessel))){
		//					$merkmaleArr[$merkmalSchluessel] = new \DslFactory\DslShopinterface\Domain\Model\Merkmale();
							
		//					$this->merkmaleRepository->add($merkmaleArr[$merkmalSchluessel]);
		//					$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		
		
		
		
		//$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		
		
		//$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,'ImportTask ausgeführt','Optionaler Text  ' ,	\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,false);
		
			//$flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
			//$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
		//$this->messageQueue->addMessage($message);

		
         return TRUE; //ende gut, alles gut?
		
	}

	
}
