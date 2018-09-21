<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 23/05/2018
 * Time: 14:16
 */
namespace DLD\Dld\highrise;

class Cron extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    public function execute()
    {
        // TODO: Implement execute() method.
        $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
        $url = 'https://softodo.highrisehq.com/people.xml ';

        $xml = file_get_contents($url, false, $context);
        $xml = simplexml_load_string($xml);
       \TYPO3\CMS\Core\Utility\DebugUtility::debug($xml);
    }
}
