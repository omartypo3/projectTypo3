<?php
namespace DslFactory\DslImmo\Controller;

/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * ImmobilieController
 */
class ImmobilieController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * immobilieRepository
     * 
     * @var \DslFactory\DslImmo\Domain\Repository\ImmobilieRepository
     */
    protected $immobilieRepository = null;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->immobilieRepository = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Repository\\ImmobilieRepository');

    }

    /*https://coding.musikinsnetz.de/typo3-extbase-fluid/general/automatic-page-cache-clearance-on-extension-record-update*/
    protected $typoScriptFrontendController = null;

    /**
     * Initializes the view before invoking an action method.
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     * 
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
     * @api
     * @return void
     */
    protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        $this->setCustomPathsInView($view);
    }

    /**
     * Set the TS defined custom paths in view
     * 
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @throws Exception
     */
    protected function setCustomPathsInView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        // overwrite a template via TS using plugin.EXTNAME.settings.controller.<ControllerName>.<actionName>.template
        $controllerName = $this->request->getControllerName();
        $actionName = $this->request->getControllerActionName();

        $template=NULL;
        if (
            isset($this->settings['controller']) &&
            isset($this->settings['controller'][$controllerName]) &&
            isset($this->settings['controller'][$controllerName][$actionName]) &&
            isset($this->settings['controller'][$controllerName][$actionName]['template'])
        ) {
            $template = $this->settings['controller'][$this->request->getControllerName()][$this->request->getControllerActionName()]['template'];
        }
        if (isset($this->settings['customTemplate'])) {
            $template = $this->settings['customTemplate'];
        }
        //print_r($this->settings);
        //echo ":".$templatePathAndFilename.":".time();die;
        //$templatePathAndFilename = 'typo3conf/ext/dsl_immo/Resources/Private/Templates/Immobilie/SearchHome.html';
        if ($template) {
            $view->setTemplate($this->request->getControllerName() . '/' . $template);
        }
    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        //echo "reload!!!häää";die;
        if (isset($_GET)) {
            if (isset($_GET['type'])) {
                if ($this->request->hasArgument('sort')) {
                //    echo $_GET['type'];
                  //  echo 'bla';
                    //	die;
                    $reload = true;
                } else {
                    $reload = false;
                }
            }
        }
        $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
        if (!isset($session['sorting'])) {
            //initialisierung beim ersten seitenladen
            $session['sorting'] = array(
                'field' => NULL, 'dir' => NULL, 'active' => NULL, 'key' => 0
            );
        }
        if ($this->request->hasArgument('sort')) {
            $session['sorting']['active'] = (int) $this->request->getArgument('sort');
            $reload = true;
        }
        if (!isset($session['listview'])) {
            //initialisierung beim ersten seitenladen
            $session['listview'] = 'grid';
        }
        if ($this->request->hasArgument('listview')) {
            $reload = true;
            switch ($this->request->getArgument('listview')) {
                case 'grid':    $session['listview'] = 'grid';
                    break;
                case 'list':    $session['listview'] = 'list';
                    break;
                case 'map':    $session['listview'] = 'map';
                    break;
            }
        }
        switch ($session['sorting']['active']) {
            case 1:    $session['sorting']['field'] = 'preiseKaltmiete';
                $session['sorting']['dir'] = 'ASC';
                $session['sorting']['icon'] = 'up';
                $session['sorting']['flag'] = 'SORT_NUMERIC';
                $session['sorting']['key'] = 1;
                $session['sorting']['title'] = 'Preis aufsteigend';
                break;
            case 2:    $session['sorting']['field'] = 'preiseKaltmiete';
                $session['sorting']['dir'] = 'DESC';
                $session['sorting']['icon'] = 'down';
                $session['sorting']['flag'] = 'SORT_NUMERIC';
                $session['sorting']['key'] = 2;
                $session['sorting']['title'] = 'Preis absteigend';
                break;
            case 3:    
            default:    $session['sorting']['field'] = 'tstamp';
                $session['sorting']['dir'] = 'DESC';
                $session['sorting']['icon'] = 'up';
                $session['sorting']['flag'] = 'SORT_NUMERIC';
                $session['sorting']['key'] = 3;
                $session['sorting']['title'] = 'Neueste Zuerst';
                break;
        }
        //print_r($session );die;
        //eigentlich überflüssig
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'dslImmoOutSessionData', $session);
        if ($reload) {
            //echo "reload!!!häää";die;
            //neuladen um post variablen zu entfernen
            $this->redirect('list');
        }
        $this->view->assign('session', $session);
        //für debug
        // $this->view->assign('sessionData', print_r($session, 1));
        //$this->view->assign('sortDir', 'DESC');
        //$this->view->assign('sortField', 'uid');
        //$immobilies = $this->immobilieRepository->findAll();
        $immobilies = $this->immobilieRepository->findBySearch($session);
        //$immobilien = $this->immobilieRepository->findByFilter($session['search']);
        $this->view->assign('immobilies', $immobilies);
        $this->view->assign('settings', $this->settings);
    }

    /**
     * action show
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function showAction(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        $this->view->assign('generiert', new \DateTime());
        $this->view->assign('settings', array_merge($this->settings, array('immobilie' => $immobilie)));
        $this->view->assign('immobilie', $immobilie);
    }

    /**
     * action search
     * 
     * @return void
     */
    public function searchAction()
    {
        //block zum refresh
        /*
                $immobilienRefresh = $this->immobilieRepository->findAll();
                foreach ($immobilienRefresh as $immobilie) {
                    $immobilie->refreshSearchVars();
                    $this->immobilieRepository->update($immobilie);
                }
                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        */

        //$session['search']['zimmer']
        $storeArgumentsInSession = true;
        if ($this->request->hasArgument('requestPreview')) {
            if ($this->request->getArgument('requestPreview')) {
                $storeArgumentsInSession = false;
                //nein also nur die treffer zählen
                //  echo "haa";die;
                $this->view->assign('switch', 'requestPreview');
            }
        }
        $reload = false;
        if ($storeArgumentsInSession) {
            $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
        } else {
            $session = array(
                'search' => array(

                )
            );
        }
        if (is_array($this->settings)) {
            if (is_array($this->settings['default'])) {
                if (is_array($this->settings['default']['immobilie'])) {
                    if (is_array($this->settings['default']['immobilie']['search'])) {
                        foreach ($this->settings['default']['immobilie']['search'] as $k => $v) {
                            if (!$session['search'][$k]) {
                                $session['search'][$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        /* neu wewobau anfang */
        if ($this->request->hasArgument('preisRange')) {
            $session['search']['preisRange'] = (int) $this->request->getArgument('preisRange');
            $reload = true;
            $session['search']['showList'] = true;
        }
        if ($this->request->hasArgument('flaecheRange')) {
            $session['search']['flaecheRange'] = (int) $this->request->getArgument('flaecheRange');
            $reload = true;
        }
        if ($this->request->hasArgument('zimmerRange')) {
            $session['search']['zimmerRange'] = (int) $this->request->getArgument('zimmerRange');
            $reload = true;
        }
        if ($this->request->hasArgument('geoLageGebietSet')) {
            $session['search']['geoLageGebietSet'] = $this->request->getArgument('geoLageGebietSet');
            $reload = true;
        }
        if ($this->request->hasArgument('geoEtageSet')) {
            $session['search']['geoEtageSet'] = $this->request->getArgument('geoEtageSet');
            //	print_r($session['search']['geoEtageSet']);die;
            $reload = true;
        }
        if ($this->request->hasArgument('ausstattungSet')) {
            $session['search']['ausstattungSet'] = $this->request->getArgument('ausstattungSet');
            $reload = true;
        }
        if ($this->request->hasArgument('objektTypSet')) {
            $session['search']['objektTypSet'] = $this->request->getArgument('objektTypSet');
            $reload = true;
        }
        /* neu wewobau ende */
        //key => bis
        $preisRangeArray = array(
            10 => 200,
            20 => 350,
            30 => 500,
            40 => 650,
            50 => 950,
            60 => 1500
        );
        //ab
        $wohnflaecheArray = array(
            10 => 0,
            20 => 0,
            30 => 0,
            40 => 0
        );
        //ab
        $zimmerArray = array(
            10 => 0,
            20 => 0,
            30 => 0,
            40 => 0,
            50 => 0
        );
        /*
        10">ab 1-Raum</v:form.select.option>
        									<v:form.select.option value="20">ab 2-Raum</v:form.select.option>
        									<v:form.select.option value="30">ab 3-Raum</v:form.select.option>
        									<v:form.select.option value="40">ab 4-Raum</v:form.select.option>
        									<v:form.select.option value="50">ab 5-Raum</v:form.select.option>
        */

        $preisRangeEnvironment = array();
        foreach ($preisRangeArray as $key => $preis) {
            $preisRangeEnvironment[$key] = array(
                'flaecheRange' => $wohnflaecheArray,
                'zimmerRange' => $zimmerArray
            );
            foreach ($wohnflaecheArray as $k => $v) {
                $preisRangeEnvironment[$key]['flaecheRange'][$k] = count($this->immobilieRepository->findByFilter(array('preisRange' => $key, 'flaecheRange' => $k)));
            }
            foreach ($zimmerArray as $k => $v) {
                $preisRangeEnvironment[$key]['zimmerRange'][$k] = count($this->immobilieRepository->findByFilter(array('preisRange' => $key, 'zimmerRange' => $k)));
            }
        }
        if ($this->request->hasArgument('wobatype')) {
            $session['search']['wobatype'] = (int) $this->request->getArgument('wobatype');
            $reload = true;
        }
        if ($this->request->hasArgument('gebiet')) {
            $session['search']['gebiet'] = (int) $this->request->getArgument('gebiet');
            $reload = true;
        }
        if ($this->request->hasArgument('flaeche')) {
            $arr = explode(';', (string) $this->request->getArgument('flaeche'));
            $session['search']['flaeche'] = array(
                'from' => $arr[0], 'to' => $arr[1]
            );
            $reload = true;
        }
        if ($this->request->hasArgument('preis')) {
            $arr = explode(';', (string) $this->request->getArgument('preis'));
            $session['search']['preis'] = array(
                'from' => $arr[0], 'to' => $arr[1]
            );
            $reload = true;
        }
        if ($this->request->hasArgument('zimmer')) {
            $arr = explode(';', (string) $this->request->getArgument('zimmer'));
            $session['search']['zimmer'] = array(
                'from' => $arr[0], 'to' => $arr[1]
            );
            $reload = true;
        }
        if ($this->request->hasArgument('vermarktung')) {
            $session['search']['vermarktung'] = (string) $this->request->getArgument('vermarktung');
            $reload = true;
        }
        if ($this->request->hasArgument('objektTyp')) {
            $session['search']['objektTyp'] = (string) $this->request->getArgument('objektTyp');
            $reload = true;
        }
        if ($this->request->hasArgument('geoLageGebiet')) {
            $session['search']['geoLageGebiet'] = (string) $this->request->getArgument('geoLageGebiet');
            $reload = true;
        }
        $additionalFilter = array('keller', 'haustiere', 'badewanne', 'parkplatz', 'balkon', 'aufzug');
        foreach ($additionalFilter as $field) {
            if ($this->request->hasArgument($field)) {
                if ($this->request->getArgument($field)) {
                    $session['search'][$field] = true;
                    $reload = true;
                } else {
                    unset($session['search'][$field]);
                }
            }
            if (!$this->request->getArguments() && $this->settings['disableAdditionalFilter']) {
                unset($session['search'][$field]);
            }
        }
        /*if ($this->request->hasArgument('gebiet')) {
          $session['search']['gebiet'] = (string)$this->request->getArgument('gebiet');
          $reload = true;
          }*/

        //print_r($session['search']);die;
        /*
        foreach($immobilien as $immobilie){
        	if(!$immobilie->getGeoKoordinatenBreitengrad() || !$immobilie->getGeoKoordinatenLaengengrad()){
        
        		if($geoCoord = \DslFactory\DslImmo\Utility\GeocodeUtility::init()->geocodeAddress($immobilie->getStrasseHausnummer().", ". $immobilie->getGeoPlz().", ".$immobilie->getGeoOrt())){
        			$immobilie->setGeoKoordinatenBreitengrad($geoCoord["breitengrad"]);
        			$immobilie->setGeoKoordinatenLaengengrad($geoCoord["laengengrad"]);
        			//$this->immobilieRepository->update($immobilie);
        		}
        		//$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        	}
        }
        */

        $fromToTempArr = $this->getFlaechenSearchVars($session);
        if ($fromToTempArr['from'] <= $fromToTempArr['to']) {
            $this->view->assign('flaeche', $fromToTempArr);
        }
        if ($this->request->hasArgument('flaecheFromTo')) {
            if ($fromToTempArr['from'] . ';' . $fromToTempArr['to'] != $this->request->getArgument('flaecheFromTo')) {
                $session['search']['flaeche'] = array('from' => $fromToTempArr['from'], 'to' => $fromToTempArr['to']);
            }
        }
        $fromToTempArr = $this->getPreiseSearchVars($session);
        if ($fromToTempArr['from'] <= $fromToTempArr['to']) {
            $this->view->assign('preis', $fromToTempArr);
        }
        if ($this->request->hasArgument('preisFromTo')) {
            if ($fromToTempArr['from'] . ';' . $fromToTempArr['to'] != $this->request->getArgument('preisFromTo')) {
                $session['search']['preis'] = array('from' => $fromToTempArr['from'], 'to' => $fromToTempArr['to']);
            }
        }
        $immobilien = $this->immobilieRepository->findByFilter($session['search']);
        //echo count($immobilien);
        $this->view->assign('immobilien', $immobilien);
        //prüfen ob der preis / flaechenfilter zu einer einschänkung also 0 ergebnissen geführt hat
        $tmpSession = $session['search'];
        unset($tmpSession['preis']);
        unset($tmpSession['flaeche']);
        $this->view->assign('maxResultsForSliders', count($this->immobilieRepository->findByFilter($tmpSession)));
        //		  $GLOBALS['TYPO3_DB']->debugOutput = false;
        if (!$storeArgumentsInSession) {
            /* ?>
               <div style="display:none;">Suche!!!: <?php 
               print_r(array($session));
               ?>
               </div><?php */

            echo $this->view->render();
            die;
            return;
        } else {
            //unset($session["search"]["geoEtageSet"]);
            //unset($session["search"]["ausstattungSet"]);
            //unset($session["search"]["geoLageGebiet"]);
            //unset($session["search"]["flaeche"]);
            //unset($session["search"]["preis"]);
            //unset($session["search"]["zimmer"]);
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'dslImmoOutSessionData', $session);
        }
        //$GLOBALS['TSFE']->fe_user->setKey('ses', 'dslImmoOutSessionData', $session);
        if ($this->request->hasArgument('reloadToPid')) {
            //echo "stop";echo $this->request->getArgument('reloadToPid');die;
            $uriBuilder = $this->uriBuilder;
            $uri = $uriBuilder->setTargetPageUid($this->request->getArgument('reloadToPid'))->build();
            //echo $uri;die;
            $this->redirectToURI($uri, $delay = 0, $statusCode = 303);
        }
        if ($reload) {
            //neuladen um post variablen zu entfernen
            //	$this->redirect('list');
            # External HTTP redirect to another controller
            //$this->redirect('list', 'Immobilie', 'immoout', array(), 72);
            //$this->forward($actionName, $controllerName, $extensionName, array $arguments);
            $uriBuilder = $this->uriBuilder;
            $uri = $uriBuilder->setTargetPageUid($this->settings['listPid'])->build();
            //echo $uri;die;
            $this->redirectToURI($uri, $delay = 0, $statusCode = 303);
        }
        $search = array(

        );
        //wird derzeit nur bei woba genutzt
        $from = (int) $this->immobilieRepository->getFlaechenAnzahlZimmerFrom();
        $to = (int) $this->immobilieRepository->getFlaechenAnzahlZimmerTo();
        if ($from < $to) {
            $this->view->assign('zimmer', array(
                'from' => $from, 'to' => $to
            ));
            if (!isset($session['search']['zimmer'])) {
                $session['search']['zimmer'] = array(
                    'from' => $from, 'to' => $to
                );
            }
        }
        $fromToTempArr = $this->getFlaechenSearchVars($session);
        if ($fromToTempArr['from'] < $fromToTempArr['to']) {
            $this->view->assign('flaeche', $fromToTempArr);
            if (!isset($session['search']['flaeche'])) {
                $session['search']['flaeche'] = $fromToTempArr;
            }
        }
        $fromToTempArr = $this->getPreiseSearchVars($session);
        if ($fromToTempArr['from'] < $fromToTempArr['to']) {
            $this->view->assign('preis', $fromToTempArr);
            if (!isset($session['search']['preis'])) {
                $session['search']['preis'] = $fromToTempArr;
            }
        }
        /* wewobau neu */
        $this->view->assign('wewobauAdditionalFilterActive', $this->getWewoAdditionalFilterActive($session['search']));
        /* wewobau neu ende */
        /* seeg neu */
        $this->view->assign('seegAdditionalFilterActive', $this->getSeegAdditionalFilterActive($session['search']));
        /* seeg neu ende */
        $this->view->assign('session', $session);
        //$session["search"]
        //$this->view->assign('search', $search);
        //$immobilien = $this->immobilieRepository->findAll();
        //$this->view->assign('immobilien', $immobilien);
        $searchEnvironment = \DslFactory\DslImmo\Utility\SearchUtility::init()->getSearchEnvironment();
        $this->view->assign('searchEnvironment', $searchEnvironment);
        $this->view->assign('preisRangeEnvironment', $preisRangeEnvironment);
        $this->view->assign('settings', $this->settings);
        /*neuseeg*/
        $this->view->assign('geoLageGebietSet', $this->immobilieRepository->getGeoLageGebietSet());
    }

    /**
     * @param $session
     */
    private function getPreiseSearchVars($session)
    {
        $fromWithoutFilter = (int) $this->immobilieRepository->getSearchPreisFrom();
        $toWithoutFilter = (int) $this->immobilieRepository->getSearchPreisTo();
        if ($fromWithoutFilter == $toWithoutFilter) {
            $toWithoutFilter++;
        }
        $from = (int) $this->immobilieRepository->getSearchPreisFrom($session['search']);
        $to = (int) $this->immobilieRepository->getSearchPreisTo($session['search']);
        if ($from == $to) {
            $to++;
        }
        //+1 um einem bug des jslider vorzubeugen
        return array('from' => $from, 'to' => $to, 'fromWithoutFilter' => $fromWithoutFilter, 'toWithoutFilter' => $toWithoutFilter);
    }

    /**
     * @param $session
     */
    private function getFlaechenSearchVars($session)
    {
        $fromWithoutFilter = (int) $this->immobilieRepository->getSearchFlaecheFrom();
        $toWithoutFilter = (int) $this->immobilieRepository->getSearchFlaecheTo();
        if ($fromWithoutFilter == $toWithoutFilter) {
            $toWithoutFilter++;
        }
        $from = (int) $this->immobilieRepository->getSearchFlaecheFrom($session['search']);
        $to = (int) $this->immobilieRepository->getSearchFlaecheTo($session['search']);
        if ($from == $to) {
            $to++;
        }
        //+1 um einem bug des jslider vorzubeugen
        return array('from' => $from, 'to' => $to, 'fromWithoutFilter' => $fromWithoutFilter, 'toWithoutFilter' => $toWithoutFilter);
    }

    /**
     * action ajax
     * 
     * @return void
     */
    public function ajaxAction()
    {
        $returnArr = false;
        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {
                case 'anfrage':    if ($this->request->hasArgument('immobilie')) {
                        $immobilie = $this->immobilieRepository->findByUid($this->request->getArgument('immobilie'));
                        $dbView = \DslFactory\DslImmo\Utility\ViewUtility::init()->getView('Immobilie/AnfrageEmailAdmin.html', $this->request->getControllerExtensionName());
                        $dbView->assign('immobilie', $immobilie);
                        $dbView->assign('arguments', $this->request->getArguments());
                        $dbView->assign('settings', $this->settings);
                        //echo $dbView->render();
                        $messageAdmin = new \TYPO3\CMS\Core\Mail\MailMessage();
                        $messageAdmin->setFrom(array(
                            $this->settings['absenderEmail'] => $this->settings['absenderName']
                        ));
                        $messageAdmin->setTo(array(
                            $this->settings['adminEmail'] => $this->settings['adminEmail']
                        ));
                        $messageAdmin->setReplyTo(array($this->request->getArgument('email') => $this->request->getArgument('name')));
                        $messageAdmin->setSubject($this->settings['adminBetreff']);
                        $messageAdmin->setBody($dbView->render());
                        $messageAdmin->send();
                        if ($messageAdmin->isSent()) {

                        } else {
                            echo 'false';
                            die;
                        }
                        $dbView = \DslFactory\DslImmo\Utility\ViewUtility::init()->getView('Immobilie/AnfrageEmailKunde.html', $this->request->getControllerExtensionName());
                        $dbView->assign('immobilie', $immobilie);
                        $dbView->assign('arguments', $this->request->getArguments());
                        $dbView->assign('settings', $this->settings);
                        $messageKunde = new \TYPO3\CMS\Core\Mail\MailMessage();
                        $messageKunde->setFrom(array(
                            $this->settings['absenderEmail'] => $this->settings['absenderName']
                        ));
                        $messageKunde->setTo(array(
                            $this->request->getArgument('email') => $this->request->getArgument('name')
                        ));
                        $messageKunde->setSubject($this->settings['anfrageBetreff']);
                        $messageKunde->setBody($dbView->render());
                        $messageKunde->send();
                        die;
                    }
                    break;
                case 'bookmark':    if ($this->request->hasArgument('immobilie')) {
                        $immobilie = $this->immobilieRepository->findByUid($this->request->getArgument('immobilie'));
                        $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
                        $status = '';
                        $content = '';
                        if (!$session['bookmarks']) {
                            $session['bookmarks'] = array(

                            );
                        }
                        if (in_array($immobilie->getUid(), $session['bookmarks'])) {
                            unset($session['bookmarks'][array_search($immobilie->getUid(), $session['bookmarks'])]);
                            // $array = array_values($array);
                            $status = 'empty';
                        } else {
                            $session['bookmarks'] = array_merge(array(
                                    $immobilie->getUid()
                                ),
                                $session['bookmarks']
                            );
                            $status = 'added';
                            $dbView = \DslFactory\DslImmo\Utility\ViewUtility::init()->getView('Immobilie/BookmarksItem.html', $this->request->getControllerExtensionName(), $this->request->getControllerName(), $this->request->getPluginName());
                            $dbView->assign('immobilie', $immobilie);
                            $dbView->assign('settings', $this->settings);
                            $content = $dbView->render();
                        }
                        $GLOBALS['TSFE']->fe_user->setKey('ses', 'dslImmoOutSessionData', $session);
                        $returnArr = array(
                            'bookmarkState' => $status, 'immobilie' => $immobilie->getUid(), 'bookmarks' => $session['bookmarks'], 'content' => $content
                        );
                    }
                    break;
            }
        }
        if ($returnArr) {
            return json_encode($returnArr);
        }
        header('HTTP/1.1 400 Bad Request');
        return json_encode(array(
                'error' => 'Bad request!'
            ));
    }

    /**
     * action import
     * 
     * @return void
     */
    public function importAction()
    {

    }

    /**
     * action belist
     * 
     * @return void
     */
    public function belistAction()
    {
        $immobilies = $this->immobilieRepository->findAll();
        /* verwaiste Objekte entfernen*/
        foreach ($immobilies as $immobilie) {
            $verwaisteAnhaenge = array();
            foreach ($immobilie->getAnhaenge() as $key => $anhang) {
                if (!$anhang->getDatei()) {
                    $verwaisteAnhaenge[] = $anhang;
                }
            }
            if (count($verwaisteAnhaenge)) {
                foreach ($verwaisteAnhaenge as $anhang) {
                    $immobilie->removeAnhaenge($anhang);
                }
                $this->immobilieRepository->update($immobilie);
            }
        }
        /* verwaiste Objekte entfernen ende*/
        $this->view->assign('immobilies', $immobilies);
    }

    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $newImmobilie
     * @return void
     */
    public function createAction(\DslFactory\DslImmo\Domain\Model\Immobilie $newImmobilie)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->immobilieRepository->add($newImmobilie);
        $this->redirect('belist');
    }

    /**
     * action edit
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $immobilie
     * @return void
     */
    public function editAction(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        $this->view->assign('immobilie', $immobilie);
    }

    /**
     * action update
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function updateAction(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        $this->addFlashMessage('Die Immobilie (' . $immobilie->getObjektNrextern() . ') wurde aktualisiert.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->immobilieRepository->update($immobilie);
        \DslFactory\DslImmo\Utility\CacheUtility::init()->resetImmobilie($immobilie->getUid());
        $this->redirect('belist');
    }

    /**
     * action delete
     * 
     * @param int $immobilieUid
     * @return void
     */
    public function deleteAction($immobilieUid)
    {
        //echo $immobilieUid;
        $immobilie = $this->immobilieRepository->findByUidBackend($immobilieUid);
        //echo $immobilie->getUid();
        //die;
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        if ($immobilie->getAnhaenge()) {
            foreach ($immobilie->getAnhaenge() as $anhang) {
                if ($anhang->getDatei()) {
                    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
                    $fileReferenceObject = $resourceFactory->getFileReferenceObject($anhang->getDatei()->getUid());
                    $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
                }
            }
        }
        $this->immobilieRepository->remove($immobilie);
        $this->redirect('belist');
    }

    /**
     * action bookmarks
     * 
     * @return void
     */
    public function bookmarksAction()
    {
        //$this->redirect('bookmarksfull');
        /*$session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
          $immobilien = false;
          if (isset($session['bookmarks'])) {
          if (is_array($session['bookmarks'])) {
          foreach ($session['bookmarks'] as $uid) {
          if ($immobilie = $this->immobilieRepository->findByUid($uid)) {
          if (!is_array($immobilien)) {
          $immobilien = array(
          );
          }
          $immobilien[] = $immobilie;
          }
          }
          }
          }*/

        $immobilien = $this->immobilieRepository->findByMerkliste($GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData'));
        //$immobilien = $this->immobilieRepository->findAllHighlights();
        //$immobilien = $this->immobilieRepository->findByUids($session['bookmarks']);
        $this->view->assign('settings', $this->settings);
        $this->view->assign('immobilien', $immobilien);
    }

    /**
     * action bookmarksfull
     * 
     * @return void
     */
    public function bookmarksfullAction()
    {
        //prüfen ob es weg kann
        $immobilien = $this->immobilieRepository->findByMerkliste($GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData'));
        /*$session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
          $immobilien = false;
          if (isset($session['bookmarks'])) {
          if (is_array($session['bookmarks'])) {
          foreach ($session['bookmarks'] as $uid) {
          if ($immobilie = $this->immobilieRepository->findByUid($uid)) {
          if (!is_array($immobilien)) {
          $immobilien = array(
          );
          }
          $immobilien[] = $immobilie;
          }
          }
          }
          }*/

        //$immobilien = $this->immobilieRepository->findByUids($session['bookmarks']);
        if (is_array($immobilien)) {
            $this->view->assign('immobilien', $immobilien);
        }
    }

    /**
     * action listhighlights
     * 
     * @return void
     */
    public function listhighlightsAction()
    {
        $filter = array('highlight' => true);
        if ($this->settings['vermarktung']) {
            $filter['vermarktung'] = $this->settings['vermarktung'];
        }
        if ($this->settings['objekttyp']) {
            $filter['objekttyp'] = $this->settings['objekttyp'];
        }
        $immobiliesHighlights = $this->immobilieRepository->findAllHighlights($filter);
        //print_r($filter);
        //$immobilies = $this->immobilieRepository->findBySearch($session);
        $immobiliesHighlightsAnzahl = 0;
        if ($immobiliesHighlights) {
            $this->view->assign('immobilies', $immobiliesHighlights);
            $immobiliesHighlightsAnzahl = count($immobiliesHighlights);
        }
        //echo $immobiliesHighlightsAnzahl;
        if ($immobiliesHighlightsAnzahl < $this->settings['limit']) {
            $this->settings['limitAdditional'] = $this->settings['limit'] - $immobiliesHighlightsAnzahl;
            $filter['highlight'] = false;
            //echo "additjklhkl";
            $immobiliesNoneHighlights = $this->immobilieRepository->findAllHighlights($filter);
            if ($immobiliesNoneHighlights) {
                $this->view->assign('immobiliesAdditional', $immobiliesNoneHighlights);
            }
        }
        $this->view->assign('settings', $this->settings);
    }
	
	
	/**
     * action listselected
     * 
     * @return void
     */
    public function listselectedAction()
    {
		$objekteFinalArr = array();
		
		$filter = array();
		if ($this->settings['objekte']) {
			//$objekteArr = explode(';',trim($this->settings['objekte']));
			$objekteArr = array();
			foreach(explode(';',trim($this->settings['objekte'])) as $objekt){
				if(trim($objekt)) $objekteArr[]=trim($objekt);
			}
			
            if(count($objekteArr)) {
				$filter['objekte'] = $objekteArr;
				
				$immobiliesSelected = $this->immobilieRepository->findAllSelected($filter);

				foreach($filter['objekte'] as $objekt){
					foreach($immobiliesSelected as $objekt2){
						if($objekt2->getObjektNrextern()==$objekt){
							$objekteFinalArr[] = $objekt2;
							break;
						}
					}
				}
			}
        }
		
		
		
		
		
		
		
		/*
        $filter = array('highlight' => true);
        if ($this->settings['vermarktung']) {
            $filter['vermarktung'] = $this->settings['vermarktung'];
        }
        if ($this->settings['objekttyp']) {
            $filter['objekttyp'] = $this->settings['objekttyp'];
        }
        $immobiliesHighlights = $this->immobilieRepository->findAllHighlights($filter);
        //print_r($filter);
        //$immobilies = $this->immobilieRepository->findBySearch($session);
        $immobiliesHighlightsAnzahl = 0;
        if ($immobiliesHighlights) {
            $this->view->assign('immobilies', $immobiliesHighlights);
            $immobiliesHighlightsAnzahl = count($immobiliesHighlights);
        }
        //echo $immobiliesHighlightsAnzahl;
        if ($immobiliesHighlightsAnzahl < $this->settings['limit']) {
            $this->settings['limitAdditional'] = $this->settings['limit'] - $immobiliesHighlightsAnzahl;
            $filter['highlight'] = false;
            //echo "additjklhkl";
            $immobiliesNoneHighlights = $this->immobilieRepository->findAllHighlights($filter);
            if ($immobiliesNoneHighlights) {
                $this->view->assign('immobiliesAdditional', $immobiliesNoneHighlights);
            }
        }*/
		$this->view->assign('immobiliesSelected', $objekteFinalArr);
        $this->view->assign('settings', $this->settings);
		$this->view->assign('filter', $filter);
    }

    /**
     * action listlatest
     * 
     * @return void
     */
    public function listlatestAction()
    {
        $immobilien = $this->immobilieRepository->findAll();
        $this->view->assign('immobilien', $immobilien);
        $this->view->assign('settings', $this->settings);
    }

    /**
     * action togglehighlight
     * 
     * @param int $immobilieUid
     * @return void
     */
    public function togglehighlightAction($immobilieUid)
    {
        $immobilie = $this->immobilieRepository->findByUidBackend($immobilieUid);
        if ($immobilie->getHighlight()) {
            $immobilie->setHighlight(0);
            $this->addFlashMessage('Immobilie (' . $immobilie->getObjektNrextern() . ') ist nun kein Highlight mehr.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        } else {
            $immobilie->setHighlight(1);
            $this->addFlashMessage('Immobilie (' . $immobilie->getObjektNrextern() . ') ist nun ein Highlight.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        }
        $this->immobilieRepository->update($immobilie);
        $this->redirect('belist');
    }

    /**
     * action beshow
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function beshowAction(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        $this->view->assign('immobilie', $immobilie);
    }

    /**
     * action browselinks
     * 
     * @return void
     */
    public function browselinksAction()
    {
        //print_r($_GET['tx_dslimmo_immoout']['immobilie']);
        $varsFromDetailPlugin = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_dslimmo_immoout');
        if (is_array($varsFromDetailPlugin)) {
            if (isset($varsFromDetailPlugin['immobilie'])) {
                if ($uid = (int) $varsFromDetailPlugin['immobilie']) {
                    $this->view->assign('uid', $uid);
                    if ($entry = $this->immobilieRepository->findByUid($uid)) {
                        if ($this->settings['browseOnlyinBookmarks']) {
                            $immobiliens = $this->immobilieRepository->findByMerkliste($GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData'));
                        } else {
                            $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'dslImmoOutSessionData');
                            $immobiliens = $this->immobilieRepository->findByFilter($session['search'], $session['sorting']);
                        }
                        //$this->view->assign('fahrzeuges', $fahrzeuges);
                        $prev = $this->getPrevItem($immobiliens, $entry);
                        $next = $this->getNextItem($immobiliens, $entry);
                        //	echo $prev;
                        //	echo $entry;
                        //	echo $next;
                        //echo "nextprev:";
                        $this->view->assign('prev', $prev);
                        $this->view->assign('next', $next);
                    }
                }
            }
        }
    }

    /**
     * @param $itemsArr
     * @param $items
     */
    public function getPrevItem($itemsArr, $items)
    {
        //		echo "<hr>getPrevItem (".count($itemsArr)."):<br>";
        //		echo $items."<br>";
        $last = false;
        foreach ($itemsArr as $item) {
            //			echo 'if ('.$item.' == '.$items.') {<br>';
            if ($item == $items) {
                //				echo "==";
                //				echo "last:".$last;
                //$this->debugLine("getPrevItem gleiches produkt gefunden!! (".$produkt->getTitel()."==".$produkte->getTitel().")");
                //$this->debugLine("getPrevItem gleiches produkt gefunden!! => last: ".$last->getTitel());
                return $last;
            }
            $last = $item;
        }
        return false;
    }

    /**
     * @param $itemsArr
     * @param $items
     */
    public function getNextItem($itemsArr, $items)
    {
        //		echo "<hr>getNextItem (".count($itemsArr)."):<br>";
        //		echo $items."<br>";
        $last = false;
        foreach ($itemsArr as $item) {
            //			echo 'if ('.$last.' == '.$items.') {<br>';
            if ($last == $items) {
                //$this->debugLine("getNextItem gleiches produkt gefunden!! (".$last->getTitel()."==".$produkte->getTitel().")");
                //$this->debugLine("getNextItem gleiches produkt gefunden!! => last: ".$produkt->getTitel());
                //				echo "==";
                //				echo "item:".$item;
                //$this->debugLine("get
                return $item;
            }
            $last = $item;
        }
        return false;
    }

    /* wewobau neu */
    /**
     * @param $filter
     */
    private function getWewoAdditionalFilterActive($filter)
    {
        $zaehler = 0;
        $filterArr = array('geoLageGebietSet', 'geoEtageSet', 'ausstattungSet', 'objektTypSet');
        foreach ($filterArr as $filterKey) {
            if ($filter[$filterKey]) {
                if (is_array($filter[$filterKey])) {
                    $zaehler += array_sum($filter[$filterKey]);
                } else {
                    $zaehler += (int) $filter[$filterKey];
                }
            }
        }
        return $zaehler;
    }

    /* seeg neu */
    /**
     * @param $filter
     */
    private function getSeegAdditionalFilterActive($filter)
    {
        $zaehler = 0;
        $filterArr = array('geoLageGebietSet', 'geoEtageSet', 'ausstattungSet', 'objektTypSet');
        foreach ($filterArr as $filterKey) {
            if ($filter[$filterKey]) {
                if (is_array($filter[$filterKey])) {
                    $zaehler += array_sum($filter[$filterKey]);
                } else {
                    $zaehler += (int) $filter[$filterKey];
                }
            }
        }
        return $zaehler;
    }

    /**
     * action detail
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function detailAction(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        $this->addCacheTags('tx_dslimmo_domain_model_immobilie_' . $immobilie->getUid());
        // the database table name of your domain model plus the UID of your record
        $this->view->assign('generiert', new \DateTime());
        $this->view->assign('settings', $this->settings);
        $this->view->assign('immobilie', $immobilie);
    }

    /**
     * @param $cacheTag
     */
    public function addCacheTags($cacheTag)
    {
        // do this only in frontend
        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            // only set the tag once in one request, so cache statically if it has been done
            static $cacheTagsSet = FALSE;
            /** @var $typoScriptFrontendController \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController  */
            $typoScriptFrontendController = $GLOBALS['TSFE'];
            if (!$cacheTagsSet) {
                $typoScriptFrontendController->addCacheTags(array($cacheTag));
                $cacheTagsSet = TRUE;
            }
            $this->typoScriptFrontendController = $typoScriptFrontendController;
        }
    }
}
