<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

/**
 * Class StringUtility
 * @package Stratis\StratisSocialAuth\Utility
 */
class StringUtility
{
    /**
     * @param string|null $string
     *
     * @return string
     */
    public static function sanitize(string $string = null): string
    {
        if ($string === '' || $string === null) {
            return '';
        }

        $string = strip_tags($string);
        $string = preg_replace('/\s{2,}/', ' ', $string);
        $string = trim($string);

        if (mb_check_encoding($string, 'UTF-8') === false) {
            $string = self::encodeToUtf8($string);
        }

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function removeWhitespaces(string $string): string
    {
        return preg_replace('/\s{1}/', ' ', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function encodeToUtf8(string $string): string
    {
        $encoding = mb_detect_encoding($string, ['UTF-8', 'ISO-8859-1', 'ISO-8859-15'], true);

        return mb_convert_encoding($string, "UTF-8", $encoding);
    }

    /**
     * @return string
     */
    public static function getRandomString(): string
    {
        return md5(uniqid((string)rand(), true));
    }
}
