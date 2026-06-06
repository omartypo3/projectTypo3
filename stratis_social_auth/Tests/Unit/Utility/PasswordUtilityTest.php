<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Tests\Unit\Utility;

use PHPUnit\Framework\TestCase;
use Stratis\StratisSocialAuth\Utility\PasswordUtility;

/**
 * Class PasswordUtilityTest
 * @package Stratis\StratisSocialAuth\Tests\Unit\Utility
 */
class PasswordUtilityTest extends TestCase
{
    public function testGeneratePassword()
    {
        $length = 10;

        $password = PasswordUtility::generatePassword($length);

        $this->assertEquals($length, strlen($password));
    }
}
