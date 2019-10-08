<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 21.09.2018
 * Time: 16:49
 */

namespace Pingag\PingagRealEstate\Service;

class GeoInfoApi
{

    const API_BASE_URL = 'https://api3.geo.admin.ch/rest/services/api/';
    const VALID_TYPES = ['locations', 'layers', 'featuresearch'];
    const VALID_ORIGINS = ['zipcode', 'gg25', 'district', 'kantone', 'gazetteer', 'address', 'parcel'];

    /**
     * @param $searchText
     * @param $type
     * @param array $origins
     * @throws \Exception
     */
    public function search($searchText, $type, array $origins)
    {
        $this->validateType($type);
        $this->validateOrigins($origins);
        
        
    }
    
    /**
     * @param $type
     * @return bool
     * @throws \Exception
     */
    protected function validateType($type)
    {
        if(!in_array($type, self::VALID_TYPES)){
            $types = implode(', ',self::VALID_TYPES);
            throw new \Exception("Invalid type: {$type}. <br>Possible types are: {$types}.");
        }
        return true;
    }

    /**
     * @param array $origins
     * @return bool
     * @throws \Exception
     */
    protected function validateOrigins(array $origins)
    {
        foreach ($origins as $origin){
            if(!in_array($origin, self::VALID_ORIGINS)){
                $validOrigins = implode(', ',self::VALID_ORIGINS);
                throw new \Exception("Invalid origin found: {$origin}. <br>Possible origins are: {$validOrigins}");
            }
        }
        return true;
    }
}