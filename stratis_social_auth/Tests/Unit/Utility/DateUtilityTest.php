<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Tests\Unit\Utility;

use Hybridauth\User\Profile;
use PHPUnit\Framework\TestCase;
use Stratis\StratisSocialAuth\Utility\DateUtility;

/**
 * Class DateUtilityTest
 * @package Stratis\StratisSocialAuth\Tests\Unit\Utility
 */
class DateUtilityTest extends TestCase
{
    public function testGetDateOfBirth()
    {

        $target = 0;
        $profile = new Profile();
        $this->assertEquals($target, DateUtility::getDateOfBirth($profile));

        $profile->birthDay = 12;
        $profile->birthMonth = 10;
        $profile->birthYear = 1989;

        $target = 600000000;
        $this->assertGreaterThan($target, DateUtility::getDateOfBirth($profile));
    }
}
