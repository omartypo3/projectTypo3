<?php

namespace BravoBuero\BbPortfolio\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ViewUtility
{
    public static $instance;

    public function __construct()
    {
        self::$instance = $this;
    }

    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $template
     * @param string $controllerExtensionName
     * @param string $controllerName
     * @param string $pluginName
     * @return StandaloneView
     */
    public function getView(
        string $template,
        string $controllerExtensionName = '',
        string $controllerName = '',
        string $pluginName = ''
    ) {
        /** @var ConfigurationManager $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        
        $dbView = GeneralUtility::makeInstance(StandaloneView::class);

        // Set template, layout, and partial paths
        $dbView->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths'] ?? []);
        $dbView->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths'] ?? []);
        $dbView->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths'] ?? []);


        // Assign template
        $dbView->setTemplate($template);

        return $dbView;
    }
}
