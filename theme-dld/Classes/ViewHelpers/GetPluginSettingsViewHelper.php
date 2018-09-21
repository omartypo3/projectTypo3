<?php

namespace Theme\ViewHelpers;


class GetPluginSettingsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $pluginname
     *
     */
    public function render($pluginname)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $extbaseFrameworkConfiguration['plugin.'][$pluginname . '.']['settings.'];
        return $settings;
    }
}