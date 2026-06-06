<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ConfigurationUtility
 * @package Stratis\StratisSocialAuth\Utility
 */
class ConfigurationUtility
{
    /**
     * @return array
     */
    public static function getConfiguration(): array
    {
        return GeneralUtility::removeDotsFromTS($GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function getConfigurationValue(string $key): string
    {
        return self::getConfiguration()[$key] ?? '';
    }

    /**
     * @param array $provider
     *
     * @return array
     */
    public static function getProviderConfiguration(array $provider): array
    {
        $config = [
            'enabled' => !(bool)$provider['hidden'],
            'keys' => [
                'key' => $provider['key_id'],
                'secret' => $provider['key_secret'],
            ],
            'scope' => $provider['scope'],
            'acr_values' => $provider['acr_values'],
            'openid_identifier' => $provider['open_id_url'],
        ];

        $customProviderClassName = 'Stratis\\StratisSocialAuth\\Middleware\\HybridAuthProvider\\' . $provider['type'];

        if (class_exists($customProviderClassName)) {
            $config['adapter'] = $customProviderClassName;
        }

        return [$provider['type'] => $config];
    }
}
