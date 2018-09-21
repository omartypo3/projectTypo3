<?php
namespace J77\J77products\Controller;

/***
 *
 * This file is part of the "Produkte" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ProzessanlageController
 */
class ProzessanlageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * prozessanlageRepository
     *
     * @var \J77\J77products\Domain\Repository\ProzessanlageRepository
     * @inject
     */
    protected $prozessanlageRepository = null;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $prozessanlage = $this->prozessanlageRepository->findAll();
        $this->view->assign('prozessanlage', $prozessanlage);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\Prozessanlage $prozessanlage
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\Prozessanlage $prozessanlage)
    {
        $this->view->assign('prozessanlage', $prozessanlage);
    }

    /**
     * action detail
     *
     * @param \J77\J77products\Domain\Model\Prozessanlage $prozessanlage
     * @return void
     */
    public function detailAction(\J77\J77products\Domain\Model\Prozessanlage $prozessanlage = null)
    {
        if($prozessanlage === null && !empty($this->settings['Prozessanlage-DetailList'])) {
            $prozessanlage = $this->prozessanlageRepository->findByUid($this->settings['Prozessanlage-DetailList']);
        }
        
        if(empty($prozessanlage)) {
            return;
        }
        
        
        $weitereAnlagen = [];
        if (!empty($prozessanlage)) {
            $elemente = $prozessanlage->getElemente();
            foreach ($elemente as $element) {
                if ($element->getElement() == 5) {
                    $anlagen = $element->getAnlagen();
                    $maschines = $element->getMaschinerel();
                    foreach ($anlagen as $anlage) {
                        $anlagen->removeAll($elemente);
                        $weitereAnlagen[] = [
                            'image' => $anlage->getTeaserbild(),
                            'name' => $anlage->getName(),
                            'type' => 'Prozessanlage',
                            'uid' => $anlage->getUid(),
                            'detailseite' => $anlage->getDetailseite(),
                        ];
                    }
                    foreach ($maschines as $maschine) {
                        $maschines->removeAll($elemente);
                        $weitereAnlagen[] = [
                            'image' => $maschine->getTeaserbild(),
                            'name' => $maschine->getName(),
                            'type' => 'Maschine',
                            'uid' => $maschine->getUid(),
                            'detailseite' => $maschine->getDetailseite(),
                        ];
                    }
                }
            }
        }
        
        $this->view->assign('prozessanlage', $prozessanlage);
        $this->view->assign('weitereanlagen', $weitereAnlagen);
        $this->view->assign('contactPageUid', $this->settings['contact']);
        $this->view->assign('detailPageUid', $this->settings['template']['anlagendetail']); 
        $this->view->assign('detailMaschinePageUid', $this->settings['template']['maschinendetail']);  
    }

    /**
     * action teaser
     *
     * @return void
     */
    public function teaserAction()
    {
        $prozessanlagen = [];
        if (!empty($this->settings['Prozessanlage-TeaserIdentifier'])) {
            $prozessanlagenIds = explode(',', $this->settings['Prozessanlage-TeaserIdentifier']);
            
            $paGroups = [];
            $paNotGrouped = [];
            
            foreach ($prozessanlagenIds as $id) {
                
                $prozessanlage = $this->prozessanlageRepository->findByUid($id);
                
                if(!empty($prozessanlage)) {
                    $cat = $prozessanlage->getCategory();
                    if(empty($cat))  {
                        $paNotGrouped[] = $prozessanlage;
                    } else  {
                        if(empty($paGroups[$cat->getUid()])) {
                            $paGroups[$cat->getUid()] = [
                                'category' => $cat,
                                'sorting' => $cat->getSorting(),
                                'pas' => [],
                            ];
                        }
                        
                        $paGroups[$cat->getUid()]['pas'][]= $prozessanlage;
                    }
                }
            }
            
            $this->array_sort_by_column($paGroups, 'sorting');
            
            $this->view->assign('paGroups', $paGroups); 
            $this->view->assign('paNotGrouped', $paNotGrouped); 
            $this->view->assign('detailPageUid', $this->settings['template']['anlagendetail']);    
        }
    }
    
    
    private function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
          $sort_col = array();
          foreach ($arr as $key=> $row) {
               $sort_col[$key] = $row[$col];
          }

          array_multisort($sort_col, $dir, $arr);
     }
}
