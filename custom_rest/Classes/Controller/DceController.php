<?php

namespace Cundd\CustomRest\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
/**
 * An example Extbase controller that will be called through REST
 */
class DceController extends ActionController
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
     * Person Repository
     *
     * @var \DRCSystems\NewsComment\Domain\Repository\CommentRepository
     * @inject
     */
    protected $personRepository;

    /**
     * action dce
     *
     * @return void
     */
    public function dceAction()
    {


        $this->view->assign('value', $this->TTcontent());


    }

    public function TTcontent()
    {

        /******************news*********************/
        $fields = '*';
        $table = 'tx_newscomment_domain_model_comment ';
        $where = 'tx_newscomment_domain_model_comment.hidden = 0  and tx_newscomment_domain_model_comment.deleted = 0';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentConfig0 = array();

        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
            array_push($ttContentConfig0, array('newsuid' => $record['newsuid'],'uid' => $record['uid'],'username'=>$record['username'],'description'=>$record['description'],'likes'=>$record['likes'],'dislikes'=>$record['dislikes']));


        }
        return $ttContentConfig0;

    }


    /**
     * action likes
     *
     * @return void
     */
    public function likesAction()
    {
        $pid = (int)$this->request->getArgument('uid');
        $fields = '*';
        $table = 'tx_newscomment_domain_model_comment';
        $where = $pid . '=tx_newscomment_domain_model_comment.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory,$record['likes']);
        }
        $likes = $ttContentcategory[0] + 1;
        $updateArray = array(
            'likes' => $likes,
        );
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery ('tx_newscomment_domain_model_comment','uid = '.'"'.$pid.'"',$updateArray, TRUE);

        $this->view->assign('value',['success' => 1]);
    }

    /*-----------------------------------------------------------------*/


    /**
     * action dislikes
     *
     * @return void
     */
    public function dislikesAction()
    {
        $pid = (int)$this->request->getArgument('uid');
        $fields = '*';
        $table = 'tx_newscomment_domain_model_comment';
        $where = $pid . '=tx_newscomment_domain_model_comment.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory,$record['dislikes']);
        }

        $likes = $ttContentcategory[0] + 1;
        $updateArray = array(
            'dislikes' => $likes,
        );
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery ('tx_newscomment_domain_model_comment','uid = '.'"'.$pid.'"',$updateArray, TRUE);

        $this->view->assign('value',['success' => 1]);


    }



}
