<?php

namespace Cundd\CustomRest\Controller;

use Cundd\Rest\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Service\FlexFormService;

/**
 * An example Extbase controller that will be called through REST
 */
class MenuController extends ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\View\JsonView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;



    /**
     * action Menu
     *
     * @return void
     */
    public function menuAction()
    {
        $this->t3pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $fields = 'uid ,title';
        $sortField = 'sorting';
        $constraints = ' hidden = 0 and deleted = 0';
       // $sectionMenu = array(array("pageId" => 1154, "key" => "toponline"),array("pageId" => 1154, "key" => "toponline"));
        $menu  = array();
        $mainMenuUidTitle  = array();
        $line = array ("sectionMenu"=>array(
            array("pageId" => "1153", "key" => "toponline"),
            array("pageId" => "1024", "key" => "radiotop"),
            array("pageId" => "1082", "key" => "teletop"),
            array("pageId" => "1057", "key" => "reporter"),
            )
        );
        $mainMenu  = $this->t3pageRepository->getMenu("1181", $fields, $sortField);

        foreach ($mainMenu as &$page) {
             array_push($mainMenuUidTitle,array("pageId" => $page['uid'], "title" => $page['title']));
        }
        $linemainMenu = array ("mainMenu"=>$mainMenuUidTitle);

        $mainMenuRegion  = $this->t3pageRepository->getMenu("1180", $fields, $sortField);

        foreach ($mainMenuRegion as &$page) {
            array_push($menu,array("pageId" => $page['uid'], "title" => $page['title']));
        }
        $linemainMenu = array ("mainMenu"=>$mainMenuUidTitle);
        $lineRegion = array ("Regions"=>$menu);
        $menu = array_merge($line,$linemainMenu,$lineRegion);

        $this->view->assign(
            'value',
            $menu
        );
    }


}
