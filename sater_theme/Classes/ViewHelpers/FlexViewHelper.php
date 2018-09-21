<?php

namespace SaterTheme\ViewHelpers;
use TYPO3\CMS\Core\Utility\GeneralUtility;
class FlexViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param string $xmlstring
     */
    public function render($xmlstring)
    {
        $flexformService = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
        $content = $flexformService->convertFlexFormContentToArray($xmlstring);
        return $content;
    }




}


