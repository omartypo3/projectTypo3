<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * MitarbeiterController
 */
class MitarbeiterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * mitarbeiterRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository
     */
    protected $mitarbeiterRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository $mitarbeiterRepository
     */
    public function injectMitarbeiterRepository(\DslFactory\DslIntranet\Domain\Repository\MitarbeiterRepository $mitarbeiterRepository)
    {
        $this->mitarbeiterRepository = $mitarbeiterRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->kanbanRepository  = $this->objectManager->get('DslFactory\\DslKanban\\Domain\\Repository\\KanbanRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
    }

    /**
     * action avatar
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function avatarAction(): \Psr\Http\Message\ResponseInterface
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $this->view->assign('mitarbeiter', $mitarbeiter);
        return $this->htmlResponse();
    }


    /**
     * action avatar
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kanbanAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('test', 'bla');
        return $this->htmlResponse();
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
        if ($this->request->hasArgument('switch')) {
            // echo "switch ja";

            $this->view->assign('switch', $this->request->getArgument('switch'));
            $this->view->assign('arguments', $this->request->getArguments());

            if($this->request->hasArgument('mitarbeiter')) {
                $kanbanMitarbeiter = $this->mitarbeiterRepository->findByUid($this->request->getArgument('mitarbeiter'));
                //echo "kma".$kanbanMitarbeiter->getUid();
            }
            if(!$kanbanMitarbeiter){
                //echo "nix gefunden ! wegen pid vermutlich";
                $kanbanMitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            }


            $kanbanTitel = 'IntranetMitarbeiterAufgaben-'.$kanbanMitarbeiter->getUid();

            //echo "such nach kanban mit dem titel: ".$kanbanTitel."<br>";
            if(!$kanban = $this->kanbanRepository->findByTitel( $kanbanTitel)){//
                //echo "kein Kanban gefunden!!<br>";
                $kanban = new \DslFactory\DslKanban\Domain\Model\Kanban();
                $kanban->setTitel($kanbanTitel);
                $this->kanbanRepository->add($kanban);
                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            } else {
                // echo "Kanbanerfolgreichgefunden!!<br>";
            }


            //echo "nachkanbansuche<br>";
            $fixBoards = array(
                "zuerledigen"=>'zu <strong>Erledigen</strong>',
                "bearbeitung"=>'in <strong>Bearbeitung</strong>',
                "wartestatus"=>'<strong>warten</strong> auf Rückmeldung / Zuarbeit',
                "fertig"=>'<strong>Fertig</strong>'
            );
            //prüfen ob die boards bereits existieren, evtl titel aktualisieren
            foreach($kanban->getBoard() as $board){
                if(isset($fixBoards[$board->getKuerzel()])){
                    $board->setTitel($fixBoards[$board->getKuerzel()]);
                    $board->setFixiert(true);
                    unset($fixBoards[$board->getKuerzel()]);
                } else {
                    $board->setFixiert(false);
                }
            }
            //verbleibende boards hinzufügen
            foreach($fixBoards as $kuerzel => $titel){
                $board = new \DslFactory\DslKanban\Domain\Model\Board();
                $board->setKuerzel($kuerzel);
                $board->setTitel($titel);
                $board->setFixiert(true);
                $kanban->addBoard($board);

            }

            //aufträge aus den bords entfernen wenn der status weiter als rechnung schreiben ist
            foreach($kanban->getBoard() as $board){
                foreach($board->getItems() as $item){
                    $keep = false;
                    if($item->getRelation()) {
                        $relArr = explode('-',$item->getRelation());
                        if($relArr[0]=="IntranetAuftrag"){
                            $auftrag = $this->auftraegeRepository->findByUid($relArr[1]);
                            if($auftrag) if($auftrag->getStatus()<70) $keep = true;
                        }
                    }
                    if(!$keep) $board->removeItem($item);
                }
            }

            //aufträge aus den ausgeblendeten entfernen wenn der status weiter als rechnung schreiben ist
            foreach($kanban->getItemsAusgeblendet() as $item){
                $keep = false;
                if($item->getRelation()) {
                    $relArr = explode('-',$item->getRelation());
                    if($relArr[0]=="IntranetAuftrag"){
                        $auftrag = $this->auftraegeRepository->findByUid($relArr[1]);
                        if($auftrag) if($auftrag->getStatus()<70) $keep = true;
                    }
                }
                if(!$keep) $kanban->removeItemsAusgeblendet($item);
            }

            $this->kanbanRepository->update($kanban);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();


            switch ($this->request->getArgument('switch')) {
                case 'changeKanbanBoardTitle':
                    if($this->request->hasArgument('board')){
                        $boardId = $this->request->getArgument('board');
                        $board = $kanban->getBoardByUid($this->request->getArgument('board'));
                        $board->setTitel($this->request->getArgument('titel'));
                        $this->kanbanRepository->update($kanban);

                    }
                    break;
                case 'deleteKanbanBoard':
                    if($this->request->hasArgument('board')){
                        $boardId = $this->request->getArgument('board');


                        $board = $kanban->getBoardByUid($this->request->getArgument('board'));
                        if($board){

                            if($board->getItems()){
                                if(count($board->getItems())){



                                    $items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();


                                    // echo "jaexistieren!!";
                                    //   echo count($board->getItems());
                                    foreach($board->getItems() as $item){
                                        $newItem = new \DslFactory\DslKanban\Domain\Model\Item();
                                        $newItem->setRelation($item->getRelation());
                                        $items->attach($newItem);

                                        //echo $item->getUid();
                                    }
                                    foreach($kanban->getItemsAusgeblendet() as $item) $items->attach($item);
                                    $kanban->setItemsAusgeblendet($items);

                                }
                            }


                            //if(count($board->getItems()))

                            $kanban->removeBoard($board);
                            //  echo "removed!!";
                            $this->kanbanRepository->update($kanban);
                        }



                    }
                    break;
                case 'addKanbanBoard':
                    if($this->request->hasArgument('titel')){
                        $board = new \DslFactory\DslKanban\Domain\Model\Board();
                        //$board->setKuerzel($kuerzel);
                        $board->setTitel($this->request->getArgument('titel'));
                        //$board->setFixiert(true);
                        $kanban->addBoard($board);
                        $this->kanbanRepository->update($kanban);
                    }
                    break;
                case 'resizeKanban':



                    if($this->request->hasArgument('styles')){
                        if ($styles = $this->request->getArgument('styles')) {
                            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();

                            /*$value = '';
                            if ($this->request->hasArgument('value')) {
                                $value = $this->request->getArgument('value');
                            }*/
                            $settings = $mitarbeiter->getSettingsAllgemein();
                            $settings["kanbanResize"] = $styles;
                            print_r($styles);
                            $mitarbeiter->setSettingsAllgemein($settings);
                            $this->mitarbeiterRepository->update($mitarbeiter);
                        }
                    }


                    break;

                case 'loadKanban':
                case 'loadKanbanContent':


                    //sleep(1);



