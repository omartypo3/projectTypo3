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
 * MaschineController
 */
class MaschineController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    
    /**
     * maschineRepository
     *
     * @var \J77\J77products\Domain\Repository\MaschineRepository
     * @inject
     */
    protected $maschineRepository = null;
    
     

    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $maschines = $this->maschineRepository->findAll();
        $this->view->assign('maschines', $maschines);
    }

    /**
     * action show
     *
     * @param \J77\J77products\Domain\Model\Maschine $maschine
     * @return void
     */
    public function showAction(\J77\J77products\Domain\Model\Maschine $maschine)
    {
        $this->view->assign('maschine', $maschine);
    }

    /**
     * action detail
     *
     * @param \J77\J77products\Domain\Model\Maschine $maschine
     * @return void
     */
     public function detailAction(\J77\J77products\Domain\Model\Maschine $maschine = null)
    {
        if($maschine === null && !empty($this->settings['Maschinen-DetailList'])) {
            $maschine = $this->maschineRepository->findByUid($this->settings['Maschinen-DetailList']);
        }
        
        if(empty($maschine)) {
            return;
        }
        
        $relatives=array();
        if(!empty($maschine->getElemente())){
            $elementes=$maschine->getElemente()->toArray();
            foreach ($elementes as $key => $elemente){
                if($elemente->getElement()==7){
                    if(!empty($elemente->getMaschinenvariante())){
                        $maschinenElemente = $elemente->getMaschinenvariante()->toArray();
                        foreach ($maschinenElemente as $key2 => $elem) {
                            $unterElemente = $elem->getElemente()->toArray();
                            $allowedElements = [0, 1, 5, 6];
                            $relatives[$key2]['name'] = $elem->getName();
                            $relatives[$key2]['uid'] = $elem->getUid();
                            foreach ($unterElemente as $el) {
                                if (in_array($el->getElement(), $allowedElements)) {
                                    $relatives[$key2]['elems'][] = $el;
                                }
                            }
                        }
                    }
                }
            }
        }
                          //  DebuggerUtility::var_dump($relatives);

         $this->view->assign('maschine', $maschine);
         $this->view->assign('relatives', $relatives);

    }

    /**
     * action teaser
     *
     * @return void
     */
    public function teaserAction()
    {
        $maschinen = [];
        if (!empty($this->settings['Maschinen-TeaserIdentifier'])) {
            $maschinenIds = explode(',', $this->settings['Maschinen-TeaserIdentifier']);
            foreach ($maschinenIds as $id) {
                $maschinen[] = $this->maschineRepository->findByUid($id);
            }
            
            $this->view->assign('maschinen', $maschinen);
            $this->view->assign('headline', $this->settings['Maschinen-TeaserHeadline']);
            $this->view->assign('subheadline', $this->settings['Maschinen-TeaserSubheadline']);
            $this->view->assign('detailPageUid', $this->settings['template']['maschinendetail']);    
        }
    }
}
