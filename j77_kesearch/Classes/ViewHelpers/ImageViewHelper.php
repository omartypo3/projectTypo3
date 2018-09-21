<?php

namespace TYPO3\J77Kesearch\ViewHelpers;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ImageViewHelper  extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**

     * @param string $variantens
     * @throws Exception

     */

    public function render($variantens) {


        $fields = '*';
        $table = 'fe_users,sys_file_reference,sys_file';
        $where = $variantens.'=sys_file_reference.uid_foreign  and sys_file_reference.deleted=0  and sys_file_reference.hidden=0 and sys_file_reference.tablenames="fe_users" and sys_file_reference.uid_local=sys_file.uid';//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);
        $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
        if($resCount) {
            while ( ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) ) {
                return $record['identifier'];
            }
        }

    }
}