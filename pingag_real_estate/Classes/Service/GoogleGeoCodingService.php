<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.08.2018
 * Time: 09:13
 */

namespace Pingag\PingagRealEstate\Service;


class GoogleGeoCodingService
{

    const REQUEST_FORMAT = 'https://maps.googleapis.com/maps/api/geocode/outputFormat=json';
    const API_KEY = 'AIzaSyCjFF2rkh35IA3ERLifoCgGnYcwI37MJPM';
    
    const QUERIES_PER_SECOND = 50;
    
    public function findCoordinates()
    {
        
    }
}