<?php

class tx_wservice_scheduler_cleartask extends tx_scheduler_Task {


    public function execute() {

        $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
            'tx_wservice_domain_model_servicepartner',
            'deleted = 0 AND hidden = 0',
            array (
                'lat' => '',
                'lng' => ''
            )

        );

        return TRUE;
    }


    public function getAdditionalInformation() {
       // return 'Clear';
    }
}

?>