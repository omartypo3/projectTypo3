<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * SplitpaneController
 */
class SplitpaneController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * splitpaneRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository
     */
    protected $splitpaneRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository $splitpaneRepository
     */
    public function injectSplitpaneRepository(\DslFactory\DslIntranet\Domain\Repository\SplitpaneRepository $splitpaneRepository)
    {
        $this->splitpaneRepository = $splitpaneRepository;
    }
	
	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->splitpaneRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\SplitpaneRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
    }

    /**
     * action projekte
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function projekteAction(): \Psr\Http\Message\ResponseInterface
    {
		$mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        
        $this->view->assign('mitarbeiter', $mitarbeiter);
        return $this->htmlResponse();
    }
	
	/**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
		// sleep(1);
        //$this->auftraegeRepository->find
        //print_r($this->request->getArguments());
        if ($this->request->hasArgument('switch')) {
            // echo "switch ja";
            
            $this->view->assign('switch', $this->request->getArgument('switch'));
            $this->view->assign('arguments', $this->request->getArguments());

            $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
            $settingsBoards = $mitarbeiter->getSettingsKanban();
            
            switch ($this->request->getArgument('switch')) {
                case 'reorderKanbanBoards':
                    # code...
                    $resArr = $this->getKanbanBoards();
                    $resArr = $this->syncMissingAuftraege($resArr);
                    if($this->request->hasArgument('boards')){
                        $boardsOrdered = [];
                        $boards = $this->request->getArgument('boards');
                        foreach($boards as $boardId => $order){


                            $key = -1;
                            foreach($resArr["boards"] as $k => $v){
                                if($v['id']==$boardId) {
                                    $key = $k;
                                    break;
                                }
                            }

                            //$key = array_search($boardId, array_column($resArr["boards"], 'id'));
                            if($key > -1) {
                                $boardsOrdered[] = $resArr["boards"][$key];
                                unset($resArr["boards"][$key]);
                            }
                        }
                        //vermutlich verweiste boards
                        /*
                        foreach($resArr["boards"] as $board){
                            $boardsOrdered[] = $board;
                        }*/
                        $resArr["boards"] = $boardsOrdered;
                    }
                    $this->view->assign('boards',$boards);	
                    $this->view->assign('resArr',$resArr);	
                    $mitarbeiter->setSettingsKanban($resArr["boards"]);
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    break;
                case 'changeKanbanBoards':

                    $resArr = $this->getKanbanBoards();
                    $resArr = $this->syncMissingAuftraege($resArr);
                    //$existingBoards = $resArr["boards"];
                    //$resArr["auftraege"]
                    if($this->request->hasArgument('boards')){
                        $boards = $this->request->getArgument('boards');
                        foreach($boards as $boardId => $content){
                           // echo $boardId.":";
                           // $existingBoards[$boardname]["item"] = [];
                            /*'item'  => [
                                {
                                'id':'task-1',
                                    'title':'Try drag me',
                                },
                                {
                                'id':'task-2',
                                    'title':'Click me!!',
                                }
                            ]*/

                            $key = array_search($boardId, array_column($settingsBoards, 'id'));
                            
                            $resArr["boards"][$key]['item'] = [];
                            foreach($content as $id){
                                if($resArr["existing"][$id]){
                                    //die;
                                    //$resArr["boards"][$key]['item'][] = 
                                    //$resArr["existing"][$id]
                                    if($resArr["auftraegeVorlagen"][$id]) $resArr["boards"][$key]['item'][]=$resArr["auftraegeVorlagen"][$id];


                                    //unset($resArr["boards"][$resArr["existing"][$id]["boardIndex"]][$resArr["existing"][$id]["itemIndex"]]);
                                }
                                

                                /*if($boards["auftraege"][$id]){
                                    $resArr["boards"][$key]['item'][] = [
                                        'id' => $id,
                                        'title' => $boards["auftraege"]["title"];
                                    ];
                                }*/
/*
                                $resArr["boards"][$key]['item'][] = [
                                    'id' => $id,
                                    'title' => 'Click me!!'
                                ];*/

/*
                                $existingBoards[$boardname]["item"][] = [
                                    'id' => 'task-2',
                                    'title' => 'Click me!!'
                                ];
*/
                                /*$existingBoards[$boardname][0]["item"][] = [
                                    "id"=>"auftrag-".$auftrag->getUid(),
                                    "title"=>$auftrag->getTitel()
                                ];*/

                            }
                        }
                        //die;
                    }
                    $this->view->assign('existing',$resArr["existing"]);	
                    $this->view->assign('boards',$boards);	
                    $this->view->assign('newboards',$resArr["boards"]);	
                    $this->view->assign('returnString', json_encode(array(true,"newboards"=>$existingBoards,"last keyfound"=>$key)));	

                    $mitarbeiter->setSettingsKanban($resArr["boards"]);
                    $this->mitarbeiterRepository->update($mitarbeiter);

                    //$resArr["boards"]
                break;
                case 'deleteKanbanBoard':
                    
                    if($boardId = $this->request->getArgument('boardId')){
                        

                        $key = -1;
                        foreach($settingsBoards as $k => $v){
                            if($v['id']==$boardId) {
                                $key = $k;
                                break;
                            }
                        }

                        //$key = array_search($boardId, array_column($settingsBoards, 'id'));
                        
                        if($key > -1){
                            unset($settingsBoards[$key]);
                            $mitarbeiter->setSettingsKanban($settingsBoards);
                            $this->mitarbeiterRepository->update($mitarbeiter);
                        }
                    }
                    //echo "!!!!!!key!".$key."!key!!";
                   // print_r($settingsBoards);die;
                   $this->view->assign('returnString', json_encode(array(true)));	

                break;
                case 'renameKanbanBoard':
                   
                    //$settingsBoards[4]['title'].=":";
                    if($boardId = $this->request->getArgument('boardId')){
                        //$settingsBoards[4]['title'].="X";
                        $key = -1;
                        foreach($settingsBoards as $k => $v){
                            if($v['id']==$boardId) {
                                $key = $k;
                                break;
                            }
                        }
                        //$key = array_search($boardId, array_column($settingsBoards, 'id'));
                        if($key > -1 ){
                            //$settingsBoards[0]['title'].="Y".$key."Y";
                           // echo $key;
                            $settingsBoards[$key]['title']=$this->request->getArgument('title');
                          //  unset($settingsBoards[$key]);
                            $mitarbeiter->setSettingsKanban($settingsBoards);
                            $this->mitarbeiterRepository->update($mitarbeiter);
                        }
                    }
                    
                    //echo "!!!!!!key!".$key."!key!!";
                    //print_r($settingsBoards);
                   $this->view->assign('returnString', json_encode(array(true)));	

                break;
                case 'newKanbanBoard':
                  
                    $newId = 1;
                    for ($i=1;$i<10000;$i++) {
                        if(array_search('_board'.$i, array_column($settingsBoards, 'id')) !== FALSE){
                            continue;
                        }
                        $newId = $i;
                        break;
                    }
                   
                    $newBoard = [
                        'id' => '_board'.$newId,
                        'title'  => $this->request->getArgument('title'),
                        'class' => 'success',
                        'item'  => [
                            /*{
                            'id':'task-1',
                                'title':'Try drag me',
                            },
                            {
                            'id':'task-2',
                                'title':'Click me!!',
                            }*/
                        ]
                    ];
                    $settingsBoards[] = $newBoard;
                    $mitarbeiter->setSettingsKanban($settingsBoards);
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    //$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //$mitarbeiter->setSettingsKanban();

                    $this->view->assign('returnString', json_encode($newBoard));	
                    
                break;
                case 'loadKanban':    
                    
                    $resArr = $this->getKanbanBoards();
                    $resArr = $this->syncMissingAuftraege($resArr);
                  //  var_dump($resArr["boards"]);die;
                    
                    $this->view->assign('resArr', $resArr);	
                    $this->view->assign('returnString', json_encode($resArr));	

                     
                    break;
                
                default:    die;
                    break;
            }

            if($settingsBoards) $this->view->assign('settingsBoards', $settingsBoards);
        }
    
       // return $this->htmlResponse();
    }
	
	 function syncMissingAuftraege($resArr){
        $keyProjekte = array_search("_projekte", array_column($resArr["boards"], 'id'));
        $auftraege = $this->auftraegeRepository->findByFilter(array("statuss"=>array(10,20,30,40,50)), false, false, array(), false, false);


        $resArr["existing"] = [];
        foreach($resArr["boards"] as $boardIndex => $board) foreach($board["item"] as $itemIndex => $eintrag) $resArr["existing"][$eintrag["id"]] = ["boardIndex"=>$boardIndex,"itemIndex"=>$itemIndex];

        foreach($auftraege as $auftrag){
            $id = "auftrag-".$auftrag->getUid();
            $resArr["auftraege"][$id] = array(
                "auftragNr"=>$auftrag->getNr(),
                "auftragTitel"=>$auftrag->getTitel(),
                "kundeName"=>$auftrag->getKunde()->getName(),
                "kundeNummer"=>$auftrag->getKunde()->getNummer()
            );
            $resArr["auftraegeVorlagen"][$id] = array(
                "id"=>$id,
                "title"=>$auftrag->getTitel(),
                "auftragUid"=>$auftrag->getUid(),
                "kunde"=>$auftrag->getKunde()->getName(),
                
                "type"=>'auftrag'
            );

            if(!isset($resArr["existing"][$id])){
                
                $resArr["boards"][$keyProjekte]["item"][] = $resArr["auftraegeVorlagen"][$id];
                $itemIndex = array_keys($resArr["boards"][$keyProjekte]["item"])[count($resArr["boards"][$keyProjekte]["item"])-1];

                $resArr["existing"][$id] = ["boardIndex"=>$keyProjekte,"itemIndex"=>$itemIndex];
            }
        }

        //Aufträge entfernen welche nicht mehr existieren oder bereits in rechnung schreiben sind.
        foreach($resArr["boards"] as $boardKey => $board){
            foreach($board["item"] as $itemKey => $item){  
                if(!$resArr["auftraegeVorlagen"][$item["id"]]){
                    unset($resArr["boards"][$boardKey]["item"][$itemKey]);
                } else {
                    //$resArr["boards"][$boardKey]["item"][$itemKey]["title"] = $resArr["boards"][$boardKey]["item"][$itemKey]["title"].':::';

                    $resArr["boards"][$boardKey]["item"][$itemKey] = array_merge(
                        $resArr["boards"][$boardKey]["item"][$itemKey],
                        $resArr["auftraegeVorlagen"][$item["id"]]
                    );
                    //fürn test entfernen
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["auftragUid"]);
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["kunde"]);
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["_auftragUid"]);
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["_kunde"]);
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["type"]);
                //    unset($resArr["boards"][$boardKey]["item"][$itemKey]["bla"]);
                }
                /*
                if($board["id"]=='_projekte'){
                    unset($resArr["boards"][$boardKey]["item"][$itemKey]);
                }
                if($board["id"]=='_board1'){
                    unset($resArr["boards"][$boardKey]["item"][$itemKey]);
                }
                if($board["id"]=='_board5'){
                    unset($resArr["boards"][$boardKey]["item"][$itemKey]);
                }*/
            }
        }
        
        
        //reicht eigentlich nur wenn aufträge weg oder hinzugekommen sind
        
        $resArr["boards"] = array_values($resArr["boards"]);
        
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $mitarbeiter->setSettingsKanban($resArr["boards"]);
        $this->mitarbeiterRepository->update($mitarbeiter);
        


        return $resArr;
    }
    
    function getKanbanBoards(){



        $resArr = array( );
        //$resArr["auftraege"]
        

       

        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settingsBoards = $mitarbeiter->getSettingsKanban();

       
        if(!count($settingsBoards)){
            //die;
            $resArr["boards"] = [
                [
                    'id' => '_projekte',
                    'title'  => 'Projekte',
                    'class' => 'info',
                    'item'  => [
                        /*{
                        'id':'task-1',
                            'title':'Try drag me',
                        },
                        {
                        'id':'task-2',
                            'title':'Click me!!',
                        }*/
                    ]
                ]
            ];
            //aufträge füllen // welche nicht in anderen boards existieren // die item nummer rausfinden!!
           

            $mitarbeiter->setSettingsKanban($resArr["boards"]);
            $this->mitarbeiterRepository->update($mitarbeiter);

        } else {


            //prüfen ob es boards gibt welche nicht korrekt gelöscht wurden
            $keysToDelete = [];//undefined boards
            foreach($settingsBoards as $boardId => $board){
                if(!$board["id"]) $keysToDelete[]=$boardId;
            }
            if(count($keysToDelete)) {
                foreach($keysToDelete as $boardId){
                    unset($settingsBoards[$boardId]);
                }
                $mitarbeiter->setSettingsKanban($settingsBoards);
                $this->mitarbeiterRepository->update($mitarbeiter);
            }


            $resArr["boards"] = $settingsBoards; 
        }



       

        return $resArr;
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
        $splitpanes = $this->splitpaneRepository->findAll();
        $this->view->assign('splitpanes', $splitpanes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('splitpane', $splitpane);
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
     * @param \DslFactory\DslIntranet\Domain\Model\Splitpane $newSplitpane
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\Splitpane $newSplitpane)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->splitpaneRepository->add($newSplitpane);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("splitpane")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('splitpane', $splitpane);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->splitpaneRepository->update($splitpane);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Splitpane $splitpane)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->splitpaneRepository->remove($splitpane);
        $this->redirect('list');
    }
}
