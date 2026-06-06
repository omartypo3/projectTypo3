<?php

namespace Freelance\Glos\ViewHelpers;


use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class GetSettingsViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
    }



    /**
     * @return string
     */
    public function render()
    {
        $configurationManager =\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');


        $typoScript = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );

        // Access settings
        $settings = $typoScript['page.']['10.']['settings.'] ?? [];
        return $settings;

    }
}