<?php

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\Flickr\Flickr;
use TYPO3\CMS\Core\Utility\DebugUtility;

class FlickrAllAlbumsViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    public function render()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $flickrApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrApiKey'];
        $userid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrUserId'];
        $f = new Flickr($flickrApiKey);

        $recent = $f->photosets_getList($userid);
        $albums = $recent['photoset'];
        $flickralbums = array();
        foreach ($albums as $k => $v) {
            $album = array();
            array_push($album, $v['photos']);
            array_push($album, $v['title']['_content']);
            array_push($album, $f->photos_getSizes($v['primary'])[4]['source']);
            array_push($album, 'https://www.flickr.com/photos/'.$userid.'/albums/'.$v['id']);
            array_push($flickralbums, $album);
        }
        return $flickralbums;
    }
}