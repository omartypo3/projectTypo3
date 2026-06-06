<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

use Hybridauth\User\Profile;

class DateUtility
{
    /**
     * @param Profile $profile
     *
     * @return int
     */
    public static function getDateOfBirth(Profile $profile): int
    {
        if ($profile->birthDay > 0 && $profile->birthMonth > 0 && $profile->birthYear > 0) {
            return strtotime($profile->birthDay . "-" . $profile->birthMonth . "-" . $profile->birthYear);
        }

        return 0;
    }
}
