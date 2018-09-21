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

/**
 * SliderController
 */
class SliderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    
    /**
     * maschineRepository
     *
     * @var \J77\J77products\Domain\Repository\MaschineRepository
     * @inject
     */
    protected $maschineRepository = null;
    
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
        
          //   \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->settings['Slider-maschine']);  
       $machines=array();
       $prozessanlages=array();
        if (!empty($this->settings['Slider-maschine'])) { 
            (int)$machi=explode(',',$this->settings['Slider-maschine']); 
            foreach($machi as $strmach){
                $intmach=(int)$strmach; 
                $maschineDB = $this->maschineRepository->findByUid($intmach);
                $machines[$intmach]=$maschineDB;
            }
        }
            
        if (!empty($this->settings['Slider-Selection'])) { 
            (int)$prozessan=explode(',',$this->settings['Slider-Selection']); 
            foreach($prozessan as $strmach){
                $intmach=(int)$strmach; 
                $prozessanlageRepositoryDB = $this->prozessanlageRepository->findByUid($intmach);
                $prozessanlages[$intmach]=$prozessanlageRepositoryDB;
            }
        }
        
        $this->view->assign('machines', $machines); 
        $this->view->assign('prozessanlages', $prozessanlages); 
        $this->view->assign('maschineDetailPageUid', $this->settings['template']['maschinendetail']);    
        $this->view->assign('prozessanlageDetailPageUid', $this->settings['template']['anlagendetail']);   
    }
}
