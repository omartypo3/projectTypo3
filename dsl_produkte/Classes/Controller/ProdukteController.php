<?php
namespace DslFactory\DslProdukte\Controller;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
/**
 * ProdukteController
 */
class ProdukteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->produkteRepository  = $this->objectManager->get('DslFactory\\DslProdukte\\Domain\\Repository\\ProdukteRepository');
        $this->zubehoerRepository  = $this->objectManager->get('DslFactory\\DslProdukte\\Domain\\Repository\\ZubehoerRepository');
        $this->anwendungsbereicheRepository  = $this->objectManager->get('DslFactory\\DslProdukte\\Domain\\Repository\\AnwendungsbereicheRepository');
    }

    protected $debug = true;

    protected $anwendungsbereicheRepository = NULL;
    protected $usedKategorien = false;
    protected $usedAnwendungsbereiche = false;
    protected $usedEigenschaften = false;
    protected $sortierungArr = array(
        /*		'sort' => array('titel' => 'Beste Ergebnisse', 'sortFunc' => 'getSorting', 'sortDir' => 'ASC', 'sortType' => 'float'),*/
        'titel' => array('titel' => 'Name aufsteigend', 'sortFunc' => 'getTitel', 'sortDir' => 'ASC', 'sortType' => 'string'),
        'titeldesc' => array('titel' => 'Name absteigend', 'sortFunc' => 'getTitel', 'sortDir' => 'DESC', 'sortType' => 'string'),
        /*		'artikelnummer' => array('titel' => 'Artikelnummer', 'sortFunc' => 'getArtikelnummer', 'sortDir' => 'ASC', 'sortType' => 'string'),*/
        /*		'preis' => array('titel' => 'Preis aufsteigend', 'sortFunc' => 'getPreis', 'sortDir' => 'ASC', 'sortType' => 'float'),
                'preisdesc' => array('titel' => 'Preis absteigend', 'sortFunc' => 'getPreis', 'sortDir' => 'DESC', 'sortType' => 'float'),*/
        /*		'crdate' => array('titel' => 'Datum aufsteigend', 'sortFunc' => 'getCrdate', 'sortDir' => 'ASC', 'sortType' => 'float'),
                'crdatedesc' => array('titel' => 'Datum absteigend', 'sortFunc' => 'getCrdate', 'sortDir' => 'DESC', 'sortType' => 'float'),*/
        'starttime' => array('titel' => 'Datum aufsteigend', 'sortFunc' => 'getStarttime', 'sortDir' => 'ASC', 'sortType' => 'float'),
        'starttimedesc' => array('titel' => 'Datum absteigend', 'sortFunc' => 'getStarttime', 'sortDir' => 'DESC', 'sortType' => 'float')
    );
    protected $sortierungDefault = 'starttimedesc';

    protected $perpageArr = array(
        /*		'c3' => array('titel'=>'3 pro Seite','val'=>3),*/
        'c9' => array('titel'=>'9 pro Seite','val'=>9),
        /*		'c12' => array('titel'=>'12 pro Seite','val'=>12),
                'c24' => array('titel'=>'24 pro Seite','val'=>24),*/
        'c30' => array('titel'=>'30 pro Seite','val'=>30),
        'c90' => array('titel'=>'90 pro Seite','val'=>90),
        'all' => array('titel'=>'Alle','val'=>999999)
    );
    protected $perpageDefault = 'c9';
    protected $perpage;

    protected $sortierung = false;
    protected $filter = array();
    protected $additionalFilter = array();
    public function initFilter() {
        $_ll_sortierung = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.sortierung', 'DslProdukte' );
        $_ll_datum = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.datum', 'DslProdukte' );
//		$_ll_preis = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.preis', 'DslProdukte' );
        $_ll_pro = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.pro', 'DslProdukte' );
        $_ll_alle =  \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.all', 'DslProdukte' );
        $_ll_seite =  \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.seite', 'DslProdukte' );
        $_ll_seiten =  \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.seiten', 'DslProdukte' );
        $_ll_aufsteigend = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.aufsteigend', 'DslProdukte' );
        $_ll_absteigend = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.absteigend', 'DslProdukte' );

        $llArr = array();
        foreach(array('sortierung','datum','pro','alle','seite','seiten','aufsteigend','absteigend') as $val)
            $llArr[$val] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'tx_dslprodukte_domain_model_produkte.'.$val, 'DslProdukte' );



        $this->sortierungArr['titel']['titel'] = 'Name '.$llArr['aufsteigend'];
        $this->sortierungArr['titeldesc']['titel'] = 'Name '.$llArr['absteigend'];
        $this->sortierungArr['starttime']['titel'] = $llArr['datum'].' '.$llArr['aufsteigend'];
        $this->sortierungArr['starttimedesc']['titel'] = $llArr['datum'].' '.$llArr['absteigend'];
        $this->perpageArr['c9']['titel']='9 '.$llArr['pro'].' '.$llArr['seite'];
        $this->perpageArr['c30']['titel']='30 '.$llArr['pro'].' '.$llArr['seite'];
        $this->perpageArr['c90']['titel']='90 '.$llArr['pro'].' '.$llArr['seite'];
        $this->perpageArr['all']['titel']=$llArr['alle'].' '.$llArr['seiten'];
        //variablen aus anderer Action übernehmen
        if($this->request->getPluginName()=="Produktbrowser"){
            if(isset($_GET["tx_dslprodukte_produktsuche"])) if(is_array($_GET["tx_dslprodukte_produktsuche"])) {
                foreach($_GET["tx_dslprodukte_produktsuche"] as $k => $v) {
                    $this->request->setArgument($k,$v);
                }
            }
        }

        $this->filter = array();
        foreach (array('anwendungsbereiche','eigenschaften', 'kategorien', 'zubehoer', 'set', 'sortierung','perpage') as $varname) {
            //Übergabe Variablen für den Filter welche geklickt wurden
            if ($this->request->hasArgument($varname)) {
                $this->filter[$varname] = $this->request->getArgument($varname);
            }
        }

        //test
        /*if(
            !$this->filter["sortierung"]
            && !$this->filter["perpage"]
            && !isset($this->filter["anwendungsbereiche"])
            && !isset($this->filter["kategorien"])
            && !isset($this->filter["zubehoer"])
            && $this->filter["set"]
        ) unset($this->filter["set"]);*/


        //$this->filter['sortierung'];
        if (isset($this->filter['sortierung'])) {
            $this->sortierung = $this->filter['sortierung'];
        } else {
            $this->sortierung = $this->sortierungDefault;
        }

        if (isset($this->filter['perpage'])) {
            $this->perpage = $this->filter['perpage'];
        } else {
            $this->perpage = $this->perpageDefault;
        }



    }
    public function assignFilterVars() {
        $produktes = $this->produkteRepository->findAllWithoutPidRestriction();
        //echo "anzahl produktes:".count($produktes);
        $usedKategorien = $this->getUsedKategorien($produktes);

        $this->view->assign('kategorien', $usedKategorien);
        $usedAnwendungsbereiche = $this->getUsedAnwendungsbereiche($produktes);
        $this->view->assign('anwendungsbereiche', $usedAnwendungsbereiche);
        $usedEigenschaften = $this->getUsedEigenschaften($produktes);
        $this->view->assign('eigenschaften', $usedEigenschaften);
//echo "\nanzahl usedEigenschaften:".count($usedEigenschaften);
//print_r($usedEigenschaften);
        $this->view->assign('filter', $this->filter);
        $this->view->assign('sortierungDefault', $this->sortierungDefault);
        $this->view->assign('sortierung', $this->sortierung);
        $sortArr = array();
        foreach ($this->sortierungArr as $k => $vArr) {
            $sortArr[$k] = $vArr['titel'];
        }
        $this->view->assign('sortArr', $sortArr);

        $this->view->assign('perpageDefault', $this->perpageDefault);
        $this->view->assign('perpage', $this->perpage);
        $perpageArr = array();
        foreach ($this->perpageArr as $k => $vArr) {
            $perpageArr[$k] = $vArr['titel'];
        }
        $this->view->assign('perpageArr', $perpageArr);
        $this->view->assign('itemsPerPage', $this->perpageArr[$this->perpage]["val"]);
        $this->view->assign('ajaxUri', $this->getAjaxUri());


        $this->view->assign('pushUri', $this->getListUri());
        //echo 'pushUriLoadFromFirst';
        $this->view->assign('pushUriLoadFromFirst', $this->getListUri(array('loadFromFirst'=>1)));
//		$this->debugLine('.pushUri.val():'.str_replace("&"," &",$this->getListUri()));
        //$this->view->assign('settings', $this->settings);



        $this->view->assign('linkArgumentsArr', $this->getListArguments());
        $this->view->assign('linkArgumentsWithoutCurrentPageArr', $this->linkArgumentsWithoutCurrentPageArr());
        $this->view->assign('datum',date("d.m.Y"));

    }


    protected $debugArr = array();
    public function debugLine($kommentar = ""){
        //var_dump(debug_backtrace());
        if($this->debug){
            $debugArr = debug_backtrace();
            $function = $debugArr[1]["function"];
            $line = $debugArr[0]["line"];
            if($kommentar) $kommentar = "  |  kommentar: ".$kommentar;
            $line = "function: ".$function."  |  line: ".$line.$kommentar."";

            $this->debugArr[] = $line;
            $this->view->assign('debugArr', print_r($this->debugArr,1));
        }
    }

    public function getProdukte(){


        $produktesFiltered = [];
        $this->initFilter();
        $this->assignFilterVars();

        $this->debugLine();

        /*		if ($this->filter['zubehoer'] || !isset($this->filter['set'])) {
                    $loadZubehoer = true;
                } else {*/
        $loadZubehoer = false;
        /*		}*/

        $this->debugLine("loadZubehoer: ".$loadZubehoer);
        $this->debugLine("filter[set]: ".$this->filter['set']);
        $this->debugLine("filter: ".print_r($this->filter,1));
        /*if (isset($this->filter['set'])) {

            $this->debugLine("if isset filter set: true");
            $this->debugLine("usedKategorien: ".print_r($this->usedKategorien,1));
            $this->debugLine("usedAnwendungsbereiche: ".print_r($this->usedAnwendungsbereiche,1));
            $this->debugLine("usedEigenschaften: ".print_r($this->usedEigenschaften,1));

            //if($this->filter['kategorien'] || $this->filter['anwendungsbereiche']){

            if(count($this->filter["kategorien"]) || count($this->filter["anwendungsbereiche"]) || count($this->filter["eigenschaften"])){
                $produktesFiltered = $this->produkteRepository->findByFilter($this->filter, $this->usedKategorien, $this->usedAnwendungsbereiche, $this->usedEigenschaften);
//echo "\nanzahl produktesFiltered:".count($produktesFiltered);
//print_r($this->usedEigenschaften);
                if ($loadZubehoer) {
                    $produktesFiltered = $this->addAdditionalData($produktesFiltered, $this->zubehoerRepository->findAllWithoutPidRestriction());
                //$produktesFiltered = $this->addfilteredZubehoer($produktesFiltered, $this->zubehoerRepository->findAllWithoutPidRestriction(), $this->filter, $this->usedKategorien, $this->usedAnwendungsbereiche);
                }
            } else {

                if($this->filter["zubehoer"]){
                    $this->debugLine("loadAllzubehör");
                    $produktesFiltered = $this->zubehoerRepository->findAllWithoutPidRestriction();
                    $this->debugLine("loadAllzubehör:anzahl:".count($produktesFiltered));
                }

            }




        }*/
        if(!$produktesFiltered){
            //} else {
            $this->debugLine("if(!produktesFiltered){");
            //if(!isset($produktesFiltered)) {
            $produktesFiltered = $this->produkteRepository->findAllWithoutPidRestriction();
            //if ($loadZubehoer) {
            //	$produktesFiltered = $this->addAdditionalData($produktesFiltered, $this->zubehoerRepository->findAllWithoutPidRestriction());
            //}
            $this->debugLine("anzahl: ".count($produktesFiltered));
        }

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();

        //übernahme von parametern bei zusatzsprachen aus default produkt
        if($sys_language_uid >0){
            $this->debugLine("if(GLOBALS['TSFE']->sys_language_uid>0");
            foreach($produktesFiltered as $entry){
                //echo '<hr><div>Produkt:'.$entry->getUid().":".$entry->getTitel().'</div>';
                if($produktDefault = $this->produkteRepository->findDefaultLanguageProdukt($entry)){
                    $rows = $this->getBilder($produktDefault['uid']);
                    $object = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                    foreach ($rows as $fileObject) {
                        $FileReference = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
                        $FileReference->_setProperty('uidLocal', $fileObject['uid_local']);
                        $FileReference->_setProperty('_localizedUid', $fileObject['uid']);
                        $FileReference->_setProperty('_languageUid', 0);
                        $FileReference->_setProperty('_versionedUid', $fileObject['uid']);
                        $FileReference->setPid($fileObject['pid']);
                        $FileReference->_setProperty('uid',$fileObject['uid']);
                        $object->attach($FileReference);
                    }
                    $entry->setBilder($object);
                    $this->debugLine("defaultProductLoaded:".$produktDefault["starttime"].":".$produktDefault["titel"]);
                    if(!$entry->getStarttime() && $produktDefault["starttime"] ) {
                        $entry->setStarttime( $produktDefault["starttime"] );
                        $this->debugLine("setStarttime: ".$produktDefault["starttime"]);
                    }
                }
            }
        }
        //	exit;
        $resArr = array();
        $this->debugLine("Filter: ".print_r($this->filter,1));
        $this->debugLine("produktesFiltered: ".count($produktesFiltered));
        foreach($produktesFiltered as $entry){
            $this->debugLine("---produkt:".$entry->getUid());
            //print_r($this->filter["kategorien"]);
            //exit;
            if(isset($this->filter["kategorien"])){ //wenn eine kategorie gefiltert wurde

                //wenn alle parameter übereinstimmen müssen
                /*foreach($this->filter["kategorien"] as $filterKat){
                    $validTmp=false;
                    foreach($entry->getKategorien() as $kat) if($kat->getUid()==$filterKat) { $validTmp=true; break;	}
                    if(!$validTmp) break;
                }*/
                //wenn nur ein parameter stimmen muss damit der artikel nicht ausgeschlossen wird
                $validTmp=false;
                foreach($entry->getKategorien() as $kat) {
                    if(in_array($kat->getUid(),$this->filter["kategorien"])) { $validTmp=true; break;}
                }


                if(!$validTmp){ $this->debugLine("Entry nicht in Kategoriefilter !!! fliegt raus "); continue; }
            }

            if(isset($this->filter["anwendungsbereiche"])){ //wenn ein Anwendungsbereich gefiltert wurde

                //wenn alle parameter übereinstimmen müssen
                /*foreach($this->filter["anwendungsbereiche"] as $filterAnw){
                    $validTmp=false;
                    foreach($entry->getAnwendungsbereiche() as $anw) if($anw->getUid()==$filterAnw) { $validTmp=true; break;	}
                    if(!$validTmp) break;
                }*/
                //wenn nur ein parameter stimmen muss damit der artikel nicht ausgeschlossen wird
                $validTmp=false;
                foreach($entry->getAnwendungsbereiche() as $anw) {
                    if(in_array($anw->getUid(),$this->filter["anwendungsbereiche"])) { $validTmp=true; break;}
                }

                if(!$validTmp){ $this->debugLine("Entry nicht in Anwendungsbereich !!! fliegt raus "); continue; }
            }

            if(isset($this->filter["eigenschaften"])){ //wenn ein Anwendungsbereich gefiltert wurde

                //wenn alle parameter übereinstimmen müssen
                /*foreach($this->filter["eigenschaften"] as $filterEig){
                    $validTmp=false;
                    foreach($entry->getEigenschaften() as $eig) if($eig->getUid()==$filterEig) { $validTmp=true; break;	}
                    if(!$validTmp) break;
                }*/
                //wenn nur ein parameter stimmen muss damit der artikel nicht ausgeschlossen wird
                $validTmp=false;
                foreach($entry->getEigenschaften() as $eig) {
                    if(in_array($eig->getUid(),$this->filter["eigenschaften"])) { $validTmp=true; break;}
                }


                if(!$validTmp){ $this->debugLine("Entry nicht in Eigenschaften !!! fliegt raus "); continue; }
            }

            /*
            if($this->filter["anwendungsbereiche"]){ //wenn eine kategorie gefiltert wurde
                $validTmp = true;
                foreach($entry->getAnwendungsbereiche() as $anw) {
                    if(!in_array($anw->getUid(),$this->filter["anwendungsbereiche"])){
                        $validTmp=false;
                        break;
                    }
                }
                if(!$validTmp){
                    $this->debugLine("Entry nicht in Anwendungsbereichsfilter !!! fliegt raus ");
                    continue;
                }
            }

            if($this->filter["eigenschaften"]){ //wenn eine eigenschaft gefiltert wurde
                $validTmp = true;
                foreach($entry->getEigenschaften() as $anw) {
                    if(!in_array($anw->getUid(),$this->filter["eigenschaften"])){
                        $validTmp=false;
                        break;
                    }
                }
                if(!$validTmp){
                    $this->debugLine("Entry nicht in Eigenschaftsfilter !!! fliegt raus ");
                    continue;
                }
            }
            */
            /*$this->debugLine("Produktart: ".$entry->getProduktart());
            if(($this->filter["anwendungsbereiche"] || $this->filter["kategorien"] || $this->filter["eigenschaften"]) && !$loadZubehoer && $entry->getProduktart()=="zubehoer"){ //wenn eine kategorie gefiltert wurde

                $this->debugLine("Entry fliegt raus da kein zubehör angezeigt werden soll !!! ");
                break;

            }	*/

            $resArr[] = $entry;

            $this->debugLine("produkt uid: ".$entry->getUid());
            $this->debugLine("produkt uid: ".$entry->getProduktart());
            foreach($entry->getKategorien() as $kat) $this->debugLine("kategorie: ".$kat->getUid()." ".$kat->getTitel());
            foreach($entry->getAnwendungsbereiche() as $anw) $this->debugLine("anwendungsbereich: ".$anw->getUid()." ".$anw->getTitel());
            foreach($entry->getEigenschaften() as $eig) $this->debugLine("eigenschaft: ".$eig->getUid()." ".$eig->getTitel());
        }

        $this->debugLine("Produkte gefiltert übrig: ".count($resArr));
        if(count($resArr)) $produktesFiltered = $resArr; else return array();

        $sortedProdukteArray = $this->getSortedByFieldname($produktesFiltered, $this->sortierungArr[$this->sortierung]['sortFunc'], $this->sortierungArr[$this->sortierung]['sortDir'], $this->sortierungArr[$this->sortierung]['sortType']);

        /*		foreach($sortedProdukteArray as $entry){
                    echo '<hr><div>Produkt:'.$entry->getUid().":".$entry->getTitel().'</div>';
                    $produktDefault = $this->produkteRepository->findDefaultLanguageProdukt($entry);
                    //var_dump($produktDefault);
                    echo "anzahlbilder:".count($produktDefault->getBilder());
                    echo "anzahlbilderEntry(vorher):".count($entry->getBilder());
                    if(count($produktDefault->getBilder())) $entry->setBilder($produktDefault->getBilder());
        //			var_dump($produktDefault->getBilder());
                    echo "anzahlbilderEntry:(nachher)".count($entry->getBilder());
                //	echo '<div>Bilder:'.$entry->getBilder().'</div>';
                }*/
//		echo "haaa!!";
        /*
                foreach($sortedProdukteArray as $entry){
                    echo "anzahlbilderEntry:".count($entry->getBilder());
                }*/
        //	exit;

        return $sortedProdukteArray;
    }
    /**
     * action list
     *
     * @return void
     */
    public function browseAction() {

        //print_r(t3lib_div::_GP('tx_dslprodukte_produktsuche'));

        if(isset($_GET['tx_dslprodukte_produktsuche']))	{
            //produkt
            if(isset($_GET['tx_dslprodukte_produktsuche']["produkte"])){
                $entry = $this->produkteRepository->findByUid($_GET['tx_dslprodukte_produktsuche']["produkte"]);//$_GET['tx_dslprodukte_produktsuche']["produkte"]
                //$produkt = $this->loadProdukt($_GET['tx_dslprodukte_produktsuche']["produkte"]);
            }
            //zubehoer
            if(isset($_GET['tx_dslprodukte_produktsuche']["zubehoer"])){
                $entry = $this->zubehoerRepository->findByUid($_GET['tx_dslprodukte_produktsuche']["zubehoer"]);
            }

        }
        if(isset($entry)){




            $this->view->assign('showNavigation', 1);

            $produktArr = $this->getProdukte();

            $prev = $this->getPrevItem($produktArr,$entry);
            $next = $this->getNextItem($produktArr,$entry);

            $this->view->assign('prev', $prev);
            $this->view->assign('next', $next);

        } else $this->view->assign('showNavigation', 0);
    }


    /**
     * action list
     *
     * @return void
     */
    public function listAction() {


        /*?><div id="debug"><h1>Request</h1><?php var_dump($this->request); echo time(); ?></div><?php 		*/
        $this->debugLine();
        $produkte = $this->getProdukte();



        $this->view->assign('produktes', $produkte);

        $this->view->assign('produkteGefunden', count($produkte));
        $this->debugLine("anzahlprodukte: ".count($produkte));
        $this->setMeta();
        $this->debugLine("ende");
    }

    function getPrevItem($produktArr,$produkte){
        $last = false;
        foreach($produktArr as $produkt){
            if($produkt == $produkte) {

                //$this->debugLine("getPrevItem gleiches produkt gefunden!! (".$produkt->getTitel()."==".$produkte->getTitel().")");
                //$this->debugLine("getPrevItem gleiches produkt gefunden!! => last: ".$last->getTitel());

                return $last;
            }
            $last = $produkt;
        }
        return false;
    }
    function getNextItem($produktArr,$produkte){
        $last = false;
        foreach($produktArr as $produkt){
            if($last == $produkte) {
                //$this->debugLine("getNextItem gleiches produkt gefunden!! (".$last->getTitel()."==".$produkte->getTitel().")");
                //$this->debugLine("getNextItem gleiches produkt gefunden!! => last: ".$produkt->getTitel());
                return $produkt;
            }
            $last = $produkt;
        }
        return false;
    }
    /**
     * action show
     *
     * @param \DslFactory\DslProdukte\Domain\Model\Produkte $produkte
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("produkte")
     * @return void
     */
    public function showAction(\DslFactory\DslProdukte\Domain\Model\Produkte $produkte) {
        $produktArr = $this->getProdukte();
        $this->view->assign('produkte', $produkte);


        $this->setMeta($produkte);

    }
    /**
     * action showzubehoer
     *
     * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer
     * @return void
     */
    public function showzubehoerAction(\DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer) {


        $produktArr = $this->getProdukte();

//		$prev = $this->getPrevItem($produktArr,$zubehoer);
//		$next = $this->getNextItem($produktArr,$zubehoer);
//		if($lastProdukt) echo "<br>LAST:".$lastProdukt->getUid()."!<br>"; else echo "nixlast!!";
//		if($nextProdukt) echo "<br>NEXT:".$nextProdukt->getUid()."!<br>"; else echo "nixnext!!";
//		echo "TITEL:".$zubehoer->getTitel();
//		echo $zubehoer->getProdukte();
//		$this->view->assign('prev', $prev);
//		$this->view->assign('next', $next);

        $this->view->assign('zubehoer', $zubehoer);
        $dbView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $dbView->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']) . 'Produkte/Datenblattzubehoer.html');
        $dbView->assignMultiple(array("produkt"=>$zubehoer,"datum"=>date("d.m.Y")));
        $this->view->assign('datenblatt', trim($dbView->render()));


        //	$this->view->assign('browse', "browsetimezub");

        $this->setMeta($zubehoer);
    }

    function setMeta($item = false){

        $title = '';
        $teaser = '';
        $keywords = '';
        if($item){
            $title = $item->getTitel();
            //if($title) $title = trim($this->settings["metaTitleBefore"].' '.$title.' '.$this->settings["metaTitleAfter"]);


            $keywords = $item->getKeywords();


            $teaser = $item->getTeaser();
            if(!$teaser) $teaser = $this->shortText($item->getText(),200,"&hellip;");


        } else {

        }

        if(!$teaser) $teaser = $this->settings["metaDescription"];
        if(!$keywords) $keywords = $this->settings["metaKeywords"];
        if(!$title) $title = $this->settings["metaTitle"];

        $GLOBALS['TSFE']->page['title'] .= " - ".$title;
        $GLOBALS['TSFE']->indexedDocTitle .= " - ".$title;

        $additionalHeaderData = '<title>' . $GLOBALS['TSFE']->page['title'] . '-</title>';
        $keywords = '<meta name="keywords" container="'.$keywords.'"/>';
        $description = '<meta name="description" container="'.$teaser.'"/>';
        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addHeaderData($additionalHeaderData);
        $pageRenderer->addHeaderData($keywords);
        $pageRenderer->addHeaderData($description);

    }

    /**
     * @param $productArr
     */
    public function getUsedKategorien($productArr) {
        if ($this->usedKategorien === false) {
            $this->usedKategorien = array();
            //$this->filterCategories = array();
            if (is_object($productArr)) {
                foreach ($productArr as $product) {
                    $kategorien = $product->getKategorien();
                    foreach ($kategorien as $key => $kategorie) {
                        /*if($kategorie->getUid()==7){ /*7 sind andere Anwendungen / other application*/
                        /*	$this->usedKategorien["ZZZZZZZZZZZZZ"] = $kategorie;
                        } else {*/
                        $this->usedKategorien[$kategorie->getUid()] = $kategorie;
                        /*}*/
                    }
                }

                //manuelle Sortierung Sprachenunabhängig
                if(count($this->usedKategorien)){
                    $resArr = array();
                    foreach(array(1,3,2,5,4,6,7) as $kUid) {
                        if(isset($this->usedKategorien[$kUid])) $resArr[$kUid] = $this->usedKategorien[$kUid];
                    }
                    $this->usedKategorien = $resArr;
                }

            }
        }
        return $this->usedKategorien;
    }
    /**
     * @param $productArr
     */
    public function getUsedAnwendungsbereiche($productArr) {
        if ($this->usedAnwendungsbereiche === false) {
            $this->usedAnwendungsbereiche = array();
            if (is_object($productArr)) {
                foreach ($productArr as $product) {
                    $anwendungsbereiche = $product->getAnwendungsbereiche();
                    foreach ($anwendungsbereiche as $key => $anwendungsbereich) {
                        $this->usedAnwendungsbereiche[strtoupper($anwendungsbereich->getTitel())] = $anwendungsbereich;
                    }
                }
                ksort($this->usedAnwendungsbereiche);
            }
        }
        return $this->usedAnwendungsbereiche;
    }
    /**
     * @param $productArr
     */
    public function getUsedEigenschaften($productArr) {
        if ($this->usedEigenschaften === false) {
            $this->usedEigenschaften = array();
            if (is_object($productArr)) {
                foreach ($productArr as $product) {
                    $eigenschaften = $product->getEigenschaften();
                    foreach ($eigenschaften as $key => $eigenschaft) {
                        $this->usedEigenschaften[strtoupper($eigenschaft->getTitel())] = $eigenschaft;
                    }
                }
                ksort($this->usedEigenschaften);
            }
        }
        return $this->usedEigenschaften;
    }
    /**
     * makeRedirect
     * @param string $action
     * @param string $controller
     * @param string $plugin
     * @param array $arguments
     *
     */
    private function makeRedirect($action=NULL, $controller=NULL, $plugin=NULL, $arguments=NULL) {
        if($this->redirectConfiguration !== NULL){
            $this->redirect(
                $this->redirectConfiguration["action"],
                $this->redirectConfiguration["controller"],
                NULL,
                array($this->redirectConfiguration["objectName"] => $this->redirectConfiguration["object"])
            );

        } elseif($action!==NULL){
            $this->redirect($action, $controller, $plugin, $arguments);
        } else {
            $this->redirect("list");
        }
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction() {
        //http://dslserver.dsl-factory.de/bftech/?tx_dslprodukte_produktsuche%5Bcontroller%5D=Produkte&tx_dslprodukte_produktsuche%5Baction%5D=ajax&type=6666&cHash=7f66a5dad8a6582313d0461831811979
        //http://dslserver.dsl-factory.de/bftech/?tx_dslprodukte_produktsuche%5Bcontroller%5D=Produkte&tx_dslprodukte_produktsuche%5Baction%5D=list&type=6666&cHash=7f66a5dad8a6582313d0461831811979
        //$this->redirectToURI("http://dslserver.dsl-factory.de/bftech/?tx_dslprodukte_produktsuche%5Bcontroller%5D=Produkte&tx_dslprodukte_produktsuche%5Baction%5D=list&type=6666");
        //	$this->makeRedirect("list", "Produkte", "Produktsuche", array("type"=>6666));

        //return $this->listAction();

        //$this -> view -> assign('irgendwas',"tata".time().' - BASEURL:'.$this->getListUri());
        return trim($this->view->render());
    }
    function getAjaxUri(){
        $key = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'produktsuche');
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
//		$uriBuilder->setTargetPageUid(20);
        $uriBuilder->setArguments(array(
            $key => array('controller' => 'Produkte', 'action' => 'list'),
            "type"=>6666,
            "noAjaxCacheVar"=>microtime()."zaehlerajaxcache"
            /*,
            "L"=>$GLOBALS['TSFE']->sys_language_uid*/
        ));
        //$uriBuilder->setTargetPageUid($this->settings["listPid"]);
//		return $uriBuilder->buildFrontendUri();
        $url = $uriBuilder->buildFrontendUri();
        $urlArr = explode("?",$url);
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        return "?".$urlArr[1]."&L=".$sys_language_uid;
    }
    function linkArgumentsWithoutCurrentPageArr(){
        $argumentsArr = $this->getListArguments();
        $key = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'produktsuche');
        if(isset($argumentsArr[$key]["@widget_0"])) unset($argumentsArr[$key]["@widget_0"]);
        return $argumentsArr;
    }
    function getListArguments(){

        $key = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'produktsuche');

        $arguments = $this->filter;
        if(count($this->additionalFilter)) $arguments = array_merge($arguments,$this->additionalFilter);

        /*?><pre><?php print_r($this->filter); ?></pre><?php */
        $argArr = array("controller"=>"Produkte","action"=>"list");
        //prüfen auf currentPage + evtl. mitgeben
        if ($this->request->hasArgument("@widget_0")) {
            $paginateArr = $this->request->getArgument("@widget_0");
            if(isset($paginateArr["currentPage"])) if($paginateArr["currentPage"]) $argArr["@widget_0"]["currentPage"] = $paginateArr["currentPage"];
        }
        $argumentArr = array(
            $key => array_merge($this->filter,$argArr)
        );

        $this->debugLine(print_r($argumentArr,1));
        /*?><pre><?php print_r($argumentArr);?></pre><?php
        exit;*/
        /*
        http://dslserver.dsl-factory.de/bftech/produktsuche/zubehoer/zub/?tx_dslprodukte_produktsuche[anwendungsbereiche][0]=1&tx_dslprodukte_produktsuche[anwendungsbereiche][1]=2&tx_dslprodukte_produktsuche[kategorien][0]=1&tx_dslprodukte_produktsuche[set]=1&tx_dslprodukte_produktsuche[sortierung]=preis&tx_dslprodukte_produktsuche[perpage]=c2&tx_dslprodukte_produktsuche[controller]=Produkte&tx_dslprodukte_produktsuche[action]=list&tx_dslprodukte_produktsuche[%40widget_0][currentPage]=2&cHash=e88848b84d9fefa2741a331d2bae906c
        */
        return $argumentArr;

    }

    function getListUri( $additionalArgumentsArr = array()){
        $key = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'produktsuche');
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
//dslmod		$this->initFilter();

        //if ($this->filter['set']) {

        $argArr = array('controller' => 'Produkte', 'action' => 'list');

        //prüfen auf currentPage + evtl. mitgeben
        if ($this->request->hasArgument("@widget_0")) {
            $paginateArr = $this->request->getArgument("@widget_0");
            if(isset($paginateArr["currentPage"])) if($paginateArr["currentPage"]) $argArr["@widget_0"]["currentPage"] = $paginateArr["currentPage"];
        }


        $argumentArr = array(
            $key => array_merge($this->filter, $argArr, $additionalArgumentsArr)
        );

