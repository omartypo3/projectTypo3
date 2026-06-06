<?php
namespace BravoBuero\BbPortfolio\Hook;

use TYPO3\CMS\Core\DataHandling\DataHandler;

class TCEmainHook {
    public function processCmdmap_preProcess($command, $table, $id, $value, DataHandler &$pObj) {}

    public function processCmdmap_postProcess($command, $table, $id, $value, DataHandler &$pObj) {}

    public function processDatamap_preProcessFieldArray(array &$fieldArray, $table, $id, DataHandler &$pObj) {}

    public function processCmdmap_deleteAction($table, $id, $recordToDelete, DataHandler &$pObj, $recordWasDeleted = null) {}

    public function processDatamap_afterAllOperations(DataHandler &$pObj) {}

    public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray, DataHandler &$pObj) {
        if ($table === 'tx_bbportfolio_domain_model_portfolio') {
            if (isset($fieldArray["kundennamecheck"]) && $fieldArray["kundennamecheck"]) {
                $fieldArray["kundenname"] = '';
                $fieldArray["kunde"] = null;
            }
        }
    }

    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, DataHandler &$pObj) {}
}
