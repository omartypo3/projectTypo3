<?php
namespace Logifacttheme\Logifact\ViewHelpers;


use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetSettingsViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('extensionKey', 'string', 'The extension key to get the setting form', true);
        $this->registerArgument('settingKey', 'string', 'key of the setting to get', true);
    }

    /**
     * @return mixed
     */
 public function render( ){

     $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
     $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
     $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
     $setting = $extbaseFrameworkConfiguration['plugin.'][$this->arguments['extensionKey'].'.']['settings.'][$this->arguments['settingKey']];
     return $setting;
 }
}