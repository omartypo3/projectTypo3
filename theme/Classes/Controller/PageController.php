<?php
namespace Avonis\Theme\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 dev@avonis.com <>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

use FluidTYPO3\Fluidpages\Controller\PageController as AbstractController;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Page Controller
 *
 * @route off
 */
class PageController extends AbstractController {

    /**
     * syscategoriesCollection
     *
     * @var \TYPO3\CMS\Core\Resource\Collection\CategoryBasedFileCollection
     * @inject
     */
    protected $syscategoriesCollection;

    /**
     * @var FluxService
     */
    protected $configurationService;

    /**
     * @var \FluidTYPO3\Flux\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * @var \Avonis\Theme\Domain\Repository\CategoriesRepository
     * @inject
     */
    protected $categoriesRepository;

    /**
     * currentLanguage
     */
    protected $currentLanguage;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {
        $this->currentLanguage = $GLOBALS['TSFE']->sys_language_uid;
        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $this->categoriesRepository = $objectManager->get('Avonis\\Theme\\Domain\\Repository\\CategoriesRepository');
    }

    /**
     * @param $var
     */
    public function v($var){
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($var);
    }

    /**
     * @param $var
     */
    public function d($var){
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($var, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__);
    }


    public function startpageAction () {

    }

    public function furnopageAction () {

    }


    /**
     * Helpfunction getTreePids
     * @param int $parent
     * @param bool $as_array
     * @return array
     */

    private function getTreePids($parent = 0, $as_array = true){
        $depth = 999999;
        $queryGenerator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Database\\QueryGenerator' );
        $childPids = $queryGenerator->getTreeList($parent, $depth, 0, 1);
        if($as_array) {
            $childPids = explode(',',$childPids);
        }
        if($this->currentLanguage != 0){
            $availablePagesPids = array();
            foreach ($childPids as $pid){
                $pageOverlay = $this->getPageOverlay($pid, (int)$this->currentLanguage);
                if(!empty($pageOverlay)){
                    $availablePagesPids[] = $pid;
                }
            }
            return $availablePagesPids;
        }
        return $childPids;
    }

    /**
     * @param $pid
     * @return mixed
     */
    private function getPageData($pid){
        $pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        return $pageRepository->getPage($pid);
    }

    /**
     * @param $pid
     * @return mixed
     */
    private function getPageOverlay($pid, $lang){
        $pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        return $pageRepository->getPageOverlay($pid, (int)$lang);
    }

    /**
     * @param $pid
     * @return array
     */
    private function findFileFromPageMedia( $pid ){
        $fileRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\FileRepository');
        $fileObjects = $fileRepository->findByRelation('pages', 'media', $pid);
        $files = array();
        foreach ($fileObjects as $key => $value) {
            $files[$key]['reference'] = $value->getReferenceProperties();
            $files[$key]['original'] = $value->getOriginalFile()->getProperties();
        }
        return $files;
    }

    /**
     *
     */
    public function projectpageAction () {

        //get FlexData
        $record = $this->getRecord();
        $FlexFormValues = $this->provider->getFlexFormValues($record);

        //set TempVar
        $this->view->assign('ListHome', $this->settings['Project']['ListPage']);
        $this->view->assign('pid', $record['row']);

        //set TempVar
        if(strlen($FlexFormValues['difficulty'])>0){
            $difficultObject = $this->categoriesRepository->findByUidAndLanguage($FlexFormValues['difficulty'], $this->currentLanguage);
            if($difficultObject){
                $difficultName = $difficultObject->getTitle();
                $this->view->assign('Difficulty', $difficultName);
            }else{
                $this->view->assign('Difficulty', '');
            }
        }else{
            $this->view->assign('Difficulty', '');
        }

        //set TempVar
        if(strlen($FlexFormValues['projectcategory'])>0) {
            $projectCats="";
            foreach (explode(',',$FlexFormValues['projectcategory']) as $key=>$value){
                $catObj = $this->categoriesRepository->findByUidAndLanguage($value, $this->currentLanguage);
                if($key>0){
                    $projectCats .= ' / ';
                }
                $projectCats .= $catObj->getTitle();
            }
            $this->view->assign('Projectcategories', $projectCats);
        }else{
            $this->view->assign('Projectcategories', '');
        }
    }

