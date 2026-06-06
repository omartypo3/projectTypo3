<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * AufgabenController
 */
class AufgabenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * aufgabenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AufgabenRepository
     */
    protected $aufgabenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AufgabenRepository $aufgabenRepository
     */
    public function injectAufgabenRepository(\DslFactory\DslIntranet\Domain\Repository\AufgabenRepository $aufgabenRepository)
    {
        $this->aufgabenRepository = $aufgabenRepository;
    }
	
	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->aufgabenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AufgabenRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->frontendUserRepository  = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
        $this->zeiteintraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ZeiteintraegeRepository');
    }
	
	    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     */
    private function getFullcalendarEvent(\DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben)
    {
        if (!$aufgaben->getBegin()) {
            return false;
        }
        $begin = $aufgaben->getBegin()->format('Y-m-d');
        if ($aufgaben->getBegin()->format('H:i:s') != '00:00:00') {
            $begin .= 'T' . $aufgaben->getBegin()->format('H:i:s');
        }
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
      
	
		
		if ($aufgaben->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$aufgaben->getMitarbeiter()->_loadRealInstance();
		}
        $kuerzel='';
        $eventArr = array(
            'id' => $aufgaben->getUid(),
            'title' => $aufgaben->getNotizFuerKalender(),
            'kuerzel' => $kuerzel,
            'start' => $begin,
            'erledigt' => $aufgaben->getErledigt(),
            'mitarbeiter' => array(),
            'mitarbeiterUid' => $aufgaben->getMitarbeiter()->getUid()
        );
        //if($aufgaben->getAuftrag()) $eventArr['title'] = $aufgaben->getAuftrag()->getUid().': '.$eventArr['title'];
        //generate uri for delete
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
        $uriBuilder->setTargetPageType(89657201);
        $uriBuilder->setArguments(array(
            'tx_dslintranet_wochenlisteaufgabenplatzierung' => array(
                'controller' => 'Aufgaben',
                'action' => 'ajax',
                'uid' => $aufgaben,
                'switch' => 'delete'
            )
        ));
        $eventArr['uri_delete'] = $uriBuilder->build();
        //editieren
        $uriBuilder->setArguments(array(
            'tx_dslintranet_wochenlisteaufgabenplatzierung' => array(
                'controller' => 'Aufgaben',
                'action' => 'ajax',
                'uid' => $aufgaben,
                'switch' => 'edit'
            )
        ));
        $eventArr['uri_edit'] = $uriBuilder->build();
        //toggleErledigt
        $uriBuilder->setArguments(array(
            'tx_dslintranet_wochenlisteaufgabenplatzierung' => array(
                'controller' => 'Aufgaben',
                'action' => 'ajax',
                'uid' => $aufgaben,
                'switch' => 'toggleErledigt'
            )
        ));
        $eventArr['uri_toggleErledigt'] = $uriBuilder->build();
        if ($auftrag = $aufgaben->getAuftrag()) {
            if ($this->auftraegeRepository->findByUidCheckMitarbeiterGroup($auftrag->getUid())) {
                $eventArr['auftrag_uid'] = $auftrag->getUid();
            }
        }
        //		index.php?id=12&tx_dslintranet_auftragsliste%5Bauftraege%5D=1&tx_dslintranet_auftragsliste%5Baction%5D=show&tx_dslintranet_auftragsliste%5Bcontroller%5D=Auftraege&cHash=01dbd861cd8f6c27ad6415fb3fb0849a
        if ($aufgaben->getEnd()) {
            $end = $aufgaben->getEnd()->format('Y-m-d');
            if ($aufgaben->getEnd()->format('H:i:s') != '00:00:00') {
                $end .= 'T' . $aufgaben->getEnd()->format('H:i:s');
            }
            $eventArr['end'] = $end;
        }
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        //		$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        foreach ($mitarbeiters as $mitarbeiter) {
            $eventArr['mitarbeiter'][$mitarbeiter->getUid()] = array(
                'aktiv' => false,
                'uid' => $mitarbeiter->getUid(),
                'initialien' => $mitarbeiter->getInitialien(),
                'uri' => $uriBuilder->setArguments(array(
                    'tx_dslintranet_wochenlisteaufgabenplatzierung' => array(
                        'controller' => 'Aufgaben',
                        'action' => 'ajax',
                        'uid' => $aufgaben->getUid(),
                        'mitarbeiter' => $mitarbeiter->getUid(),
                        'switch' => 'setMitarbeiter'
                    )
                ))->build()
            );
            if ($mitarbeiter->getUid() == $aufgaben->getMitarbeiter()->getUid()) {
                $eventArr['mitarbeiter'][$mitarbeiter->getUid()]['aktiv'] = true;
            }
        }
        return $eventArr;
    }

    private function getAufgabensArr()
    {
        //      $user = $GLOBALS['TSFE']->fe_user->user;
        //        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();

        //        $settings = $mitarbeiter->getSettings();
        //print_r($this->request);die;
      
        if (!$this->request->hasArgument('init')) {
            $mitarbeiter->setGeoeffneterAuftrag(0);
            $this->mitarbeiterRepository->update($mitarbeiter);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
        //findByDateFilter
        if ($this->request->hasArgument('start') && $this->request->hasArgument('end')) {
            $begin = NULL;
            $end = NULL;
            if ($this->request->hasArgument('start')) {
                $begin = new \DateTime($this->request->getArgument('start'));
            }
            if ($this->request->hasArgument('end')) {
                $end = new \DateTime($this->request->getArgument('end'));
            }
            //echo $begin;
            $aufgabens = $this->aufgabenRepository->findByDateFilter($mitarbeiter, $begin, $end);

        } else {
            $aufgabens = $this->aufgabenRepository->findAll();

        }

        //		print_r($this->aufgabenRepository->getStoragePageIds());
        $aufgabenArr = array();
		if($aufgabens){
			foreach ($aufgabens as $aufgaben) {
				if ($eventArr = $this->getFullcalendarEvent($aufgaben)) {
					$aufgabenArr[] = $eventArr;
				}
			}
		}

        return $aufgabenArr;
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
		if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {

                case 'closeAuftrag':    if (!$this->request->hasArgument('auftragId')) {
                        break;
                    }
                    //z.B. #auftrag-show-8
                    $uid = $this->request->getArgument('auftragId');
                    $tmpArr = explode('-', $uid);
                    if (count($tmpArr) > 1) {
                        $uid = $tmpArr[count($tmpArr) - 1];
                    }
                    $auftrag = $this->auftraegeRepository->findByUid($uid);
                    if ($auftrag) {
                        $user = $GLOBALS['TSFE']->fe_user->user;
                        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
                        $mitarbeiter->removeOffeneAuftraege($auftrag);
                        $this->mitarbeiterRepository->update($mitarbeiter);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                    //echo 'mid:' . $mitarbeiter->getUid();
                    die;
                    break;
                case 'setMitarbeiter':    if (!$this->request->hasArgument('uid')) {
                        break;
                    }
                    //					break;
                    $aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('uid'));
					$begin = $aufgaben->getBegin();
					$begin->modify('-1 hour');
					$end = $aufgaben->getEnd();
					$end->modify('-1 hour');
					$aufgaben->setBegin($begin);
					$aufgaben->setEnd($end);
					$mitarbeiter = $this->mitarbeiterRepository->findByUid($this->request->getArgument('mitarbeiter'));
                    //					echo $mitarbeiter->getName();
                    //echo $aufgaben->getUid();
                    $aufgaben->setMitarbeiter($mitarbeiter);
                    //$aufgaben->setNotiz('bla');
                    $this->aufgabenRepository->update($aufgaben);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    if ($eventArr = $this->getFullcalendarEvent($aufgaben)) {
                        echo json_encode(array_merge($eventArr, array('args' => $this->request->getArguments())));
                    }
                    die;
                    //				echo $aufgaben->getNotiz();
                    //			break;
                    break;
                case 'toggleErledigt':    if (!$this->request->hasArgument('uid')) {
                        break;
                    }
                    $aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('uid'));
                    if ($aufgaben->isErledigt()) {
                        $aufgaben->setErledigt(false);
                    } else {
                        $aufgaben->setErledigt(true);
                    }
                    $this->aufgabenRepository->update($aufgaben);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    return $aufgaben->getErledigt();
                    break;
                case 'delete':    if ($aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($aufgaben);
                        return true;
                    }
                    break;
                case 'edit':    if (!$this->request->hasArgument('uid')) {
                        break;
                    }
                    $aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('uid'));
                    /*r aufgabenAjaxUrl = 'index.php?id=12&type=89657201&tx_dslintranet_wochenlisteaufgabenplatzierung%5Baction%5D=ajax&tx_dslintranet_wochenlisteaufgabenplatzierung%5Bcontroller%5D=Aufgaben';*/
                    //$this->redirect('edit', 'Aufgaben', NULL, array("aufgaben"=>$aufgaben));
                    //return "hello world:".$aufgaben->getNotiz();
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Aufgaben/Edit.html', $this->request->getControllerExtensionName());
                    //die;
                    $mitarbeiters = $this->mitarbeiterRepository->findAll();
                    $dbView->assign('mitarbeiters', $mitarbeiters);
                    //					foreach($mitarbeiters as $ma) echo $ma->getUid();
                    //				die;
                    //var_dump($mitarbeiters);
                    //die;
                    $dbView->assign('aufgaben', $aufgaben);
                    return $dbView->render();
                    break;

                case 'new':    $newAufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();
                    if ($this->request->hasArgument('auftragId')) {
                        $tmpArr = explode('_', $this->request->getArgument('auftragId'));
                        $auftraegeUid = $tmpArr[1];
                        $newAufgaben->setAuftrag($this->auftraegeRepository->findByUid($auftraegeUid));
                    }
                    if ($this->request->hasArgument('title')) {
                        $newAufgaben->setNotiz($this->request->getArgument('title'));
                    }
                    //   $user = $GLOBALS['TSFE']->fe_user->user;
                    //$mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
                    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $newAufgaben->setMitarbeiter($mitarbeiter);
                    //default
                    $settingsAufgabenArr = $mitarbeiter->getSettingsAufgaben();
                    if (isset($settingsAufgabenArr['aufgabenmitarbeiters'])) {
                        if (count($settingsAufgabenArr['aufgabenmitarbeiters']) == 1) {
                            $newAufgaben->setMitarbeiter($this->mitarbeiterRepository->findByUid($settingsAufgabenArr['aufgabenmitarbeiters']));
                        }
                    }
                    $newAufgaben->setCruser($mitarbeiter);
                    //$newAufgaben->setMitarbeiter($mitarbeiter);
                    if ($this->request->hasArgument('begin')) {
                        $newAufgaben->setBegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin'))));
                    }
                    if ($this->request->hasArgument('end')) {
                        $newAufgaben->setEnd(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('end'))));
                    }
                    $this->aufgabenRepository->add($newAufgaben);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    return json_encode($this->getFullcalendarEvent($newAufgaben));
                    break;
                case 'update':    if (!$this->request->hasArgument('uid')) {
                        break;
                    }
                    $aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('uid'));
                    if ($this->request->hasArgument('begin')) {
                        $aufgaben->setBegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin'))));
                    }
                    if ($this->request->hasArgument('end')) {
                        $aufgaben->setEnd(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('end'))));
                    }
					//\TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());
					//die();
                    $this->aufgabenRepository->update($aufgaben);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

					//die;
                    break;
                case 'newForm':
                    $newAufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();
                    if ($this->request->hasArgument('begin')) {
                        //$begin = new \DateTime($this->request->getArgument('begin'));
                        $begin = new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin')));
                        //$this->request->getArgument('begin')
                        //\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin'))
                        $newAufgaben->setBegin($begin);
                    }
                    if ($this->request->hasArgument('end')) {
                        $end = new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('end')));
                        $newAufgaben->setEnd($end);
                    }
                    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $newAufgaben->setMitarbeiter($mitarbeiter);
                    //default
                    $settingsAufgabenArr = $mitarbeiter->getSettingsAufgaben();
                    if (isset($settingsAufgabenArr['aufgabenmitarbeiters'])) {
                        if (count($settingsAufgabenArr['aufgabenmitarbeiters']) == 1) {
                            $newAufgaben->setMitarbeiter($this->mitarbeiterRepository->findByUid($settingsAufgabenArr['aufgabenmitarbeiters']));
                        }
                    }
                    //$newAufgaben->setMitarbeiter(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Aufgaben/New.html', $this->request->getControllerExtensionName());
					$mitarbeiters = $this->mitarbeiterRepository->findAll();
					

                    $dbView->assign('mitarbeiters', $mitarbeiters);
                    $dbView->assign('aufgaben', $newAufgaben);
                    return $dbView->render();
                    break;
            }
        }
        /*print_r($this->request->getArguments());
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        																																																																																																exit;*/

       /* header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request'));
        die;*/
        // try to always validate the incoming arguments
        if (!$this->request->hasArgument('uid') || intval($this->request->getArgument('uid')) == 0) {
            header('HTTP/1.1 400 Bad Request');
            return json_encode(array('error' => 'Bad request'));
        }
		die;
        $uid = intval($this->request->getArgument('uid'));
        $dataFromRepo = $this->myRepository->findByUid($uid);
        if ($dataFromRepo == null) {
            header('HTTP/1.1 404 Not found');
            return json_encode(
                array('error' => 'Not found or you have no access or something else... happens...')
            );
        }
        $resultArray = array(
            'field1' => $dataFromRepo->getField1()
        );
        return json_encode($resultArray);
		
       
       // return json_encode($resultArray);
    
        //return $this->htmlResponse();
    }

    /**
     * action listjson
     *
     * @return void
     */
    public function listjsonAction(): \Psr\Http\Message\ResponseInterface
    {
		//		$this->request->getArguments('start');
        //		$this->request->getArguments('end');
        //		echo print_r($this->request->getArguments(),1);
        //$urlaubController = new \DslFactory\DslIntranet\Controller\UrlaubController();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();

        $settings = $mitarbeiter->getSettingsAufgaben();


        if ($this->request->hasArgument('aufgabenmitarbeiters')) {
            //$settings['aufgabenmitarbeiters'] = explode(',', $this->request->getArgument('aufgabenmitarbeiters'));
            //$settings['aufgabenmitarbeiters'] = $this->request->getArgument('aufgabenmitarbeiters');


			$mitarbeiter->setSettingsAufgaben($this->request->getArgument('aufgabenmitarbeiters'));
            $this->frontendUserRepository->update($mitarbeiter);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        }
        $termineArr = array();
        $aufgabenArr = $this->getAufgabensArr();
        if ($aufgabenArr) {
            $termineArr = array_merge($termineArr, $aufgabenArr);
        }
        $filterUrlaub = array('status' => 20, 'begin' => new \DateTime());
		
        //"mitarbeiter"=>array(1),
        //foreach ($settings['aufgabenmitarbeiters'] as $mitarbeiterUid) {
        //        if ($ma = $this->mitarbeiterRepository->findByUid($mitarbeiterUid)) {
        /*if (is_array(isset($settings['aufgabenmitarbeiters']))) {
            if (count($settings['aufgabenmitarbeiters'])) {
                $filterUrlaub['mitarbeiter'] = $settings['aufgabenmitarbeiters'];
            }
        }*/
		if($this->request->hasArgument('aufgabenmitarbeiters')){
			$aufgabenmitarbeiters = $this->request->getArgument('aufgabenmitarbeiters');
			$filterUrlaub['mitarbeiter'] = explode(",",$aufgabenmitarbeiters);
		}
        //print_r($filterUrlaub["mitarbeiter"]);die;
        if ($this->request->hasArgument('start')) {
            $filterUrlaub['begin'] = new \DateTime($this->request->getArgument('start'));
        }
        if ($this->request->hasArgument('end')) {
            $filterUrlaub['end'] = new \DateTime($this->request->getArgument('end'));
        }
	
      

        $urlaubArr = \DslFactory\DslIntranet\Utility\UrlaubUtility::init()->getUrlaubTermineArr($filterUrlaub);

		if ($urlaubArr) {
            $termineArr = array_merge($termineArr, $urlaubArr);
        }

		$caldavSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('caldav');
		
		if(is_array($caldavSettings)){
			if (is_array($settings['aufgabenmitarbeiters'])) {
				if (count($settings['aufgabenmitarbeiters'])) {
					foreach($settings['aufgabenmitarbeiters'] as $mitarbeiterUid){
						if(!isset($caldavSettings["mitarbeiter".$mitarbeiterUid."."])) continue;
						
						
						foreach($caldavSettings["mitarbeiter".$mitarbeiterUid."."] as $kalenderMitarbeiter){
							foreach($kalenderMitarbeiter["kalender."] as $kalender){
								//echo $kalender;
								
								
								
								
								$caldavclient = \DslFactory\DslIntranet\Utility\CalDavClientUtility::init($kalenderMitarbeiter["host"], $kalenderMitarbeiter["user"], $kalenderMitarbeiter["passwort"]);//,$kalenderMitarbeiter["port"]
								$arrayOfCalendars = $caldavclient->findCalendars();/*?><pre><?php var_dump($arrayOfCalendars);?></pre><?php */
								if(!is_array($arrayOfCalendars)) continue;
								if(!count($arrayOfCalendars)) continue;
								if(!$arrayOfCalendars[$kalender]) continue;
								
								$caldavclient->setCalendar($arrayOfCalendars[$kalender]->getURL());
								if($filterUrlaub['begin'] &&  $filterUrlaub['end']){
									$events = $caldavclient->getEvents($filterUrlaub['begin']->format("Y-m-d")."T000000Z",$filterUrlaub['end']->format("Y-m-d")."T000000Z");//'20140418T103000Z', '20200419T200000Z'
								} else {
									$events = $caldavclient->getEvents();//'20140418T103000Z', '20200419T200000Z'
								}
								foreach($events as $key => $event){

									if($events[$key]["event"]->allDay) {
										$allDay = true; 
										$type = "extern";
									} else {
										$allDay = false; 
										$type = "extern";
									}
									$textArr = array();
									if($events[$key]["event"]->summary) if($events[$key]["event"]->summary) $textArr["summary"] = $events[$key]["event"]->summary;
									if($events[$key]["event"]->location) if($events[$key]["event"]->location) $textArr["location"] = $events[$key]["event"]->location;
									if($events[$key]["event"]->description) {
										$text = trim(trim(str_replace(array("\\n"," "),"",$events[$key]["event"]->description)));//das zu ersetzende freizeichen ist alt + 0160 (&nbsp;)
										if($text) $textArr["description"] = $text;
									}
									/*
									foreach($textArr as $k => $v){
										$textArr[$k] = trim(str_replace("\\n","",$v));
										if(!$textArr[$k]) unset($textArr[$k]);
									}*/

									$termineArr[] = array(
										"id"=>$events[$key]["event"]->uid,
										"title"=>implode(" / ",$textArr),
										"start"=>str_replace(" ","T",$events[$key]["event"]->dateStart),
										"end"=>str_replace(" ","T",$events[$key]["event"]->dateEnd),
										"allDay"=>$events[$key]["event"]->allDay,
										"mitarbeiterUid"=>$mitarbeiterUid,
										"type"=>$type,
										"durationEditable"=>false,
										"editable"=>false
									);

								}

								
								
								
//								$calDavSettings = array("mike","mz_0406",$kalender);
							}
							
						}

					}
				}
			}
		}

        echo json_encode($termineArr);
        die;
    }

    /**
     * action ical
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function icalAction(): \Psr\Http\Message\ResponseInterface
    {
		if (isset($_GET['login'])) {
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_GET['login'], 6)));
        }
        /*
        		wichtig htaccess
        		RewriteCond %{HTTP:Authorization} !^$
        RewriteCond %{REQUEST_METHOD} =GET
        RewriteCond %{QUERY_STRING} =""
        RewriteRule ^index.php$ index.php?login=%{HTTP:Authorization}$1 
        #https://user:pass@icalintranet.dsl-factory.de/index.php
        */

        /** @var $logger \TYPO3\CMS\Core\Log\Logger */
        /*
                $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
                $logger->warning('REDIRECT_HTTP_AUTHORIZATION:'.$_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
                $logger->warning('icalAction2');
                $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'icalAction3');
                $logVar = print_r($this->request->getArguments(), 1);
                $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, $logVar);
                $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, print_r(array($_GET, $_POST, $_SERVER), 1));
        */

        //apache_request_headers()
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($user = $this->initFeUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
                //if($user = $this->initFeUser ( "mike","mz_0406")){
                //$logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, print_r(array($user)),1);
                $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
                $begin = new \DateTime();
                date_sub($begin, date_interval_create_from_date_string('1 month'));
                $aufgabens = $this->aufgabenRepository->findByMitarbeiterDateFilter($mitarbeiter, $begin);
                $this->view->assign('aufgabens', $aufgabens);
                $this->view->assign('now', new \DateTime());
            }
        }
        if (!$user) {
            header('WWW-Authenticate: Basic realm="Authorisation erforderlich!"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        }
        return $this->htmlResponse();
    }
	
	
	 /**
     * @param $username
     * @param $password
     */
    public function initFeUser($username, $password)
    {
        $loginData = array(
            'uname' => $username,
            'uident_text' => $password,
            'status' => 'login'
        );
        $GLOBALS['TSFE']->fe_user->checkPid = 0;
        $info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
        $user = $GLOBALS['TSFE']->fe_user->fetchUserRecord($info['db_user'], $loginData['uname']);
        //Test3
        // plain-text password
        $password = $loginData['uident_text'];
        // salted user password hash
        $saltedPassword = $user['password'];
        // keeps status if plain-text password matches given salted user password hash
   
		$passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $passwordHashInstance = $passwordHashFactory->getDefaultHashInstance('FE');
		if ($passwordHashInstance->checkPassword($password, $saltedPassword)) {
			return $user;
		}
        return false;
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
       $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $mitarbeiter->checkValidFegroupChange();
        $auftraegesOffen = $mitarbeiter->getOffeneAuftraege();
        $zaehler = 0;
        $aktiverTab = 0;
        foreach ($auftraegesOffen as $auftraege) {
            //	if($auftraege) echo "<br>uid:".$auftraege->getUid();
            $zaehler++;
            if ($mitarbeiter->getGeoeffneterAuftrag() == $auftraege->getUid()) {
                $aktiverTab = $zaehler;
            }
            //$user = $GLOBALS['TSFE']->fe_user->user;
            //$mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
            if ($zeiteintraege = $this->zeiteintraegeRepository->findOpened($mitarbeiter, $auftraege)) {
                $auftraege->setCounterKontingent($zeiteintraege->getTrackerSeconds());
                $auftraege->setCounterZeitnahme($zeiteintraege->getZeitnahme());
                $auftraege->setMitarbeiterTracker($zeiteintraege);
            }
        }
        $this->view->assign('aktiverTab', $aktiverTab);
        $this->view->assign('auftraegesOffen', $auftraegesOffen);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);


//zusatz
$feuser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
$this->view->assign('feuser', $feuser);
$mitarbeitersExtern = clone $mitarbeiters;
if($feuser->getRechteExternerMitarbeiter()){
    foreach($mitarbeiters as $ma){
        if($ma->getUid()==$feuser->getUid()){
            $mitarbeitersExtern = [$ma];
            //
        }
    }
}
$this->view->assign('mitarbeitersExtern', $mitarbeitersExtern);




        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettingsAufgaben();
        $this->view->assign('settings', $settings);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('aufgaben', $aufgaben);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
	 * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $newAufgaben
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newAufgaben")
     * @return void
     */
    public function newAction(\DslFactory\DslIntranet\Domain\Model\Aufgaben $newAufgaben = NULL): \Psr\Http\Message\ResponseInterface
    {
		$newAufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();
        $newAufgaben->setBegin(new \DateTime());
        $newAufgaben->setEnd(new \DateTime());
        date_add($newAufgaben->getEnd(), date_interval_create_from_date_string('30 minutes'));
        $this->view->assign('aufgaben', $newAufgaben);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $newAufgaben->setMitarbeiter($mitarbeiter);
        //default
        $settingsAufgabenArr = $mitarbeiter->getSettingsAufgaben();
		if (isset($settingsAufgabenArr['aufgabenmitarbeiters'])) {
            if (count($settingsAufgabenArr['aufgabenmitarbeiters']) == 1) {
                $newAufgaben->setMitarbeiter($this->mitarbeiterRepository->findByUid($settingsAufgabenArr['aufgabenmitarbeiters']));
            }
        }
        //   $newAufgaben->setMitarbeiter(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        if ($this->request->hasArgument('auftraege')) {
            if ($auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'))) {
                $newAufgaben->setAuftrag($auftraege);
                $newAufgaben->setNotiz($auftraege->getTitelForAufgabe());
            }
        }
        echo $this->view->render();
        die;
    }

	
	    /**
     * action create
     * 
     * @return void
     */
    public function createAction()
    {
        $aufgaben = new \DslFactory\DslIntranet\Domain\Model\Aufgaben();
        $aufgaben = $this->updateAufgabeFromRequest($aufgaben);
        $this->aufgabenRepository->add($aufgaben);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        if ($eventArr = $this->getFullcalendarEvent($aufgaben)) {
            echo json_encode(array_merge($eventArr, array('args' => $this->request->getArguments())));
        }
        die;
    }
	
	/**
     * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     * @return \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     */
    private function updateAufgabeFromRequest($aufgaben)
    {
	
        if ($this->request->hasArgument('mitarbeiter')) {

            if ($mitarbeiter = $this->mitarbeiterRepository->findByUid((int)$this->request->getArgument('mitarbeiter')['__identity'])) {
                $aufgaben->setMitarbeiter($mitarbeiter);
            }
        }
		
        //        $user = $GLOBALS['TSFE']->fe_user->user;
        //        $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
        if (!$aufgaben->getCruser()) {
            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            $aufgaben->setCruser($mitarbeiter);
        }
        if (!$aufgaben->getMitarbeiter()) {
            $aufgaben->setMitarbeiter($mitarbeiter);
        }
        
        if ($this->request->hasArgument('begin')) {
            if ($this->request->hasArgument('beginTime')) {
                if ($this->request->hasArgument('beginTime') > $this->request->hasArgument('endTime')) {
                    $timeString = ' ' . $this->request->getArgument('endTime');
                } else {
                    $timeString = ' ' . $this->request->getArgument('beginTime');
                }
            } else {
                $timeString = '';
            }
            //$newBegin = $this->request->getArgument('begin');
            $aufgaben->setBegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('begin') . $timeString)));
        }
        //->getArgument('begin')
        if ($this->request->hasArgument('endTime')) {
            if ($this->request->hasArgument('beginTime') > $this->request->hasArgument('endTime')) {
                $timeString = ' ' . $this->request->getArgument('beginTime');
            } else {
                $timeString = ' ' . $this->request->getArgument('endTime');
            }
            //	$newEnd = $this->request->getArgument('end');
            //$aufgaben->getBegin()->format('d.m.Y')
            $aufgaben->setEnd(new \DateTime($aufgaben->getBegin()->format('d.m.Y') . $timeString));
        }
        if ($aufgaben->getBegin()->getTimestamp() > $aufgaben->getEnd()->getTimestamp()) {
            $tmpBegin = $aufgaben->getBegin();
            $tmpEnd = $aufgaben->getEnd();
            $aufgaben->setEnd($tmpBegin);
            $aufgaben->setBegin($tmpEnd);
        }
        if ($this->request->hasArgument('erledigt')) {
			$erledigt = ($this->request->getArgument('erledigt')) ? TRUE : FALSE;
            $aufgaben->setErledigt($erledigt);
        }
        if ($this->request->hasArgument('notiz')) {
            $aufgaben->setNotiz($this->request->getArgument('notiz'));
        }
        if ($this->request->hasArgument('auftrag')) {
            if ($auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftrag'))) {
                $aufgaben->setAuftrag($auftraege);
            }
        }

       /* \TYPO3\CMS\Core\Utility\DebugUtility::debug($aufgaben);
        die();*/
        return $aufgaben;
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("aufgaben")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('aufgaben', $aufgaben);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @return void
     */
    public function updateAction()
    {
        if ($this->request->hasArgument('aufgaben')) {
            $aufgaben = $this->aufgabenRepository->findByUid($this->request->getArgument('aufgaben')['__identity']);
            $aufgaben = $this->updateAufgabeFromRequest($aufgaben);
            $this->aufgabenRepository->update($aufgaben);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            if ($eventArr = $this->getFullcalendarEvent($aufgaben)) {
                echo json_encode(array_merge($eventArr, array('foo' => 'bar', 'args' => $this->request->getArguments())));
            }
        }
        die;
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Aufgaben $aufgaben)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->aufgabenRepository->remove($aufgaben);
        $this->redirect('list');
    }
}
