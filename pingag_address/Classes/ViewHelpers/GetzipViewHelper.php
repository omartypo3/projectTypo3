<?php
/**
 * Created by Visual Studio Code.
 * User: markus
 * Date: 26.06.17
 * Time: 15:57
 */

namespace Pingag\PingagAddress\ViewHelpers;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use Pingag\PingagClicConnector\Domain\Repository\ServiceRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;

class GetzipViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('zip','int','The record to be matched',true);

    }

    /**
     *
     * @return string
     */
    public function render()
    {

        $opts = array('http' => array('header' => "User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        $json = file_get_contents('https://nominatim.openstreetmap.org/?q=switzerland,' . $this->arguments['zip'] . '&format=json', false, $context);
        $data = json_decode($json, true);
        foreach ($data as $data1) {
            $lati = $data1['lat'];
            $longi = $data1['lon'];
            // put the data in the array
            $data_arr = array();

            array_push(
                $data_arr,
                $lati,
                $longi
            );
            return $data_arr;

        }
    }
}

