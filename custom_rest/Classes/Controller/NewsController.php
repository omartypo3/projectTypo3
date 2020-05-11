<?php

namespace Cundd\CustomRest\Controller;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Factory\MailFactory;
use In2code\Powermail\Domain\Model\Answer;
/**
 * An example Extbase controller that will be called through REST
 */
class NewsController extends ActionController
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
     * @var \Cundd\CustomRest\Domain\Repository\PersonRepository
     * @inject
     */
    protected $personRepository;

    /**
     * @var \In2code\Powermail\Domain\Repository\FormRepository
     * @inject
     */
    protected $formRepository;

    /**
     * @var \In2code\Powermail\Domain\Repository\FieldRepository
     * @inject
     */
    protected $fieldRepository;
    /**
     * @var \In2code\Powermail\Domain\Repository\MailRepository
     * @inject
     */
    protected $mailRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;
    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $pid = (int)$this->request->getArgument('uid');
        $this->view->assign(
            'value',
            $this->TTcontent($pid)
        );

    }


    public function TTcontent($pid)
    {
        clearstatcache();


        /******************news*********************/
        $fields = '*';
        $table = 'tx_news_domain_model_news';
        $where = $pid . '=tx_news_domain_model_news.uid  and tx_news_domain_model_news.deleted=0  and tx_news_domain_model_news.hidden=0';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentConfig0 = array();

        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
            $datetime = date('d.m.Y / H:i', $record['datetime']);
            if ($record['archive'] != 0) {
                $archive = date('d.m.Y / H:i', $record['archive']);
            } else {
                $archive = 0;
            }
            if ($record['starttime'] != 0) {
                $starttime = date('d.m.Y / H:i', $record['starttime']);
            } else {
                $starttime = 0;
            }
            if ($record['endtime'] != 0) {
                $endtime = date('d.m.Y / H:i', $record['endtime']);
            } else {
                $endtime = 0;
            }
            if ($record['fal_media'] != 0) {
                $fal = $this->TTimage($record['uid'], fal_media);
            } else {
                $fal = array();
            }
            if ($record['fal_related_files'] != 0) {
                $fal_related_files = $this->TTimage($record['uid'], fal_related_files);
            } else {
                $fal_related_files = array();
            }


            /*$title = urlencode($record['title']);
            $resStr = strtolower(str_replace('+', '-', $title));
            $urlLink = "/detail/news/".$resStr."-00".$record['uid'];*/

            //$bodytext = $this->FixLink($record['bodytext']);
            $bodytext2 = $this->FixLink2($record['bodytext']);
            $articleUrl = $this->Articleurl($record['uid']);
            $votes = $this->votes($record['uid']);
            $pawermail = $this->pawermail($record['uid']);
            $contentElement = $this->contentElement($record['uid']);
            //$bodytext = $record['bodytext'];
            // $video = $this->FixVideo($record['bodytext']);
            //$audio = $this->FixAudio($record['bodytext']);
            //array_push($ttContentConfig0, array('uid' => $record['uid'], 'pid' => $record['pid'], 'title' => $record['title'], 'publishDate' => $starttime, 'expirationDate' => $endtime, 'datetime' => $datetime, 'archive' => $archive, 'teaser' => $record['teaser'], 'istopnews' => $record['istopnews'], 'bodytext' => $bodytext, 'author' => $record['author'], 'authorEmail' => $record['author_email'], 'category' => $this->TTcategory($record['uid']), 'mediaFile' => $fal, 'relatedFiles' => $fal_related_files, 'keywords' => $record['keywords'], 'tags' => $this->TTtag($record['uid']), 'readCounter' => $record['mostpopular_counter'], 'sdaIdentifier' => $record['tx_pingagnewsmlimport_sda_id'], 'sdaRevision' => $record['tx_pingagnewsmlimport_sda_revision'], 'authorSuffix' => $record['tx_pingagnewsmlimport_author'], 'comments' => $this->TTComment($record['uid']),'video'=>$video ,'audio'=>$audio));
            $kommentare = $record['tx_pingagtopnewsfields_comments'];
            if($kommentare == 0){
                $kommentareTrue= "False";
                array_push($ttContentConfig0, array('uid' => $record['uid'], 'pid' => $record['pid'], 'title' => $record['title'], 'publishDate' => $starttime, 'expirationDate' => $endtime, 'datetime' => $datetime, 'archive' => $archive, 'teaser' => $record['teaser'], 'istopnews' => $record['istopnews'], 'bodytext' => $bodytext2, 'author' => $record['author'], 'authorEmail' => $record['author_email'], 'category' => $this->TTcategory($record['uid']), 'mediaFile' => $fal, 'relatedFiles' => $fal_related_files, 'keywords' => $record['keywords'], 'tags' => $this->TTtag($record['uid']), 'readCounter' => $record['mostpopular_counter'], 'sdaIdentifier' => $record['tx_pingagnewsmlimport_sda_id'], 'sdaRevision' => $record['tx_pingagnewsmlimport_sda_revision'], 'authorSuffix' => $record['tx_pingagnewsmlimport_author'], 'comments' => array('displayed'=>$kommentareTrue,'array'=>[]),'articleUrl' =>$articleUrl,'voting'=>$votes,'formData'=>$pawermail,'htmlElement'=>$contentElement));

            }else{
                $kommentareTrue= "True";
                array_push($ttContentConfig0, array('uid' => $record['uid'], 'pid' => $record['pid'], 'title' => $record['title'], 'publishDate' => $starttime, 'expirationDate' => $endtime, 'datetime' => $datetime, 'archive' => $archive, 'teaser' => $record['teaser'], 'istopnews' => $record['istopnews'], 'bodytext' => $bodytext2, 'author' => $record['author'], 'authorEmail' => $record['author_email'], 'category' => $this->TTcategory($record['uid']), 'mediaFile' => $fal, 'relatedFiles' => $fal_related_files, 'keywords' => $record['keywords'], 'tags' => $this->TTtag($record['uid']), 'readCounter' => $record['mostpopular_counter'], 'sdaIdentifier' => $record['tx_pingagnewsmlimport_sda_id'], 'sdaRevision' => $record['tx_pingagnewsmlimport_sda_revision'], 'authorSuffix' => $record['tx_pingagnewsmlimport_author'], 'comments' => array('displayed'=>$kommentareTrue,'array'=>$this->TTComment($record['uid'])),'articleUrl' =>$articleUrl,'voting'=>$votes,'formData'=>$pawermail,'htmlElement'=>$contentElement));

            }

        }
        return $ttContentConfig0;

    }

    public function TTcategory($pid)
    {
        /******************category*********************/
        $fields1 = 'uid_local,title';
        $table1 = 'sys_category_record_mm ,sys_category';
        $where1 = $pid . '=sys_category_record_mm.uid_foreign and sys_category.uid = sys_category_record_mm.uid_local';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy1 = '';
        $orderBy1 = '';
        $limit1 = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields1, $table1, $where1, $groupBy1, $orderBy1, $limit1);

        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory, array('uid' => $recordcategory['uid_local'], 'title' => $recordcategory['title']));
        }
        return $ttContentcategory;

    }

    public function TTimage($pid, $type)
    {
        /******************category*********************/
        $fields = 'identifier, storage , title ,description,alternative';
        $table = 'sys_file_reference, sys_file';
        $where = $pid . '=sys_file_reference.uid_foreign and sys_file_reference.fieldname="' . $type . '" and sys_file_reference.deleted=0  and sys_file_reference.hidden=0 and sys_file_reference.tablenames="tx_news_domain_model_news" and sys_file_reference.uid_local=sys_file.uid';
        $groupBy = '';
        $orderBy = 'sorting_foreign';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
            if ($recordcategory['storage'] == 0) {
                $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/" . $recordcategory['identifier'];
            } else {
                $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/fileadmin" . $recordcategory['identifier'];
            }
            array_push($ttContentcategory, array('path' => $path, 'title' => $recordcategory['title'], 'description' => $recordcategory['description'], 'alternative' => $recordcategory['alternative']));
        }
        return $ttContentcategory;

    }

    public function TTtag($pid)
    {
        /******************category*********************/
        $fields = 'uid, title';
        $table = 'tx_news_domain_model_news_tag_mm,tx_news_domain_model_tag';
        $where = $pid . '=tx_news_domain_model_news_tag_mm.uid_local and tx_news_domain_model_news_tag_mm.uid_foreign	= tx_news_domain_model_tag.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory, array('uid' => $recordcategory['uid'], 'title' => $recordcategory['title']));
        }
        return $ttContentcategory;

    }

    public function TTComment($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'tx_newscomment_domain_model_comment';
        $where = $pid . '=tx_newscomment_domain_model_comment.newsuid and tx_newscomment_domain_model_comment.hidden = 0  and tx_newscomment_domain_model_comment.deleted = 0';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $datetime = date('d.m.Y / H:i', $recordcategory['crdate']);
            array_push($ttContentcategory, array('uid' => $recordcategory['uid'],'username' => $recordcategory['username'], 'usermail' => $recordcategory['usermail'], 'description' => $recordcategory['description'], 'Website' => $recordcategory['website'], 'date' => $datetime,'likes'=>$recordcategory['likes'],'dislikes'=>$recordcategory['dislikes']));
        }
        return $ttContentcategory;

    }

    public function FixLink($pid)
    {

        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/";
        $bodytext = "";
        $bodytext0 = "";
        $link = explode("\r\n", $pid);
        $audio = "<audio preload='metadata' webkit-playsinline controls='controls' style='margin: 0; padding: 0; width:100%;'>";
        for ($i = 0; $i <= sizeof($link); $i++) {
            if (stristr($link[$i], '.mp3')) {
                $bodytext0 .= "<p>".$audio . str_replace(" - mediaFile", " ' type='audio/mpeg'", $link[$i]) . "</p>";
                $bodytext0 = str_replace(array('<link ','</link>'), array('<source src=\'','</source></audio>'), $bodytext0);
                $explode = explode("type='audio/mpeg'", $bodytext0);
                $bodytext .= $explode[0] ."type='audio/mpeg'></source></audio></p>";
            }else if(stristr($link[$i], '.mp4') ){
                $explode = explode("- mediaFile", $link[$i]);
                $explodeSrc = explode(" ", $explode[0]);
                $explodePoster = explode(">", $explode[1]);
                $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/mp4'></video></p>";
            }
            else if(stristr($link[$i], '.flv') ){
                $explode = explode("- mediaFile", $link[$i]);
                $explodeSrc = explode(" ", $explode[0]);
                $explodePoster = explode(">", $explode[1]);
                $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/flv'></video></p>";
            }
            else if(stristr($link[$i], '.mov') ){
                $explode = explode("- mediaFile", $link[$i]);
                $explodeSrc = explode(" ", $explode[0]);
                $explodePoster = explode(">", $explode[1]);
                $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/mov'></video></p>";
            }
            else if(stristr($link[$i], '.avi') ){
                $explode = explode("- mediaFile", $link[$i]);
                $explodeSrc = explode(" ", $explode[0]);
                $explodePoster = explode(">", $explode[1]);
                $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/avi'></video></p>";
            }
            else if(stristr($link[$i], '.wmv') ){
                $explode = explode("- mediaFile", $link[$i]);
                $explodeSrc = explode(" ", $explode[0]);
                $explodePoster = explode(">", $explode[1]);
                $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/wmv'></video></p>";
            }else if (stristr($link[$i], '<link ')){
                $bodytext  .= str_replace("<link ", "<a href='", $link[$i]);
            }
            else if (stristr($link[$i], '<blockquote')){
                $bodytext  .= $link[$i];
            }else{
                $bodytext  .= "<p>".$link[$i]."</p>";
            }
        }
        $bodytext02 = str_replace("- external-link-new-window", "' class='external-link-new-window' data-htmlarea-external='1'", $bodytext);
        $bodytext003 = str_replace("\"", "'", $bodytext02);
        $bodytext004 = str_replace(">", "' data-htmlarea-external='1'>", $bodytext003);
        $bodytext005 = str_replace("</link' data-htmlarea-external='1'>", "</a>", $bodytext004);
        $bodytext006 = str_replace(array('<p\' data-htmlarea-external=\'1\'>','</p\' data-htmlarea-external=\'1\'>','\'\' data-htmlarea-external=\'1\'','</div\' data-htmlarea-external=\'1\'>','</i\' data-htmlarea-external=\'1\'>','controls\' data-htmlarea-external=\'1\'','</video\' data-htmlarea-external=\'1\'>','</source\' data-htmlarea-external=\'1\'></audio\' data-htmlarea-external=\'1\'>','<b\' data-htmlarea-external=\'1\'>','</b\' data-htmlarea-external=\'1\'>','<i\' data-htmlarea-external=\'1\'>','<br /\' data-htmlarea-external=\'1\'>','</span\' data-htmlarea-external=\'1\'>','</iframe\' data-htmlarea-external=\'1\'>','<span\' data-htmlarea-external=\'1\'>','<blockquote\' data-htmlarea-external=\'1\'>','</blockquote\' data-htmlarea-external=\'1\'>','<table\' data-htmlarea-external=\'1\'>','</table\' data-htmlarea-external=\'1\'>','<tr\' data-htmlarea-external=\'1\'>','</tr\' data-htmlarea-external=\'1\'>','<td\' data-htmlarea-external=\'1\'>','</td\' data-htmlarea-external=\'1\'>','<th\' data-htmlarea-external=\'1\'>','</th\' data-htmlarea-external=\'1\'>','<ul\' data-htmlarea-external=\'1\'>','</ul\' data-htmlarea-external=\'1\'>','<li\' data-htmlarea-external=\'1\'>','</li\' data-htmlarea-external=\'1\'>','<ol\' data-htmlarea-external=\'1\'>','</ol\' data-htmlarea-external=\'1\'>','<div\' data-htmlarea-external=\'1\'>'), array('<p>','</p>','\'','</div>','</i>','controls','</video>','</source></audio>','<b>','</b>','<i>','<br />','</span>','</iframe>','<span>','<blockquote>','</blockquote>','<table>','</table>','<tr>','</tr>','<td>','</td>','<th>','</th>','<ul>','</ul>','<li>','</li>','<ol>','</ol>','<div>'), $bodytext005);
        $bodytext0060 =  str_replace("\t", "", $bodytext006);
        //$bodytext00601 =  str_replace("<img src='", "<img src='".$path, $bodytext0060);
        if(!(stristr($bodytext0060, '<img src=\''.$path))){
            $bodytext0060 =  str_replace("<img src='", "<img src='".$path, $bodytext006);;
        }

        $bodytext0061 =  str_replace(array('<p></p>','</div></div></div>','\'></div></div>'),array(' ','</div>','\'></div>') ,$bodytext0060);
        $bodytext00612 = str_replace(array('</div></div>','<div><div ','</p> <p><p'),array('</div>','<div ','</p><p') ,$bodytext0061);
        $bodytext00613 =   str_replace(array('</p></p><p><p '),array('</p><p ') ,$bodytext00612);

        $bodytext00614 =   str_replace(array('&lt;','&gt;','&amp;','&quot;','&apos;'),array('<','>','&','"','\'') ,$bodytext00613);
        $bodytext00615 = str_replace("\"", "'", $bodytext00614);
        // return $bodytext00615."<script async defer src='//platform.instagram.com/en_US/embeds.js'></script>" ;
        return $link ;




    }


     public function FixLink2($pid)
     {
         $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
         $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/";
         $bodytext = ""; $bodytext0="";
         $link = explode("\r\n", $pid);
         $bodytext01 = str_replace("<link ", "<a href='", $link);
         $bodytext02 = str_replace("- external-link-new-window", "' class='external-link-new-window' data-htmlarea-external='1' ", $bodytext01);
         //$bodytext002 = str_replace("\"\"", "' '", $bodytext02);
         $bodytext001 = str_replace("'", "\"", $bodytext02);
         $bodytext003 = str_replace("\"", "'", $bodytext001);
         $bodytext004 = str_replace(">", "'>", $bodytext003);
         $bodytext04 = str_replace(array('<br /\'>','</iframe\'>','</link\'>','</div\'>','</blockquote\'>','</span\'>','</i\'>','</p\'>','<b\'>','</b\'>','<i\'>','<div\'>','</a\'>'), array('<br />','</iframe>','</link>','</div>','</blockquote>','</span>','</i>','</p>','<b>','</b>','<i>','<div>','</a>'), $bodytext004);
         $bodytext040= str_replace(array('\'\'>','</link>'), array('\'>','</a>'), $bodytext04);
         if(!(stristr($bodytext040, '<img src=\''.$path))){
             $bodytext040 =  str_replace("<img src='", "<img src='".$path, $bodytext040);
         }
         $bodytext0400 = str_replace(array('\' \'>'), array('\'>'), $bodytext040);
         $bodytext0400_final = str_replace("\t", "", $bodytext0400);
         $audio = "<audio preload='metadata' webkit-playsinline controls='controls' style='margin: 0; padding: 0; width:100%;'>";

         for ($i = 0; $i <= sizeof($bodytext0400_final); $i++) {
             if (stristr($bodytext0400_final[$i], '.mp3')) {
                 $bodytext0 .= "<p>".$audio . str_replace(" - mediaFile", " ' type='audio/mpeg'", $bodytext0400_final[$i]) ;
                 $bodytext0 = str_replace(array('<a href=\'','</a>'), array('<source src=\'','</source></audio>'), $bodytext0);
                 $explode = explode("type='audio/mpeg'", $bodytext0);
                 $bodytext .=$explode[0] ."type='audio/mpeg'></source></audio></p>";
             } else if (stristr($bodytext0400_final[$i], '<blockquote')){
                 $bodytext .= $bodytext0400_final[$i];
             }
             else if(stristr($link[$i], '.mp4') ){
                 $explode = explode("- mediaFile", $link[$i]);
                 $explodeSrc = explode("<link ", $explode[0]);
                 $explodePoster = explode(">", $explode[1]);

                 if(stristr($explodeSrc[1], '"')){
                     $explodeSrcImg = explode("\"", $explodeSrc[1]);
                     $srcImg = $explodeSrcImg[1];
                 }else{
                     $srcImg = $explodeSrc[1];
                 }
                 //return $explodeSrc;
                // $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$explodeSrc[1]."' type='video/mp4'></video></p>";
                 $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$srcImg."' type='video/mp4'></video></p>";
             }
             else if(stristr($link[$i], '.flv') ){
                 $explode = explode("- mediaFile", $link[$i]);
                 $explodeSrc = explode("<link ", $explode[0]);
                 $explodePoster = explode(">", $explode[1]);
                 if(stristr($explodeSrc[1], '"')){
                     $explodeSrcImg = explode("\"", $explodeSrc[1]);
                     $srcImg = $explodeSrcImg[1];
                 }else{
                     $srcImg = $explodeSrc[1];
                 }
                 $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$srcImg."' type='video/flv'></video></p>";
             }
             else if(stristr($link[$i], '.mov') ){
                 $explode = explode("- mediaFile", $link[$i]);
                 $explodeSrc = explode("<link ", $explode[0]);
                 $explodePoster = explode(">", $explode[1]);
                 if(stristr($explodeSrc[1], '"')){
                     $explodeSrcImg = explode("\"", $explodeSrc[1]);
                     $srcImg = $explodeSrcImg[1];
                 }else{
                     $srcImg = $explodeSrc[1];
                 }
                 $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$srcImg."' type='video/mov'></video></p>";
             }
             else if(stristr($link[$i], '.avi') ){
                 $explode = explode("- mediaFile", $link[$i]);
                 $explodeSrc = explode("<link ", $explode[0]);
                 $explodePoster = explode(">", $explode[1]);
                 if(stristr($explodeSrc[1], '"')){
                     $explodeSrcImg = explode("\"", $explodeSrc[1]);
                     $srcImg = $explodeSrcImg[1];
                 }else{
                     $srcImg = $explodeSrc[1];
                 }
                 $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$srcImg."' type='video/avi'></video></p>";
             }
             else if(stristr($link[$i], '.wmv') ){
                 $explode = explode("- mediaFile", $link[$i]);
                 $explodeSrc = explode("<link ", $explode[0]);
                 $explodePoster = explode(">", $explode[1]);
                 if(stristr($explodeSrc[1], '"')){
                     $explodeSrcImg = explode("\"", $explodeSrc[1]);
                     $srcImg = $explodeSrcImg[1];
                 }else{
                     $srcImg = $explodeSrc[1];
                 }
                 $bodytext  .=  "<p><video width='100%' poster='".$explodePoster[0]."' height='auto' controls><source src='".$srcImg."' type='video/wmv'></video></p>";
             }
             else{
                 $bodytext .= "<p>".$bodytext0400_final[$i]."</p>";
             }
         }
         $bodytext0400_final1 = str_replace(array('&lt;','&gt;','&amp;','&quot;','&apos;','<p></p>','</blockquote></p>'),array('<','>','&','"','\'','','</blockquote>') ,$bodytext);
         $bodytext0400_final01 =  str_replace(array('<p><div','</div></p>','</a></blockquote>','<svg ','</svg>','</p><p><p style=\'','<p><p style=\'','<div style=\'padding:16px;\'> <span style=\' background:#FFFFFF;','</a></span>'),array('<div','</div>','</a></p></blockquote>','<p><svg','</svg></p>','<p style=\'','<p>&nbsp;</p><p style=\'','<div style=\'padding:16px;\'><p> <span style=\' background:#FFFFFF;','</a></span></p>'),$bodytext0400_final1);
         $bodytext0400_final02 =  str_replace(array('</a></span></p></p>','Sieh dir diesen Beitrag auf Instagram an'),array('</a></span></p>','<p> Sieh dir diesen Beitrag auf Instagram an </p>'),$bodytext0400_final01);
         $bodytext0400_final03 =  str_replace(array('RADIO TOP</a></span></p> (@diisradiotop)'),array('RADIO TOP</a></span> (@diisradiotop)'),$bodytext0400_final02);
         $bodytext0400_final04 = str_replace(array('<p></a>'),array('<p>&nbsp;</p>'),$bodytext0400_final03);
         $bodytext0400_final05 =  str_replace(array('<p><h1">','</h1"></p>','<p><h2">','</h2"></p>','<p><h3">','</h3"></p>','<p><h4">','</h4"></p>','<p><h5">','</h5"></p>','<p><h6">','</h6"></p>'),array('<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<h5>','</h5>','<h6>','</h6>'),$bodytext0400_final04);
         $bodytext0400_final06 = str_replace(array('<p><h1\'>','</h1\'></p>','<p><h2\'>','</h2\'></p>','<p><h3\'>','</h3\'></p>','<p><h4\'>','</h4\'></p>','<p><h5\'>','</h5\'></p>','<p><h6\'>','</h6\'></p>'),array('<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<h5>','</h5>','<h6>','</h6>'),$bodytext0400_final05);
         $bodytext0400_final07 = str_replace(array('<span style=\' background:#FFFFFF;'),array('<p><span style=\' background:#FFFFFF;'),$bodytext0400_final06);
         return $bodytext0400_final07;





     }


    public function FixVideo($pid)
    {
        $bodytext = [];
        $link = explode("\r\n", $pid);
        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/";
        for ($i = 0; $i <= sizeof($link); $i++) {
            $link0 = explode("<link ", $link[$i]);
            if (sizeof($link0) > 1) {
                $link01 = explode(" - mediaFile", $link0[1]);
                $link02 = explode(" - external-link-new-window", $link0[1]);
                if (sizeof($link01) > 1) {
                    $link010 = trim($link01[1], " ");
                    $link0100 = explode(">", $link010);

                    if (stristr($link01[0], '.mp4')) {
                        $type = "video";
                    }

                    if ($type == "video") {
                        $uri = str_replace("\"", "", $link01[0]);
                        $mediaFile = str_replace("\"", "", $link0100[0]);
                        array_push($bodytext, array("type" => "video", "uri" => $uri, "mediaFile" => $mediaFile));
                    }
                }
            }

        }
        return $bodytext;

    }

    public function FixAudio($pid)
    {
        $bodytext = [];
        $link = explode("\r\n", $pid);
        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/";
        for ($i = 0; $i <= sizeof($link); $i++) {
            $link0 = explode("<link ", $link[$i]);
            if (sizeof($link0) > 1) {
                $link01 = explode(" - mediaFile", $link0[1]);
                $link02 = explode(" - external-link-new-window", $link0[1]);
                if (sizeof($link01) > 1) {
                    $link010 = trim($link01[1], " ");
                    $link0100 = explode(">", $link010);
                    if (stristr($link01[0], '.mp3')) {
                        $type = "audio";
                    }

                    if ($type == "audio") {
                        $uri = str_replace("\"", "", $link01[0]);
                        array_push($bodytext, array("mediafile" => "", "src" => $uri, "type" => $type));
                    }
                }
            }

        }
        return $bodytext;

    }


    public function Articleurl($pid)
    {
        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/";
        /******************category*********************/
        $fields = '*';
        $table = 'tx_realurl_urldata';
        $where = 'tx_realurl_urldata.original_url LIKE \'%&tx_news_pi1%5Bnews%5D='.$pid.'%\' AND tx_realurl_urldata.original_url  NOT LIKE \'%tx_newscomment_newscomment%\'';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            if (stristr($recordcategory['speaking_url'], '/detail/')) {
                $url = $path.$recordcategory['speaking_url'];
                array_push($ttContentcategory, array('uid' => $url));
            }

        }
        $array = array_unique($ttContentcategory);
        return $array[0]['uid'];

    }

    function stripslashes_arr($value)
    {
        $value = is_array($value) ?
            array_map('stripslashes_arr', $value) :
            stripslashes($value);

        return $value;
    }

    public function votes($pid)
    {
        /******************category*********************/
        $fields = 'pi_flexform';
        $table = 'tt_content';
        $where = 'tt_content.list_type = "pingagpoll_poll" AND tt_content.hidden = 0 AND tt_content.deleted = 0 AND tt_content.tx_news_related_news='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
            $flexFormData = $flexformService->convertFlexFormContentToArray($recordcategory['pi_flexform']);
            array_push($ttContentcategory, array('question' => array('uid' =>$flexFormData['settings']['poll'] ,'title' => $this->titlepoll($flexFormData['settings']['poll']))),array('answer' =>  $this->titleAnsours($flexFormData['settings']['poll'])));


        }

        return $ttContentcategory;

    }
    public function contentElement($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'tt_content';
        $where = 'tt_content.list_type = " " AND tt_content.hidden = 0 AND tt_content.deleted = 0 AND tt_content.tx_news_related_news='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {

            array_push($ttContentcategory,$recordcategory['bodytext']);


        }

        return $ttContentcategory;

    }
    public function pawermail($pid)
    {
        /******************category*********************/
        $fields = 'pi_flexform';
        $table = 'tt_content';
        $where = 'tt_content.list_type = "powermail_pi1" AND tt_content.hidden = 0 AND tt_content.deleted = 0 AND tt_content.tx_news_related_news='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
            $flexFormData = $flexformService->convertFlexFormContentToArray($recordcategory['pi_flexform']);
            $idForm = $flexFormData['settings']['flexform']['main']['form'];
            $nameReceiver = $flexFormData['settings']['flexform']['receiver']['name'];
            $emailReceiver = $flexFormData['settings']['flexform']['receiver']['email'];
            $subjectReceiver = $flexFormData['settings']['flexform']['receiver']['subject'];
            $nameSender = $flexFormData['settings']['flexform']['sender']['name'];
            $emailSender = $flexFormData['settings']['flexform']['sender']['email'];
            $subjectSender = $flexFormData['settings']['flexform']['sender']['subject'];
            array_push($ttContentcategory, array("uid"=>$idForm ,"nameReceiver"=>$nameReceiver,"emailReceiver"=>$emailReceiver,"subjectReceiver"=>$subjectReceiver,"nameSender"=>$nameSender,"emailSender"=>$emailSender,"subjectSender"=>$subjectSender,"Form"=>$this->pawermailField($idForm)));


        }

        return $ttContentcategory;

    }

    public function pawermailField($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'tx_powermail_domain_model_form';
        $where = 'tx_powermail_domain_model_form.uid='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {

            array_push($ttContentcategory, array("title"=>$recordcategory['title'],'Field'=> $this->FieldPages($recordcategory['uid'])));


        }

        return $ttContentcategory[0];

    }

    public function FieldPages($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'tx_powermail_domain_model_page';
        $where = 'tx_powermail_domain_model_page.forms='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $uid ="";
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {

            $uid.=$recordcategory['uid'].",";


        }
        $uidIn = rtrim($uid, ",");

        $fields1 = '*';
        $table1 = 'tx_powermail_domain_model_field';
        $where1 = 'tx_powermail_domain_model_field.deleted = 0 and tx_powermail_domain_model_field.hidden = 0 and tx_powermail_domain_model_field.pages IN('.$uidIn.')';
        $groupBy1 = '';
        $orderBy1 = '';
        $limit1 = '';
        $rescategory1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields1, $table1, $where1, $groupBy1, $orderBy1, $limit1);
        $ttContentcategory = array();
        $udSubmit = "";
        while (($recordcategory1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory1))) {
            if($recordcategory1['type'] == 'submit'){
                $udSubmit.=$recordcategory1['uid'];
            }else{
                array_push($ttContentcategory, array("uid"=>$recordcategory1['uid'],"title"=>$recordcategory1['title'],'type'=> $recordcategory1['type'],'placeholder'=> $recordcategory1['placeholder'],'mandatory'=>$recordcategory1['mandatory']));
            }



        }

        $fields0 = '*';
        $table0 = 'tx_powermail_domain_model_field';
        $where0 = 'tx_powermail_domain_model_field.deleted = 0 and tx_powermail_domain_model_field.hidden = 0 and tx_powermail_domain_model_field.uid ='.$udSubmit;
        $groupBy0 = '';
        $orderBy0 = '';
        $limit0 = '';
        $rescategory0 = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields0, $table0, $where0, $groupBy0, $orderBy0, $limit0);
        $ttContentcategory0 = array();
        while (($recordcategory01 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory0))) {

                array_push($ttContentcategory0, array("title"=>$recordcategory01['title'],'type'=> $recordcategory01['type']));


        }
        $ttContentcategoryFinal = array_merge($ttContentcategory ,$ttContentcategory0);
        return $ttContentcategoryFinal;

    }

    public function titlepoll($pid)
    {
        /******************category*********************/
        $fields = 'title';
        $table = 'tx_pingagpoll_domain_model_poll';
        $where = 'tx_pingagpoll_domain_model_poll.uid='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {

            array_push($ttContentcategory, $recordcategory['title']);


        }

        return $ttContentcategory[0];

    }

    public function titleAnsours($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'tx_pingagpoll_domain_model_answer';
        $where = 'tx_pingagpoll_domain_model_answer.poll='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {

            array_push($ttContentcategory, array('uid'=>$recordcategory['uid'] ,'bodytext'=>$recordcategory['bodytext'],'votes'=>$recordcategory['votes']));


        }

        return $ttContentcategory;

    }

    /**
     * action voteslike
     *
     * @return void
     */
    public function voteslikeAction()
    {
        $pid = (int)$this->request->getArgument('uid');
        $fields = '*';
        $table = 'tx_pingagpoll_domain_model_answer';
        $where = $pid . '=tx_pingagpoll_domain_model_answer.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory,$record['votes']);
        }

        $likes = $ttContentcategory[0] + 1;
        $updateArray = array(
            'votes' => $likes,
        );
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery ('tx_pingagpoll_domain_model_answer','uid = '.'"'.$pid.'"',$updateArray, TRUE);

        $this->view->assign('value',['success' => 1]);


    }


    /**
     * action send
     *
     * @return void
     */
    public function sendAction()
    {
        $mail = new Mail();
        $objectStorage = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\ObjectStorage');
        $arguments = $this->request->getArguments();

        $formuid = $arguments['formdata']['uidForm'];
        $pid = $arguments['formdata']['uidNews'];

        $fields = 'pi_flexform';
        $table = 'tt_content';
        $where = 'tt_content.list_type = "powermail_pi1" AND tt_content.hidden = 0 AND tt_content.deleted = 0 AND tt_content.tx_news_related_news='.$pid;
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
            $flexFormData = $flexformService->convertFlexFormContentToArray($recordcategory['pi_flexform']);
            $this->settings = $flexFormData['settings']['flexform'];
        }

        $form = $this->formRepository->findByUid((int)$formuid);
        if($form) {
            $mail->setForm($form);
            foreach($arguments['formdata'] as $key =>$field){
                if(stristr($key, 'field')){
                    $uid = explode("field", $key);
                    $fieldUID = $this->fieldRepository->findByUid((int)$uid[1]);
                    $Answer = new Answer();
                    $Answer->setValue($field);
                    $Answer->setValueType(0);
                    $Answer->setField($fieldUID);
                    $Answer->setPid(1057);
                    $objectStorage->attach($Answer);
                }
            }

            $mail->setAnswers($objectStorage);
        }


        //DebugUtility::debug($this->settings);

        $mailFactory = $this->objectManager->get(MailFactory::class);
        $mailFactory->prepareMailForPersistence($mail, $this->settings);
        $this->mailRepository->add($mail);
        $this->persistenceManager->persistAll();
        /*$this->mailRepository->add($mail);
        $this->persistenceManager->persistAll();*/
        //DebugUtility::debug($mail);

      //  $this->signalDispatch(__CLASS__, __FUNCTION__ . 'BeforeRenderView', [$form, $this]);
        $this->view->assign('value',['success' => 1]);


    }



}