//		if($GLOBALS['TSFE']->sys_language_uid) $argumentArr["L"] = $GLOBALS['TSFE']->sys_language_uid;

        $uriBuilder->setArguments($argumentArr);
        //	'L' => $GLOBALS['TSFE']->sys_language_uid


        $uriBuilder->setTargetPageUid($this->settings["listPid"]);


        //echo  $uriBuilder->buildFrontendUri();die;
        return $uriBuilder->buildFrontendUri();
    }

    /**
     * action search
     *
     * @return void
     */
    public function searchAction() {
        echo "searchAction!!!";
        $this->redirectToURI($this->getListUri());
        /*
        $key = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . 'produktsuche');
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $this->initFilter();
        if ($this->filter['set']) {
            $uriBuilder->setArguments(array(
                    $key => array_merge($this->filter, array('controller' => 'Produkte', 'action' => 'list'))
                ));
        }
        $this->redirectToURI($uriBuilder->buildFrontendUri());*/
    }
    /**
     * @param $data
     * @param $additionalData
     */
    public function addAdditionalData($data, $additionalData) {
        if (!$data) {
            return $additionalData;
        }
        foreach ($additionalData->toArray() as $item) {
            $data->offsetSet($data->count(), $item);
        }
        return $data;
    }
    /*kann evtl weg*/
    /*public function getSortedByTitel($data) {
            $tmpArr = array();
            foreach ($data->toArray() as $k => $v) {
                $funcname = "get"."Titel";
                $tmpArr[$k] = strtoupper(str_replace(array('ß'), array('ss'), $v->$funcname()));
            }
            //sortierung nach value
            asort($tmpArr);
            $resArr = array();
            foreach (array_keys($tmpArr) as $k) {
                $resArr[] = $data[$k];
            }
            return $resArr;
        }*/
    /**
     * @param $data
     * @param $sortFunc
     * @param $direction
     * @param $sorttype
     */
    public function getSortedByFieldname($data, $sortFunc, $direction, $sorttype) {
        //print_r(array($sortFunc, $direction, $sorttype));
        //die;
        $tmpArr = array();
        foreach ($data as $k => $v) {//->toArray()
            switch ($sorttype) {
                case 'string':
                    $tmpArr[$k] = strtoupper(str_replace(array('ß'), array('ss'), $v->{$sortFunc}()));
                    break;
                case 'float':
                    //echo "<br>:";
                    $tmpArr[$k] = floatval($v->{$sortFunc}());
                    break;
            }
        }
        //die;
        $this->debugLine("getSortedByFieldname: sorttype:".$sorttype);

        //sortierung nach value
        if ($direction == 'ASC') {
            asort($tmpArr);
        } else {
            arsort($tmpArr);
        }
        $this->debugLine("tmpArr: ".print_r($tmpArr,1));
        $resArr = array();
        foreach (array_keys($tmpArr) as $k) {
            $resArr[] = $data[$k];
        }
        return $resArr;
    }
    /**
     * Finds rechtsanwaelte by given filter parameter
     *
     * @param $data
     * @param $zubehoer
     * @param $filter
     * @param $kategorien
     * @param $anwendungsbereiche
     * @return array
     */
    public function addfilteredZubehoer($data, $zubehoer, $filter = false, $kategorien = false, $anwendungsbereiche = false) {
        foreach ($zubehoer as $k => $v) {
            //			echo '<div>checktoadd zub:' . $k . '</div>';
            /*$insert = 0;
            $tmpArr = array();
            foreach ($v->getAnwendungsbereiche() as $kAnwendungsbereich => $vAnwendungsbereich) {
                $tmpArr[] = $vAnwendungsbereich->getUid();
            }
            foreach ($filter['anwendungsbereiche'] as $anwendungsbereich) {
                if (in_array($anwendungsbereich, $tmpArr)) {
                    //					echo '<div>->anwendungsbereich...ok</div>';
                    $insert++;
                    break;
                }
            }
            $tmpArr = array();
            foreach ($v->getKategorien() as $kKategorien => $vkategorie) {
                $tmpArr[] = $vkategorie->getUid();
            }
            foreach ($filter['kategorien'] as $kategorie) {
                if (in_array($kategorie, $tmpArr)) {
                    //					echo '<div>->kat...ok</div>';
                    $insert++;
                    break;
                }
            }
            if ($insert == 2) {*/
            $data->offsetSet($data->count(), $v);
            //}
        }
        return $data;
    }
    /**
     * action showzubehoer
     *
     * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer
     * @return void
     */
    public function datenblattproduktAction(\DslFactory\DslProdukte\Domain\Model\Produkte $produkte) {
        //http://www.schmidtpublic.de/web-knowhow/article/pdf-mit-extbasefluid-erzeugen/

        $this->view->assign('datum',date("d.m.Y"));
        $this->view->assign('produkt', $produkte);
    }

    /**
     * action showzubehoer
     *
     * @param \DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer
     * @return void
     */
    public function datenblattzubehoerAction(\DslFactory\DslProdukte\Domain\Model\Zubehoer $zubehoer) {
//		$this->view->assign('next', $next);
    }

    /**
     * action sort
     *
     * @return void
     */
    public function sortAction() {

    }
    function shortText($text,$maxLength,$ending = "...") {
        $text = strip_tags($text);
        $tmp = wordwrap($text, $maxLength, "####");
        $tmp = explode("####",$tmp);
        if(count($tmp)>1) $tmp[0].=$ending;
        return $tmp[0];
    }
    /**
     * action opengraph
     *
     * @return void
     */
    public function opengraphAction() {
        if(isset($_GET['tx_dslprodukte_produktsuche'])) {
            if(isset($_GET['tx_dslprodukte_produktsuche']['produkte'])){
                $produkte = $this->produkteRepository->findByUid($_GET['tx_dslprodukte_produktsuche']['produkte']);
                //$produkte->pictures = $this->getPictures($fahrzeuge->getBildId());
                $this->view->assign('produkte', $produkte);
                $base = $GLOBALS['TSFE']->baseUrl;
                $explode = explode('://',$base);
                $explodeLast = explode('/',$explode[1]);
                if(count($explodeLast) > 1){
                    $baseUrl = $explode[0].'://'.$explodeLast[0];
                }else{
                    $baseUrl = $explode[0].'://'.$explode[1];
                }

                $this->view->assign('arguments', array('produkte'=>$produkte));
                $this->view->assign('baseUrl', $baseUrl);

            }
        }

    }

    public function getBilder($uid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $statement = $queryBuilder
            ->select('*')
            ->from('sys_file_reference')
            ->where($queryBuilder->expr()->eq('uid_foreign', $uid))
            ->andWhere($queryBuilder->expr()->eq('tablenames', '"tx_dslprodukte_domain_model_produkte"'))
            ->andWhere($queryBuilder->expr()->eq('fieldname', '"bilder"'))
            ->execute();

        $rows = $statement->fetchAll();

        return $rows;
    }
}