    public function projectListpageAction () {

        $row = $this->getRecord();
        $childPages = $this->getTreePids($row['uid']);
        $cat= array();$diff= array();$pro = array();$link = array();
        $cObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');

        //get all Subpages with Data
        foreach ($childPages as $key=>$value){
            $page = $this->getPageData($value);
            if($value != $row['uid'] && $page['hidden'] == 0){
                $FlexFormValues = $this->provider->getFlexFormValues($page);
                if($FlexFormValues['difficulty'] > 0){
                    $diff[$FlexFormValues['difficulty']]['pro'][] = $value;
                    $pro[$value]['diff'] = $FlexFormValues['difficulty'];
                }
                if($FlexFormValues['projectcategory'] > 0) {
                    foreach (explode(',', $FlexFormValues['projectcategory']) as $p) {
                        $cat[$p]['pro'][] = $value;
                        $pro[$value]['cat'][] = $p;
                    }
                }
                $pro[$value]['images'] = $this->findFileFromPageMedia($value);
                $pro[$value]['page'] = $page;
                $link[] = urldecode($cObject->typolink(NULL, array('parameter'=>$value,'returnLast'=>true)));

            }
        }
        //build Temp var
        if(is_array($diff)){
            foreach ($diff as $key=>$value){
                $catObj = $this->categoriesRepository->findByUidAndLanguage($key, $this->currentLanguage);
                if($catObj){
                    $diff[$key]['title'] = $catObj->getTitle();
                    $diff[$key]['name'] = 'diff_'.$key;
                    $diff[$key]['count'] = count($diff[$key]['pro']);
                }
            }
            $this->view->assign('allDifficulty', $diff);
        }
        if(is_array($cat)){
            foreach ($cat as $key=>$value){
                $catObj = $this->categoriesRepository->findByUidAndLanguage($key, $this->currentLanguage);
                if($catObj){
                    $cat[$key]['title'] = $catObj->getTitle();
                    $cat[$key]['name'] = 'cat_'.$key;
                    $cat[$key]['count'] = count($cat[$key]['pro']);
                }
            }
            $this->view->assign('allCategories', $cat);
        }
        
        if(is_array($pro)){
            foreach ($pro as $key=>$value){
                $alltitle   = $this->categoriesRepository->findTitlePageByUidAndLanguage($key, $this->currentLanguage);
                if(is_array($value['cat'])){
                    foreach ($value['cat'] as $b=>$c){
                        $pro[$key]['classes'] .= $cat[$c]['name'].' ';
                        if($b > 0){
                            $pro[$key]['categories'] .= ' | ';
                        }
                        $pro[$key]['categories'] .= $cat[$c]['title'].' ';
                    }
                }
                $pro[$key]['classes'] .= $diff[$value['diff']]['name'].' ';
                $pro[$key]['diff'] = $diff[$value['diff']]['title'];
                $pro[$key]['titlepage'] = $alltitle;
                if(is_array($pro[$key]['images'])){
                    $pro[$key]['image'] = $pro[$key]['images'][0]['original']['uid'];
                }else{
                    $pro[$key]['image'] = 0;
                }
            }
            $this->view->assign('randomProject', array_rand($pro,1));
            $this->view->assign('projects', $pro);
        }
        //set _ with project URL for random Project
        $this->view->assign('randomArray', json_encode($link));
    }

    public function landingpageAction () {
        /*$this->view->assign('CustomMenuLink', $this->settings['CustomMenuLink']);
        $this->view->assign('FooterMenuId', $this->settings['FooterMenuId']);*/

    }

    public function regularAction() {

    }
}