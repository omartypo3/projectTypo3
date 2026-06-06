<?php

declare(strict_types=1);

namespace Emagineurs\ENews\Xclass;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Service\ExtensionService;

class ExtensionServiceXclassed extends ExtensionService
{
    public function getPluginNameByAction(string $extensionName, string $controllerName, ?string $actionName): ?string
    {
        if (($pluginName = $this->getPluginNameFromFrameworkConfiguration($extensionName, $controllerName, $actionName)) !== null) {
            return $pluginName;
        }

        $plugins = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions'][$extensionName]['plugins'] ?? false;
        if (!$plugins) {
            return null;
        }
        $pluginNames = [];
        foreach ($plugins as $pluginName => $pluginConfiguration) {
            $controllers = $pluginConfiguration['controllers'] ?? [];
            $controllerAliases = array_column($controllers, 'actions', 'alias');

            foreach ($controllerAliases as $pluginControllerName => $pluginControllerActions) {
                $pluginControllerNameString = (string)$pluginControllerName;
                if (strtolower($pluginControllerNameString) !== strtolower($controllerName)) {
                    continue;
                }
                if (in_array($actionName, $pluginControllerActions, true)) {
                    $pluginNames[] = $pluginName;
                }
            }
        }
        return !empty($pluginNames) ? $pluginNames[0] : null;
    }

    private function getPluginNameFromFrameworkConfiguration(string $extensionName, string $controllerAlias, ?string $actionName): ?string
    {
        if ($actionName === null) {
            return null;
        }

        $frameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        if (!is_string($pluginName = ($frameworkConfiguration['pluginName'] ?? null))) {
            return null;
        }

        $configuredExtensionName = $frameworkConfiguration['extensionName'] ?? '';
        $configuredExtensionName = is_string($configuredExtensionName) ? $configuredExtensionName : '';

        if ($configuredExtensionName === '' || $configuredExtensionName !== $extensionName) {
            return null;
        }

        $configuredControllers = $frameworkConfiguration['controllerConfiguration'] ?? [];
        $configuredControllers = is_array($configuredControllers) ? $configuredControllers : [];

        $configuredActionsByControllerAliases = array_column($configuredControllers, 'actions', 'alias');

        $actions = $configuredActionsByControllerAliases[$controllerAlias] ?? [];
        $actions = is_array($actions) ? $actions : [];

        return in_array($actionName, $actions, true) ? $pluginName : null;
    }
}

