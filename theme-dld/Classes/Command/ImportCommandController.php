<?php
namespace Theme\Command;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImportCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {


	public function deleteCommand ( )
    {

        $fields = '*';
        $table = 'fe_users';
        $where = time() - 60 . ' <= tstamp  AND deleted = 0';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);

        // Has the SQL query returned a result? If so, analyze each entry
        $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);

        if ($resCount) {
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE tx_realurl_pathdata');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE tx_realurl_uniqalias');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE tx_realurl_uniqalias_cache_map');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE tx_realurl_urldata');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_pages');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_hash');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_hash_tags');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_rootline');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_pagesection');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_pages_tags');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_pagesection_tags');
            $GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE cf_cache_rootline_tags');
        }
    }

}

?>