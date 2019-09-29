<?php
namespace LeadGeneration\ContactForm\ViewHelpers;


use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class GetSettingsViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('extensionKey', 'string', 'The email address to resolve the gravatar for', true);
        $this->registerArgument('settingKey', 'string', 'The email address to resolve the gravatar for', true);
    }
    use CompileWithRenderStatic;

 public function render(){

     $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
     $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
     $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
     $setting = $extbaseFrameworkConfiguration['plugin.'][$this->arguments['extensionKey'].'.']['settings.'][$this->arguments['settingKey']];
     return $setting;
 }
}
