<?php

namespace DslFactory\DslIntranet\Utility;


/**
 * Utility class for Views
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class ViewUtility 
{


	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }


	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	


    /**
     * 
     * @param string $template
     * @param string $controllerExtensionName
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
	public function getView($template,$controllerExtensionName)
	{
		
		//Auftraege/ListJSONDataTable.html
		
		
		$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		
		
		$dbView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $dbView->getRequest()->setControllerExtensionName($controllerExtensionName);
		
		$template1 = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]) . $template;
		$template2 = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][1]) . $template;
		
		
		if(is_array($extbaseFrameworkConfiguration['view']['templateRootPaths'])){
			foreach($extbaseFrameworkConfiguration['view']['templateRootPaths'] as $templateDir){
				$templateDirAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($templateDir) . $template;
				if(file_exists($templateDirAndFilename))	if(is_file($templateDirAndFilename)) $templatePathAndFilename = $templateDirAndFilename;
			}
		} 
		
		if($templatePathAndFilename) $dbView->setTemplatePathAndFilename($templatePathAndFilename);
		
		
		if(is_array($extbaseFrameworkConfiguration['view']['layoutRootPaths'])){
			$dbView->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
		} else {
			$dbView->setLayoutRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPaths'][0]));
		}
		//$dbView->setLayoutRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPaths'][0]));
		
		if(is_array($extbaseFrameworkConfiguration['view']['partialRootPaths'])){
			$dbView->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
		} else {
			$dbView->setPartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPaths'][0]));
		}
      	// $dbView->setPartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPaths'][0]));
		
		return $dbView;
		
	}
	
	
	/** @var $logger \TYPO3\CMS\Core\Log\Logger */
/*        $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        $logger->info('Everything went fine.');
        $logger->warning('Something went awry, check your configuration!');
        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'This is an utter failure!');*/
	


//$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Templates/');
//$templateLayoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Layouts/');
//$templatePartialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Partials/');
//$templatePathAndFilenameKunde = $templateRootPath . 'Protokolle/' . $mailTemplate . '.html';
//$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
//$viewAnKunde = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
//settings
//$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
//$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
//$settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
//['plugin.']['tx_dslintranet.']['settings'];
//$viewAnKunde->setLayoutRootPath($templateLayoutRootPath);
//$viewAnKunde->setPartialRootPath($templatePartialRootPath);
 //$viewAnKunde->setTemplatePathAndFilename($templatePathAndFilenameKunde);



}