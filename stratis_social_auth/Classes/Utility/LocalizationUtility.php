<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility as ExtbaseLocalizationUtility;

/**
 * Class LocalizationUtility
 * @package Stratis\StratisSocialAuth\Utility
 */
class LocalizationUtility
{
    /**
     * @param string $message
     * @param array $arguments
     * @return string
     */
    public static function translateMessage(string $message, array $arguments = []): string
    {
        return ExtbaseLocalizationUtility::translate($message, 'StratisSocialAuth', $arguments);
    }
}
