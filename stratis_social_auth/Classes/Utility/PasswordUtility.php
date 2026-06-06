<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

use Stratis\StratisServices\DependencyInjection\ContainerStaticAwareTrait;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;

/**
 * Class PasswordUtility
 * @package Stratis\StratisSocialAuth\Utility
 */
class PasswordUtility
{
    use ContainerStaticAwareTrait;

    /**
     * @param int $length Length of new password
     *
     * @return string New password
     */
    public static function generatePassword(int $length = 8): string
    {
        $password = '';
        while ($length--) {
            $character = rand(0, 35);
            if ($character < 10) {
                $password .= '' . $character;
            } else {
                $password .= chr($character - 10 + 97);
            }
        }

        return $password;
    }

    /**
     * @param string $password
     *
     * @return string
     */
    public static function encryptNewPassword(string $password): string
    {
        $passwordHashFactory = self::getContainer()->get(PasswordHashFactory::class);
        $objInstanceSaltedPW = $passwordHashFactory->getDefaultHashInstance('FE');

        return $objInstanceSaltedPW->getHashedPassword($password);
    }
}
