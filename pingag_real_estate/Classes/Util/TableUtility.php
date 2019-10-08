<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 13.08.2018
 * Time: 12:58
 */

namespace Pingag\PingagRealEstate\Util;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class TableUtility
{

    public static function truncate($table)
    {
        return $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery($table);
    }

    public static function delete($table, $where)
    {
        return $GLOBALS['TYPO3_DB']->exec_DELETEquery($table, $where);
    }
}