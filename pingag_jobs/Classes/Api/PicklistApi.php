<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 24.07.2018
 * Time: 15:23
 */

namespace Pingag\PingagJobs\Api;


class PicklistApi extends PeoplexsApiBase
{


    protected function getServiceUrl()
    {
        return 'http://api.peoplexs.com/Portalxs/Webservices/v11/picklistsXS.cfc?wsdl';
    }
    
    public function getAllLists()
    {
        $lists = $this->call('list');
        return $lists;
    }
    
    public function getListOptions($listName, $locale)
    {
        $lists = $this->getAllLists()->data;
        $options = array_filter($lists, function ($listItem) use($listName, $locale){
            return $listItem[1] === $listName
                && $listItem[2] === $locale
                && $listItem[10] === 0
                && !empty($listItem[3]);
        });
        
        $result = [];
        foreach ($options as $option) {
            $result[$option[0]] = $option[3];
        }
        return $result;
    }
}