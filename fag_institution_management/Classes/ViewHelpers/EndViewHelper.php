<?php

namespace FRONTAL\FagInstitutionManagement\ViewHelpers;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EndViewHelper  extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**

     * @param string $variantens
     * @throws Exception

     */

    public function render($variantens) {


        $fields = '*';
        $table = 'tx_fagcalendar_domain_model_event';
        $where = $variantens.'=tx_fagcalendar_domain_model_event.uid';
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);
        $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
        if($resCount) {
            while ( ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) ) {
                return (int)$record['end_time'];
            }
        }

    }
}