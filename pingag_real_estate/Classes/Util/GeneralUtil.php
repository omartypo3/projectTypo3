<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 21.08.2018
 * Time: 15:45
 */

namespace Pingag\PingagRealEstate\Util;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class GeneralUtil
{

    public static function translate($id, $arguments = array())
    {
        return LocalizationUtility::translate($id, 'pingag_real_estate', $arguments);
    }

    public static function camelCaseToSnake($value, $delimiter = '_')
    {
        if (!ctype_lower($value)) {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }
        return $value;
    }
}