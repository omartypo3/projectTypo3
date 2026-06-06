<?php
namespace  DslFactory\DslImmo\Utility;

/**
 * Utility class for Views
 *
 * @package TYPO3
 * @subpackage tx_dslimmo
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
     * @param string $controllerName
     * @param string $pluginName
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
	public function getView($template,$controllerExtensionName = "",$controllerName = "",$pluginName = "")
	{


		$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$dbView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        if($controllerExtensionName) $dbView->getRequest()->setControllerExtensionName($controllerExtensionName);
		if($controllerName) $dbView->getRequest()->setControllerName($controllerName);
		if($pluginName) $dbView->getRequest()->setPluginName($pluginName);

		$dbView->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);
        $dbView->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
        $dbView->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);


		$dbView->setTemplate($template);

		//$dbView->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths']) . $template);

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