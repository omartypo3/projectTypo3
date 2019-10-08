<?php
namespace DentNetSearch\Dentnetsearch\Controller;


use DentNetSearch\Dentnetsearch\Domain\Model\Dentist;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***
 *
 * This file is part of the "DentNetSearch" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
/**
 * DentistController
 */
class DentistController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * dentistRepository
     * 
     * @var \DentNetSearch\Dentnetsearch\Domain\Repository\DentistRepository
     * @inject
     */
    protected $dentistRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $permimetre='';
        $isshlaf=0;
        $isimplant=0;
        $q='';
        $results=[];
        if($this->request->hasArgument('search')){
            $search=$this->request->getArgument('search');
            $query="";
            if(!empty($search)){
                $q=$search['zipsearch'];
                if(!empty($q)){$query.='?q='.$q;}
                $permimetre=$search['perimeter'];
                if(!empty($permimetre)){$query.='&perimeter='.$permimetre;}
                $isimplant=$search['isimplant'];
                if(!empty($isimplant)){$query.='&isimplant='.$isimplant;}
                $isshlaf=$search['isshlaf'];
                if(!empty($isshlaf)){$query.='&issleep='.$isshlaf;}
            }
            $authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImV4cCI6MTg1ODU5OTY1OX0.AkrZoSumqIBXeMzjjzCkfq6ngKzLoXARmGi86bf3RTM";
            $ch = curl_init();
            $url="https://development.search.dent-net.de/surgeries".$query;
            $url = str_replace(' ', '%20', $url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ,'Accept: application/json', $authorization ));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $results=json_decode($result,true);
            curl_close($ch);
            if(!empty($results['data'])){
                foreach ($results['data'] as $dentist){
                    $dent=$this->dentistRepository->findOneById($dentist['id']);
                        if(empty($dent)){
                            $dentiste = new Dentist();
                            $dentiste->setId($dentist['id']);
                            $dentiste->setName($dentist['uri']);
                            if($dentist['ispro']){
                                // add event page
                                $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
                                $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
                                $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
                                $target = $extbaseFrameworkConfiguration['plugin.']['tx_dentnetsearch_dentnetsearch.']['settings.']['targetPageID'];
                                $parent = $extbaseFrameworkConfiguration['plugin.']['tx_dentnetsearch_dentnetsearch.']['settings.']['searchPageUid'];
                                $cmd['pages'][$target]['copy'] = $parent;
                                $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
                                $tce->stripslashes_values = 0;
                                $tce->start(array(), $cmd);
                                $tce->process_cmdmap();
                                $newPageId = $tce->copyMappingArray_merged['pages'][$target];
                                $this->dentistRepository->setPagetitle($newPageId, $dentiste->getName());
                                $newContentId = $tce->copyMappingArray_merged['tt_content'];
                                $flexArray2Xml_options = [
                                    'parentTagMap' => [
                                        'data' => 'sheet',
                                        'sheet' => 'language',
                                        'language' => 'field',
                                        'el' => ' ',
                                        'field' => 'value',
                                        'field:el' => 'el',
                                        'el:_IS_NUM' => 'section',
                                        'section' => 'itemType'
                                    ],
                                    'disableTypeAttrib' => 2
                                ];
                                $dentiste->setPagedetailid($newPageId);
//                                foreach ($newContentId as $key => $value) {
//                                    $flex = $this->eventRepository->getContent((int)$newContentId[$key])['pi_flexform'];
//                                    $flexform = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($flex);
//                                    $flexform['data']['sDEF']['lDEF']['settings.eventid']['vDEF'] = (string)$newEvent->getUid();
//                                    $newflexform = \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml($flexform, '', 0, 'T3FlexForms', 4, $flexArray2Xml_options);
/*                                    $newflex = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . $newflexform;*/
//                                    $this->eventRepository->setContent((int)$newContentId[$key], $newflex);
//                                }
                                // end add event page
                            }
                            $this->dentistRepository->add($dentiste);
                            $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
                            $persistenceManager->persistAll();

                        }



                }
            }

        }

        $this->view->assignMultiple(['zip'=>$q,'perimeter'=>$permimetre,'isimplant'=>$isimplant,'isshlaf'=>$isshlaf,'dentists'=>$results]);
    }

    /**
     * action show
     * 
     * @param string $dentist
     * @return void
     */
    public function showAction(string $dentist)
    {

        $authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImV4cCI6MTg1ODU5OTY1OX0.AkrZoSumqIBXeMzjjzCkfq6ngKzLoXARmGi86bf3RTM";
        $ch = curl_init();
        $dent=$this->dentistRepository->findOneByUid($dentist);
        $url="https://development.search.dent-net.de/surgeries/view/".$dent->getId();
        $url = str_replace(' ', '%20', $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ,'Accept: application/json', $authorization ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $results=json_decode($result,true);
        curl_close($ch);
        $this->view->assign('dentist', $results);
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
     * @param \DentNetSearch\Dentnetsearch\Domain\Model\Dentist $newDentist
     * @return void
     */
    public function createAction(\DentNetSearch\Dentnetsearch\Domain\Model\Dentist $newDentist)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dentistRepository->add($newDentist);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist
     * @ignorevalidation $dentist
     * @return void
     */
    public function editAction(\DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist)
    {
        $this->view->assign('dentist', $dentist);
    }

    /**
     * action update
     * 
     * @param \DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist
     * @return void
     */
    public function updateAction(\DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dentistRepository->update($dentist);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist
     * @return void
     */
    public function deleteAction(\DentNetSearch\Dentnetsearch\Domain\Model\Dentist $dentist)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->dentistRepository->remove($dentist);
        $this->redirect('list');
    }
}
