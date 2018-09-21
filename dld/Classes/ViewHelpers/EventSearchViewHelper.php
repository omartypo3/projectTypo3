<?php

namespace DLD\Dld\ViewHelpers;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EventSearchViewHelper  extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    /**
     *
     * @param string $redirect
     *
     */
    public function render($redirect)
    {

        $fields = '*';
        $table = 'tx_dld_domain_model_application, tx_dld_domain_model_event';
        $where = " tx_dld_domain_model_application.event_id=tx_dld_domain_model_event.uid  and 	tx_dld_domain_model_application.uid=".$redirect;//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
        if ($resCount) {
            $record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        }
        return $record;
    }

}