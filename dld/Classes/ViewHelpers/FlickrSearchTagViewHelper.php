<?php

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\Flickr\Flickr;
use TYPO3\CMS\Core\Utility\DebugUtility;

class FlickrSearchTagViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    /**
     * @param int $albumId
     *
     */
    public function render($tags)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $flickrApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrApiKey'];
        $userid = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickruserid'];
        $f = new Flickr($flickrApiKey);

        $recent = $f->photos_search(array('tags' => substr($tags, 1, -1)));
        $album = $recent['photoset']['photo'];

        $imagesUrl = array();
     if ($album){
        foreach ($album as $k => $v) {
            $image = array();
            $description = $f->photos_getInfo($v['id'])['photo']['description']['_content'];
            $photo = $f->photos_getSizes($v['id']);
            array_push($image, $photo[5]['source']);
            array_push($image,$description);
            array_push($imagesUrl,$image);
            if ($k == 5)
            {
                break;
            }
        }
     }
        return $imagesUrl;
    }
}