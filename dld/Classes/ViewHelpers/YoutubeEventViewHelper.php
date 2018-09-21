<?php

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\YouTube\YouTubeApi;

class YoutubeEventViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    /**
     * @param string $playListID
     *
     */
    public function render($playListID)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $ApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeApiKey'];
        $channelID = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['youTubeChannelID'];

        $yt = new YouTubeApi($ApiKey);
        $yt->setChannelId($channelID);
        $vids = $yt->getPlaylistVideos($playListID);
        $eventvids = array();
        if ($vids) {
            foreach ($vids as $vid) {
                $evid = array();
                array_push($evid, $vid['modelData']['snippet']['resourceId']['videoId']);
                array_push($evid, $vid['modelData']['snippet']['title']);
                array_push($evid, $vid['modelData']['snippet']['thumbnails']['medium']['url']);
                array_push($eventvids, $evid);
            }
        }
        return $eventvids;

    }
}