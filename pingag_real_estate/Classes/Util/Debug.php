<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.03.2018
 * Time: 10:20
 */

namespace Pingag\PingagRealEstate\Util;


class Debug
{

    const PINGAG_IP = '85.195.252.43';
    
    public static function isPingag()
    {
        return $_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP;
    }   
}