//die;
                    $statuss = $this->getStatuss();
                    unset($statuss[70]);
                    foreach($statuss as $statusKey => $statusValue){
                        $statuss[$statusKey].=" (".count($this->auftraegeRepository->findByFilter(array('statuss' => array($statusKey)))).")";
                    }

                    $this->view->assign('statuss',$statuss);


                    $excludeAuftraegeArr = array();
                    foreach($kanban->getBoard() as $board){
                        foreach($board->getItems() as $item){
                            if($item->getRelation()) {
                                $relArr = explode('-',$item->getRelation());
                                if($relArr[0]=="IntranetAuftrag"){
                                    //$item->setTitel('');
                                    $auftrag = $this->auftraegeRepository->findByUid($relArr[1]);
                                    if($auftrag){
                                        $excludeAuftraegeArr[] = $relArr[1];
                                        $item->setRelationModel($this->auftraegeRepository->findByUid($relArr[1]));
                                        $item->setRelationName('auftrag');
                                    }
                                    //$auftraege->detach($auftrag);
                                }
                            }
                        }
                    }

                    foreach($kanban->getItemsAusgeblendet() as $item){
                        if($item->getRelation()) {
                            $relArr = explode('-',$item->getRelation());
                            if($relArr[0]=="IntranetAuftrag"){
                                //echo "auftrag entfernen!! (".$relArr[1].")";
                                $excludeAuftraegeArr[] = $relArr[1];
                                $item->setRelationModel($this->auftraegeRepository->findByUid($relArr[1]));
                                $item->setRelationName('auftrag');
                            }
                        }
                    }

                    $auftraege = $this->auftraegeRepository->findByFilter(array("statuss"=>array(10,20,30,40,50,60)), false, false, array(), false, false,$excludeAuftraegeArr);

                    $mitarbeiters = $this->mitarbeiterRepository->findAll();
                    $this->view->assign('mitarbeiters', $mitarbeiters);

                    $this->view->assign('auftraege', $auftraege);
                    $this->view->assign('kanban', $kanban);
                    $this->view->assign('mitarbeiter', $kanbanMitarbeiter);
                    $this->view->assign('returnString', json_encode(array(true,"newboards"=>array(1,2,3),"last keyfound"=>123)));
                    break;
                case 'removeKanbanItem':
                    if($this->request->hasArgument('item')){
                        $kanbanItemUid = $this->request->getArgument('item');

                        $oldItem = false;

                        foreach($kanban->getBoard() as $board){

                            //prüfen ob das item schon in einem board existiert
                            foreach($board->getItems() as $item){
                                if($item->getUid()==$kanbanItemUid){
                                    $oldItem = clone $item;
                                    $board->removeItem($item);
                                }
                            }
                        }

                        if($relation = $oldItem->getRelation()){
                            $newItem = new \DslFactory\DslKanban\Domain\Model\Item();
                            $newItem->setRelation($relation);

                            //$kanban->addItemsAusgeblendet($newItem);

                            //newItem als erstes ergänzen
                            $items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                            $items->attach($newItem);
                            foreach($kanban->getItemsAusgeblendet() as $item) $items->attach($item);
                            $kanban->setItemsAusgeblendet($items);


                        }
                        $this->kanbanRepository->update($kanban);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        $this->view->assign('returnString', json_encode(array("newKanbanItemUid"=>$newItem->getUid())));

                    }
                    break;
                case 'toggleKanbanAuftragToAusgeblendet': //ausblenden
                    if($this->request->hasArgument('item')){
                        $saveItem = $this->request->getArgument('item');
                        if($saveItem["auftragUid"]){

                            $relation = "IntranetAuftrag-".$saveItem["auftragUid"];
                            $newItem = new \DslFactory\DslKanban\Domain\Model\Item();
                            $newItem->setRelation($relation);
                            //$kanban->addItemsAusgeblendet($newItem);

                            //newItem als erstes ergänzen
                            $items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                            $items->attach($newItem);
                            foreach($kanban->getItemsAusgeblendet() as $item) $items->attach($item);
                            $kanban->setItemsAusgeblendet($items);





                            $this->kanbanRepository->update($kanban);

                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            $this->view->assign('returnString', json_encode(array("newKanbanItemUid"=>$newItem->getUid())));

                            //   $this->view->assign('returnString', json_encode($saveItem));
                        }
                    }

                    break;
                case 'toggleKanbanAuftragFromAusgeblendet': //also einblenden

                    if($this->request->hasArgument('item')){
                        $kanbanItemUid = $this->request->getArgument('item');

                        if($kanbanItemUid){


                            $item = $kanban->getItemAusgeblendetByUid($kanbanItemUid);
                            if($item){
                                $kanban->removeItemsAusgeblendet($item);
                                $this->kanbanRepository->update($kanban);
                            }

                            $this->view->assign('returnString', json_encode($saveItem));
                        }
                    }

                    break;
                case 'sortKanbanBoard':
                    if($this->request->hasArgument('item')){
                        $items = $this->request->getArgument('item');
                        if($kanban->moveBoardBefore($items["sourceBoardUid"],$items["targetBoardUid"])){
                            $this->kanbanRepository->update($kanban);
                        }
                    }

                    break;
                case 'moveKanbanBoardToLast':
                    if($this->request->hasArgument('item')){
                        $items = $this->request->getArgument('item');
                        if($kanban->moveBoardToEnd($items["boardUid"])){
                            $this->kanbanRepository->update($kanban);
                        }

                    }
                    break;
                case 'saveKanbanItem':
                    if($this->request->hasArgument('item')){
                        $saveItem = $this->request->getArgument('item');
                        //suche nach bestehendem Item

                        $oldItem = false;

                        $boardToSave = false;


                        $relation = "IntranetAuftrag-".$saveItem["auftragUid"];


                        /*aus den ausgeblendeten Aufträgen entfernen falls dieser dort noch drauf sein sollte*/

                        foreach($kanban->getItemsAusgeblendet() as $item){
                            if($item->getRelation()) {
                                $relArr = explode('-',$item->getRelation());
                                if($relArr[0]=="IntranetAuftrag"){
                                    if($relArr[1]==$saveItem["auftragUid"]){
                                        $kanban->removeItemsAusgeblendet($item);
                                    }

                                }
                            }
                        }



                        //$saveItem["prevKanbanItemUid"]; // wenn das existiert

                        //board finden auf welchem das item gespeichert wird
                        foreach($kanban->getBoard() as $board){

                            //das board finden und setzuen
                            if($board->getUid()==$saveItem["boardUid"]) $boardToSave = $board;

                            //prüfen ob das item schon in einem board existiert
                            foreach($board->getItems() as $item){
                                if($item->getRelation()==$relation){
                                    $oldItem = $item;
                                }
                            }
                        }
                        if($oldItem){
                            $item = clone $oldItem;
                            if($boardToSave) {
                                $boardToSave->addItem($item);//
                            }

                        } else {
                            $item = new \DslFactory\DslKanban\Domain\Model\Item();
                            $item->setRelation($relation);
                            $boardToSave->addItem($item);
                            //$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            //$this->view->assign('info',"neues item erstellt !!!");


                            //echo "neu einfügen in board ".$new["board"]->getUid()." !!!";die;
                        }
                        if($saveItem["auftragUid"]){
                            //auftrag laden und ggfls inhalte übernehmen
                            $auftrag = $this->auftraegeRepository->findByUid($saveItem["auftragUid"]);
                            $item->setTitel('kopie: '.$auftrag->getTitel());
                        }
                        $this->kanbanRepository->update($kanban);


                        foreach($boardToSave->getItems() as $existendItem){
                            if($existendItem->getUid()==$item->getUid()){
                                $itemToInsert = $existendItem;
                                break;
                            }
                        }

                        $items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                        if(!isset($saveItem["prevKanbanItemUid"])){//das item muss das erste sein
                            //   $items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                            $items->attach($itemToInsert);
                            /*foreach($boardToSave->getItems() as $existendItem){
                                if($existendItem->getUid()==$item->getUid()){
                                    $items->attach($existendItem);
                                }
                            }*/
                            foreach($boardToSave->getItems() as $existendItem){
                                if($existendItem->getUid()!=$item->getUid()){
                                    $items->attach($existendItem);
                                }
                            }

                        } else { //das item hat einen vorgänger
                            //$items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

                            foreach($boardToSave->getItems() as $existendItem){
                                if($existendItem->getUid()!=$itemToInsert->getUid()){
                                    $items->attach($existendItem);
                                    if($existendItem->getUid()==$saveItem["prevKanbanItemUid"]){
                                        $items->attach($itemToInsert);
                                    }

                                }

                            }
                            //$boardToSave->setItems($items);
                        }
                        $boardToSave->setItems($items);
                        $this->kanbanRepository->update($kanban);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        $this->view->assign('returnString', json_encode(array("newKanbanItemUid"=>$item->getUid())));

                        //$item->setNotiz((string)$auftrag);

                    }

                    break;
                case 'changeKanbanBoards':


                    $this->view->assign('returnString', json_encode(array(true,"newboards"=>array(1,2,3),"last keyfound"=>123)));

                    //$mitarbeiter->setSettingsKanban($resArr["boards"]);
                    //$this->mitarbeiterRepository->update($mitarbeiter);

                    //$resArr["boards"]
                    break;

                case 'abc':
                    //
                    break;
                case 'def':

                    //...
                    //$this->view->assign('returnString', json_encode($newBoard));

                    break;


                default:    die;
                    break;
            }

            //if($settingsBoards) $this->view->assign('settingsBoards', $settingsBoards);
        }
    }

    private function getStatuss()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5) {
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.statusnr.' . $status[1], 'dsl_intranet',[],'de') . '. ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.status.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }

    /**
     * action settings
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function settingsAction(): \Psr\Http\Message\ResponseInterface
    {
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		$settings =[];
        if ($this->request->hasArgument('key')) {
            if ($key = $this->request->getArgument('key')) {
                $value = '';
                if ($this->request->hasArgument('value')) {
                    $value = $this->request->getArgument('value');
                }
                /*$settings = $mitarbeiter->getSettingsAllgemein();
				if(is_array($settings)){
					$settings[$key] = $value;
					$settings = json_encode($settings);
				}*/
				
				if($value == 'horizontal'){
					
					$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
					$queryBuilder
						->update('fe_users')
						->where(
							$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($mitarbeiter->getUid(), Connection::PARAM_INT))
						)
						->set('settings_allgemein', 'a:1:{s:13:"projekteSplit";s:10:"horizontal";}')
						->executeStatement();
				}else{
					$settings[$key] = $value;
					$settings = serialize($settings);
					$mitarbeiter->setSettingsAllgemein($settings);
					$this->mitarbeiterRepository->update($mitarbeiter);
				}
			
				
				
            }
        } else {
			
            $this->view->assign('mitarbeiter', $mitarbeiter);
        }
        return $this->htmlResponse();
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
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('mitarbeiter', $mitarbeiter);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $newMitarbeiter
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $newMitarbeiter)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mitarbeiterRepository->add($newMitarbeiter);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("mitarbeiter")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('mitarbeiter', $mitarbeiter);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mitarbeiterRepository->update($mitarbeiter);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->mitarbeiterRepository->remove($mitarbeiter);
        $this->redirect('list');
    }
}
