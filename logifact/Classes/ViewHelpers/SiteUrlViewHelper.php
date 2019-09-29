<?php

namespace Logifacttheme\Logifact\ViewHelpers;



use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class SiteUrlViewHelper extends AbstractViewHelper
{

    /**
     * @return string
     */
    public function render()
    {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => $GLOBALS['TSFE']->rootLine[0]['uid'],
                'forceAbsoluteUrl' => true,
            )
        );
        return $url;

    }
}