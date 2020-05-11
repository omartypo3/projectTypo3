<?php

namespace Cundd\CustomRest\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * An example Extbase controller that will be called through REST
 */
class NewssController  extends \GeorgRinger\News\Controller\NewsController
{

    public function help(){

    }
    /**
     * Output a list view of news
     *
     * @param array $overwriteDemand
     * @return void
     */
    public function listNews(array $setting= null , array $overwriteDemand = null )
    {
         $this->settings['orderBy'] = $setting['settingOrderBy'];
         $this->settings['orderDirection'] = $setting['settingorderDirection'];
         $this->settings['categories'] = $setting['settingcategories'];
         $this->settings['categoryConjunction'] = $setting['settingcategoryConjunction'];
         $this->settings['includeSubCategories'] = $setting['settingincludeSubCategories'];
         $this->settings['templateLayout'] =$setting['settingtemplateLayout'];
         $this->settings['limit'] = $setting['settinglimit'];
         $this->settings['hidePagination'] = '1';
         $this->settings['topNewsFirst'] = '0';
         $this->settings['excludeAlreadyDisplayedNews'] = $setting['settingexcludeAlreadyDisplayedNews'];
         $this->settings['disableOverrideDemand'] = $setting['settingdisableOverrideDemand'];
         $this->settings['previewHiddenRecords'] = $setting['settingOrderBy'];

        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== null) {
            $demand = $this->overwriteDemandObject($demand, $overwriteDemand);
        }
        $newsRecords = $this->newsRepository->findDemanded($demand);
        $full =[];
        foreach ($newsRecords as $n){
            $uid = $n->getUid();
            $GLOBALS['EXT']['news']['alreadyDisplayed'][$uid] = $uid;
            //array_push($full,$uid);
            $Arr = ["uid" => $uid,
                "TemplateLayout" => $this->settings['templateLayout']
            ];
            array_push($full,$Arr);
            }
        return $full;
    }
}


