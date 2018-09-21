<?php

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\YouTube\YouTubeApi;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class YoutubePeopleViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    /**
     * @param string $videosID
     *
     */
    public function render($videosID)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $ApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeApiKey'];
        $channelID = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeChannelID'];

        $yt = new YouTubeApi($ApiKey);
        $yt->setChannelId($channelID);
        $vids=$yt->getVideosById($videosID);
        $eventvids= array();
        if($vids) {
            foreach ($vids as $vid) {
                $evid = array();
                $speakers = explode('(',$vid['modelData']['snippet']['title'])[1];
                array_push($evid, $vid['id']);
                array_push($evid, explode('(',$vid['modelData']['snippet']['title'])[0]);
                array_push($evid, $vid['modelData']['snippet']['thumbnails']['medium']['url']);
                array_push($evid,explode('|',$vid['modelData']['snippet']['title'])[1]);
                array_push($evid,(explode(')',$speakers)[0]));
                array_push($eventvids, $evid);

            }
        }
        return $eventvids;

    }
}