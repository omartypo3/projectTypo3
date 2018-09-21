<?php

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\Flickr\Flickr;
use TYPO3\CMS\Core\Utility\DebugUtility;

class FlickrViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{


    /**
     * @param int $albumId
     *
     */
    public function render($albumId)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $flickrApiKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['flickrApiKey'];
        $f = new Flickr($flickrApiKey);

        $recent = $f->photosets_getPhotos($albumId);

        $album = $recent['photoset']['photo'];
        $imagesUrl = array();
        foreach ($album as $k => $v) {
            $photo = $f->photos_getSizes($v['id']);
            array_push($imagesUrl, $photo[5]['source']);
        }
        return $imagesUrl;
    }
}