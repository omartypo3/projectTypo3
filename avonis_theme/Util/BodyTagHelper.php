<?php
namespace Avonis\AvonisTheme\Util;

class BodyTagHelper {
    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    public $cObj;

    public function buildBodyTag() {

        /* @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        /* @var $pageProvider \FluidTYPO3\Fluidpages\Provider\PageProvider */
        $pageProvider = $objectManager->get('FluidTYPO3\\Fluidpages\\Provider\\PageProvider');

        $pageControllerActionName = $pageProvider->getControllerActionFromRecord(array('uid' => $GLOBALS['TSFE']->id));

        switch ($pageControllerActionName) {
            case 'startpage':
                $bodyClass = 'stretched no-transition';
                break;
            case '2ndpage':
                $bodyClass = '123';
                break;
            case '3rdpage':
                $bodyClass = '321';
                break;
        }

        return '<body class="' . $bodyClass . '">';
    }
}