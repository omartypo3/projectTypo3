<?php
namespace Avonis\WService\Scheduler;


ini_set("auto_detect_line_endings", true);

/** Include PHPExcel */
require_once( \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('w_service') . 'Classes/Utility/PHPExcel/PHPExcel.php');


class ImportTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {


    public function execute() {

        $metaPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('w_service') . 'Meta/';

        $intPath = $metaPath . 'international.xlsx';
        $usPath = $metaPath . 'us.xlsx';
        $caPath = $metaPath . 'canada.xlsx';

        if(file_exists($intPath)){
            $this->importData($intPath, 1641);
        }
        if(file_exists($usPath)){
            $this->importData($usPath, 223);
        }
        if(file_exists($caPath)){
            $this->importData($caPath, 575);
        }

        return TRUE;
    }

    public function importData($filePath, $pid){
        //Check if is a valid excel file
        $isExcel = false;
        $types = array('Excel2007', 'Excel5');
        foreach ($types as $type) {
            $reader = \PHPExcel_IOFactory::createReader($type);
            if ($reader->canRead($filePath)) {
                $isExcel = true;
                break;
            }
        }

        if($isExcel == false){
            return;
        }

        //Convert excel to CSV
        $csvFile = $this->convertXLStoCSV($filePath);

        // read CSV file
        $handle = fopen($csvFile, "r");
        $delimiter = ";";

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lineData = explode($delimiter, $line);

                if(is_numeric(trim($lineData[0], '"'))){
                    // extract line data into file array
                    $partner = array(
                        'name' => trim($lineData[1],'"'),
                        'company' => trim($lineData[1],'"'),
                        'street' => trim($lineData[2],'"'),
                        'additional' => trim($lineData[3],'"'),
                        'zip' => trim($lineData[4],'"'),
                        'city' => trim($lineData[5],'"'),
                        'phone' => trim($lineData[8],'"'),
                        'fax' => trim($lineData[9],'"'),
                        'email' => trim($lineData[10],'"'),
                    );

                    // try to find existing partner entry
                    $query = ' SELECT uid ' .
                        ' FROM tx_wservice_domain_model_servicepartner ' .
                        ' WHERE pid = ' . $pid .
                        ' AND name = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['name'], 'tx_wservice_domain_model_servicepartner') .
                        ' AND zip = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['zip'], 'tx_wservice_domain_model_servicepartner');
                    $res = $GLOBALS['TYPO3_DB']->sql_query($query);

                    if ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                        //Update existing partner data
                        $query = ' UPDATE tx_wservice_domain_model_servicepartner ' .
                            ' SET ' .
                            ' street = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['street'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            ' additional = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['additional'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            ' city = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['city'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            ' phone = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['phone'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            ' fax = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['fax'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            ' email = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['email'], 'tx_wservice_domain_model_servicepartner') .
                            ' WHERE uid = ' . $row['uid'];

                        $GLOBALS['TYPO3_DB']->sql_query($query);

                    }else{
                        //Insert new partner data
                        $query = ' INSERT INTO tx_wservice_domain_model_servicepartner ' .
                            ' (pid, tstamp, crdate, cruser_id, sys_language_uid, category, name, company, street, additional, zip, city, phone, fax, email) VALUES ( ' .
                            $pid . ', ' . time() . ', ' . time() . ', 0' . ', 0' . ', 3, ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['name'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['company'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['street'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['additional'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['zip'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['city'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['phone'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['fax'], 'tx_wservice_domain_model_servicepartner') . ', ' .
                            $GLOBALS['TYPO3_DB']->fullQuoteStr($partner['email'], 'tx_wservice_domain_model_servicepartner') .
                            ')';
                        $GLOBALS['TYPO3_DB']->sql_query($query);
                    }
                }
            }
        }

        fclose($handle);

    }

    function convertXLStoCSV($infile){

        $fileType = \PHPExcel_IOFactory::identify($infile);
        $objReader = \PHPExcel_IOFactory::createReader($fileType);

        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($infile);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->setDelimiter(';');
        $objWriter->setLineEnding("\r\n");

        $tmpfname = tempnam("/tmp", time());
        $objWriter->save($tmpfname);

        return $tmpfname;
    }

    protected function d($value, $die = FALSE) {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($value);
        if ($die) {
            die;
        }
    }


}
