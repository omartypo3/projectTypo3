<?php

namespace Cundd\CustomRest\Controller;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * An example Extbase controller that will be called through REST
 */
class ContentController extends ActionController
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
     * @var \Cundd\CustomRest\Controller\NewssController
     * @inject
     */
    protected $newsscontroller;

    /**
     * newsRepository
     *
     * @var \GeorgRinger\News\Domain\Repository\NewsRepository
     * @inject
     */
    protected $newsRepository;

    /**
     * action Content
     *
     * @return void
     */
    public function contentAction()
    {
        $this->t3pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $pid = 1;
        $fields = 'uid';
        $sortField = 'sorting';
        $constraints = ' hidden = 0 and deleted = 0';
        $pages = $this->t3pageRepository->getMenu($pid, $fields, $sortField);

        foreach ($pages as &$page) {
            $subPages1 = $this->t3pageRepository->getMenu($page['uid'], $fields, $sortField);
            if (count($subPages1) > 0) {

                foreach ($subPages1 as &$subPage1) {
                    $subPages2 = $this->t3pageRepository->getMenu($subPage1['uid'], $fields, $sortField);
                    $this->TTcontent($subPage1['uid']);
                    if (count($subPages2 > 0)) {
                        $subPage1['subpages'] = $subPages2;
                        $subPage1['content'] = $this->TTcontent($subPage1['uid']);
                    }
                }
            }
            $page['subpages'] = $subPages1;
            $page['content'] = $this->TTcontent($page['uid']);


        }
        $this->view->assign(
            'value',
            $pages
        );


    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {

        $GLOBALS['EXT']['news']['alreadyDisplayed'] = [];
        $pid = (int)$this->request->getArgument('uid');
        $result = array_merge($this->TTcontent($pid, 0), $this->TTcontent($pid, 2));
        $this->view->assign(
            'value',
            array("typoscript" => $this->constant($pid), "contentElements" => $result)
        );
    }

    public function TTcontent($pid, $colpos)
    {
        $fields = '*';
        $table = 'tt_content';
        $where = $pid . '=tt_content.pid  and tt_content.deleted=0  and tt_content.hidden=0 and colPos=' . $colpos;
        $groupBy = '';
        $orderBy = 'sorting';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentConfig0 = [];
        $searchUid = [];

        while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
            if ($record['list_type'] == "news_pi1" && $record['tx_mask_content_parent'] == 0) {
                $xml = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($record['pi_flexform']);
                $settingArr = [];
                $settingArr = $this->GetSettingsFromArray($xml);
                $v = $this->newsscontroller->listNews($settingArr);
                $content = $this->contentNews($v);
                if (!empty($content)) {
                    array_push($ttContentConfig0, $this->contentNews($v));
                }
                // array_push($ttContentConfig0, $v);
            }
            if ($record['CType'] == 'mask_content_block') {
                $searchUid = $this->searchMaskcolPos0($record['uid']);
                if (!empty($searchUid)) {
                    array_push($ttContentConfig0, array($record['CType'] => $searchUid));
                }
            } else if ($record['records']) {
                $records = explode(",", $record['records']);
                array_push($ttContentConfig0, $this->Records($records));
            } else if ($record['tx_dce_dce'] != 0) {
                $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
                $flexFormData = $flexformService->convertFlexFormContentToArray($record['pi_flexform']);
                array_push($ttContentConfig0, array($record['CType'] => $flexFormData['settings']));

            }
        }

        // return $ttContentConfig0;
        return $ttContentConfig0;
    }

    public function Records($pids)
    {
        $ttContentConfig0 = [];
        foreach ($pids as $pid) {
            $records = explode("tt_content_", $pid);
            $fields = '*';
            $table = 'tt_content';
            $where = $records['1'] . '=tt_content.uid  and tt_content.deleted=0  and tt_content.hidden=0';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
            //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
            $groupBy = '';
            $orderBy = '';
            $limit = '';
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
            // $ttContentConfig0 = [];
            while (($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
                //$flexFormData = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($record['pi_flexform']);
                $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
                $flexFormData = $flexformService->convertFlexFormContentToArray($record['pi_flexform']);
                if ($record['pi_flexform']) {
                    array_push($ttContentConfig0, array($record['CType'] => $flexFormData['settings']));
                }
            }
        }
        return $ttContentConfig0;
    }

    public function searchMaskcolPos0($pids)
    {
        $fields = '*';
        $table = 'tt_content ';
        $where = $pids . '=tt_content.tx_mask_content_parent  and tt_content.deleted=0  and tt_content.hidden=0';
        $groupBy = '';
        $orderBy = 'sorting';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $news = [];
        $ttContentConfig0 = [];
        while (($record0 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
            if (substr_count($record0['CType'], 'dce_dceuid') == 1) {
                $flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
                $flexFormData1 = $flexformService->convertFlexFormContentToArray($record0['pi_flexform']);
                array_push($ttContentConfig0, array($record0['CType'] => $flexFormData1));
            } else if ($record0['list_type'] == "news_pi1") {
                $xml = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($record0['pi_flexform']);
                $settingArr = [];
                $settingArr = $this->GetSettingsFromArray($xml);
                $v = $this->newsscontroller->listNews($settingArr);
                $content = $this->contentNews($v);
                if (!empty($content)) {
                    array_push($ttContentConfig0, $this->contentNews($v));
                }
                //array_push($ttContentConfig0,$v);
            }
        }

        return $ttContentConfig0;
    }

    public function contentNews($pids)
    {
        $ttContentConfig0 = [];
        foreach ($pids as $tt_content) {
            $fields = '*';
            $table = 'tx_news_domain_model_news ';
            $where = $tt_content['uid'] . '=tx_news_domain_model_news.uid';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
            //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
            $groupBy = '';
            $orderBy = 'sorting';
            $limit = '';
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);

            while (($record0 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
                //$datetime = $record0['tstamp'];
                $datetime0 = $record0['datetime'];
                $datetimeFormat = 'm.d.y';
                $date = new \DateTime();
                $date->setTimestamp($datetime0);
                $today = date("m.d.y");
                $datetoday = strtotime($today);

                $tstamp = strtotime($date->format($datetimeFormat));
                if ($tstamp == $datetoday) {
                    $datetime = "Aktualisiert heute um " . date('H:i', $record0['tstamp']);
                } else {
                    $datetime = "Aktualisiert am " . date('d.m.Y , H:i', $record0['tstamp']);
                }
                if ($record0['fal_media'] >= 2) {
                    $hasGallery = 1;
                } else {
                    $hasGallery = 0;
                }
                if ((stristr($record0['bodytext'], '/medien/')) || (preg_match("www.youtube.com", $record0['bodytext'])) || (preg_match("/video/", $record0['bodytext']))) {
                    $hasVideo = 1;
                } else {
                    $hasVideo = 0;
                }


                if (preg_match("/audio/", $record0['bodytext'])) {
                    $hasAudio = 1;
                } else {
                    $hasAudio = 0;
                }

                $tag = $this->TTtag($record0['uid']);
                if ($this->TTimageprocessedfile($record0['uid'], fal_media)) {
                    $Process = $this->TTimageprocessedfile($record0['uid'], fal_media);
                    $withProcess =  $Process['width'];
                    $heightProcess =  $Process['height'];
                    array_push($ttContentConfig0, array("news_pi1" => array("uid" => $record0['uid'], "title" => $record0['title'], "aktualisiert" => $datetime, "hasVideo" => $hasVideo, "hasAudio" => $hasAudio, "hasGallery" => $hasGallery, "tags" => $tag, "image" => $this->TTimage($record0['uid'], fal_media), "imageCrop" => $this->TTimageprocessedfile($record0['uid'], fal_media), "imageSmall" => $this->TTimageSmall($record0['uid'], fal_media ,$withProcess ,$heightProcess), "templateLayout" => $tt_content['TemplateLayout'])));
                } else {
                    array_push($ttContentConfig0, array("news_pi1" => array("uid" => $record0['uid'], "title" => $record0['title'], "aktualisiert" => $datetime, "hasVideo" => $hasVideo, "hasAudio" => $hasAudio, "hasGallery" => $hasGallery, "tags" => $tag, "image" => $this->TTimage($record0['uid'], fal_media), "imageCrop" => $this->TTimageprocessedfile($record0['uid'], fal_media), "imageSmall" => $this->TTimageSmall($record0['uid'], fal_media , 0 ,0), "templateLayout" => $tt_content['TemplateLayout'])));

                }

            }

        }

        return $ttContentConfig0;
    }

    public function TTimage($pid, $type)
    {
        /******************category*********************/
        $fields = 'identifier, storage , title ,description,alternative';
        $table = 'sys_file_reference,sys_file';
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
            array_push($ttContentcategory, array('path' => $path));
            //array_push($ttContentcategory, array('path' => $recordcategory['uid']));
        }
        return $ttContentcategory[0];

    }

    public function TTimageSmall($pid, $type ,$width, $height)
    {
        /******************category*********************/
        $fields = 'identifier, size, storage , title ,description,alternative';
        $table = 'sys_file_reference,sys_file';
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

            $small_crop = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/".$this->crop($recordcategory['identifier'], $path ,$width, $height);
            array_push($ttContentcategory, array('path' => $small_crop));
        }
        return $ttContentcategory[0];

    }


    public function crop($pid, $path ,$width, $height)
    {
        $sourceProperties = getimagesize($path);
        $filename = pathinfo($pid);
        $fileNewName = $filename['filename'];
        $folderPath = "fileadmin/small_app/";
        $ext = pathinfo($pid, PATHINFO_EXTENSION);
        $filenameUrl = $folderPath . $fileNewName . "_thumbnail." . $ext;

        if (!file_exists($filenameUrl)) {


            $imageType = $sourceProperties[2];
            switch ($imageType) {
                case IMAGETYPE_PNG:
                    $imageResourceId = imagecreatefrompng($path);
                    if($width==0 && $height==0){
                        $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    }else{
                        $targetLayer = $this->imageResize($imageResourceId, $width, $height);
                    }
                    imagepng($targetLayer, $folderPath . $fileNewName . "_thumbnail." . $ext);
                    break;


                case IMAGETYPE_GIF:
                    $imageResourceId = imagecreatefromgif($path);
                    if($width==0 && $height==0){
                        $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    }else{
                        $targetLayer = $this->imageResize($imageResourceId, $width, $height);
                    }
                    imagegif($targetLayer, $folderPath . $fileNewName . "_thumbnail." . $ext);
                    break;


                case IMAGETYPE_JPEG:

                    $imageResourceId = imagecreatefromjpeg($path);
                    if($width==0 && $height==0){
                        $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                    }else{
                        $targetLayer = $this->imageResize($imageResourceId, $width, $height);
                    }
                    imagejpeg($targetLayer, $folderPath . $fileNewName . "_thumbnail." . $ext);
                    break;


            }
            move_uploaded_file($pid, $folderPath . $fileNewName . "." . $ext);
        }

        return $filenameUrl;
    }

    public function TTcategory($pid)
    {
        /******************category*********************/
        $fields1 = 'title';
        $table1 = 'sys_category';
        $where1 = $pid . '=sys_category.uid';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy1 = '';
        $orderBy1 = '';
        $limit1 = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields1, $table1, $where1, $groupBy1, $orderBy1, $limit1);

        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory, $recordcategory['title']);
        }
        return $ttContentcategory;

    }

    public function pathDce($pids, $path)
    {
        $ttContentConfig0 = [];
        $fields1 = '*';
        $table1 = 'tx_dce_domain_model_dce,tx_dce_domain_model_dcefield';
        $where1 = 'tx_dce_domain_model_dce.uid = tx_dce_domain_model_dcefield.parent_dce';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        $groupBy1 = '';
        $orderBy1 = '';
        $limit1 = '';
        $res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields1, $table1, $where1, $groupBy1, $orderBy1, $limit1);
        while (($record0 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1))) {
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
            if ((preg_match("<uploadfolder>", $record0['configuration']))) {
                $uploadfolder = explode("<uploadfolder>", $record0['configuration']);
                $uploadfolder0 = explode("</uploadfolder>", $uploadfolder['1']);
                $relativePaths = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/" . $uploadfolder0['0'];
                $dce = "dce_dceuid" . $record0['parent_dce'];
                if ($record0['parent_dce'] == 5) {
                    //   $ttContentConfig1 =  array("dce_dceuid4"=>array("relativePath"=>$relativePaths));
                    array_push($ttContentConfig0, array("dce_dceuid4" => array("relativePath" => $relativePaths)));
                }
                array_push($ttContentConfig0, array($dce => array("relativePath" => $relativePaths)));
            }
        }

        return array("path" => $ttContentConfig0[0][$pids]['relativePath']);

    }


    public function GetSettingsFromArray(array $xml = [])
    {

        $settingArr = [
            "settingOrderBy" => $xml['data']['sDEF']['lDEF']['settings.orderBy']['vDEF'],
            "settingorderDirection" => $xml['data']['sDEF']['lDEF']['settings.orderDirection']['vDEF'],
            "settingdateField" => $xml['data']['sDEF']['lDEF']['settings.dateField']['vDEF'],
            "settingcategoryConjunction" => $xml['data']['sDEF']['lDEF']['settings.categoryConjunction']['vDEF'],
            "settingcategories" => $xml['data']['sDEF']['lDEF']['settings.categories']['vDEF'],
            "settingincludeSubCategories" => $xml['data']['sDEF']['lDEF']['settings.includeSubCategories']['vDEF'],
            "settingarchiveRestriction" => $xml['data']['sDEF']['lDEF']['settings.archiveRestriction']['vDEF'],
            "settingpreviewHiddenRecords" => $xml['data']['sDEF']['lDEF']['settings.previewHiddenRecords']['vDEF'],
            "settinglimit" => $xml['data']['additional']['lDEF']['settings.limit']['vDEF'],
            "settingtopNewsFirst" => $xml['data']['additional']['lDEF']['settings.topNewsFirst ']['vDEF'],
            "settingexcludeAlreadyDisplayedNews" => $xml['data']['additional']['lDEF']['settings.excludeAlreadyDisplayedNews']['vDEF'],
            "settingdisableOverrideDemand" => $xml['data']['additional']['lDEF']['settings.disableOverrideDemand']['vDEF'],
            "settingtemplateLayout" => $xml['data']['template']['lDEF']['settings.templateLayout']['vDEF']
        ];
        return $settingArr;
    }

    public function constant($pids)
    {
        $settingArr = [];
        $fields1 = '*';
        $table1 = 'sys_template';
        $where1 = $pids . '=sys_template.pid';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        $groupBy1 = '';
        $orderBy1 = '';
        $limit1 = '';
        $res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields1, $table1, $where1, $groupBy1, $orderBy1, $limit1);
        while (($record0 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1))) {
            $googleAdServer = $record0['constants'];
            $sitetype = explode("\r\n", $googleAdServer);

            $subsectionsitetype = explode("  sitetype = ", $sitetype[1]);
            $subsectionsection = explode("  section = ", $sitetype[2]);
            $subsectionsubsection = explode("  subsection = ", $sitetype[3]);
            return array("googleAdServer" => array("sitetype" => $subsectionsitetype[1], "section" => $subsectionsection[1], "subsection" => $subsectionsubsection[1]));


        }

    }

    public function TTimageprocessedfile($pid, $type)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'sys_file_reference,sys_file,sys_file_processedfile';
        $where = $pid . '=sys_file_reference.uid_foreign and sys_file_reference.fieldname="' . $type . '" and sys_file_reference.deleted=0  and sys_file_reference.hidden=0 and sys_file_reference.tablenames="tx_news_domain_model_news" and sys_file_reference.uid_local=sys_file.uid and sys_file.uid = sys_file_processedfile.original';
        $groupBy = '';
        $orderBy = 'sorting_foreign';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
            if ($recordcategory['identifier']) {
                $path = $protocol . "://" . $_SERVER['SERVER_NAME'] . "/fileadmin" . $recordcategory['identifier'];
                $width = $recordcategory['width'];
                $height = $recordcategory['height'];
                if ($width == 571)
                    array_unique(array_push($ttContentcategory, array('path' => $path, 'width' => $width, 'height' => $height)));
                //array_push($ttContentcategory, $ttContentcategory);

            }
        }
        return $ttContentcategory[0];

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
            array_push($ttContentcategory, array('title' => $recordcategory['title']));
        }
        return $ttContentcategory;

    }

    function imageResize($imageResourceId, $width, $height)
    {

        $targetWidth = ($width / 2);
        $targetHeight = ($height / 2);
        $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        return $targetLayer;

    }
}
